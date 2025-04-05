<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>방화벽 체크</title>
    <meta name="description" content="네트워크 방화벽 설정을 점검하고 보안 상태를 확인합니다.">
    <meta property="og:title" content="방화벽 체크">
    <meta property="og:description" content="네트워크 방화벽 설정을 점검하고 보안 상태를 확인합니다.">
    <meta property="og:url" content="https://googsu.com/007-security-tools/firewall-check">
    <meta property="og:image" content="https://googsu.com/images/firewall-check-og-image.png">
    <style>
        .firewall-check-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .input-group input {
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
        }

        .btn {
            padding: 10px 20px;
            background-color: #1971c2;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn:hover {
            background-color: #1864ab;
        }

        .result {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="firewall-check-container">
                <button class="btn" onclick="startDiagnosis()">진단 시작</button>
                <div class="result" id="diagnosisResult">
                    <h3>진단 결과</h3>
                    <ul id="resultList">
                        <li>WebSocket 연결 테스트: <span id="websocketResult">대기 중...</span></li>
                        <li>TURN 서버: <span id="turnResult">대기 중...</span></li>
                    </ul>
                    <div>
                        <h4>환경 정보:</h4>
                        <p>브라우저: <span id="browserInfo"></span> / OS: <span id="osInfo"></span></p>
                        <p>IP: <span id="ipInfo"></span> / ISP: <span id="ispInfo"></span></p>
                    </div>
                    <button class="btn" onclick="showSolutionGuide()">문제 해결 방법 보기</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function startDiagnosis() {
            // WebSocket 연결 테스트
            const ws = new WebSocket('wss://echo.websocket.org');
            ws.onopen = () => {
                document.getElementById('websocketResult').textContent = '성공';
                ws.close();
            };
            ws.onerror = () => {
                document.getElementById('websocketResult').textContent = '실패';
            };

            // TURN 서버 연결 체크 (예시)
            document.getElementById('turnResult').textContent = '연결 불가';

            // 환경 정보 수집
            document.getElementById('browserInfo').textContent = navigator.userAgent;
            document.getElementById('osInfo').textContent = navigator.platform;

            fetch('http://ip-api.com/json')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('ipInfo').textContent = data.query;
                    document.getElementById('ispInfo').textContent = data.isp;
                })
                .catch(error => {
                    document.getElementById('ipInfo').textContent = '정보를 가져올 수 없습니다';
                    document.getElementById('ispInfo').textContent = '정보를 가져올 수 없습니다';
                });
        }

        function showSolutionGuide() {
            alert('문제 해결 방법을 안내합니다.');
        }
    </script>
</body>
</html> 