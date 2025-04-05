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
                <div class="input-group">
                    <label for="firewallInput">방화벽 설정 입력:</label>
                    <input type="text" id="firewallInput" placeholder="예: 192.168.0.1:80">
                    <button class="btn" onclick="checkFirewall()">점검</button>
                </div>
                <div class="result" id="firewallResult">
                    <h3>결과</h3>
                    <pre id="resultText">방화벽 설정을 입력하고 '점검' 버튼을 클릭하세요.</pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkFirewall() {
            const firewallInput = document.getElementById('firewallInput').value.trim();
            const resultText = document.getElementById('resultText');

            if (!firewallInput) {
                resultText.textContent = '방화벽 설정을 입력하세요.';
                return;
            }

            // 방화벽 점검 로직 (예시)
            resultText.textContent = '방화벽 점검 중...';

            // 실제 방화벽 점검 로직은 서버 측에서 구현해야 합니다.
            // 이 예제에서는 클라이언트 측에서의 구현을 생략합니다.
        }
    </script>
</body>
</html> 