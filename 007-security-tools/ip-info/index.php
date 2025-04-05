<?php
function getIPInfo($ip) {
    $url = "http://ip-api.com/json/{$ip}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = $_POST['ip'] ?? '';
    $ipInfo = getIPInfo($ip);
    echo json_encode($ipInfo);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>IP 정보 확인</title>
    <meta name="description" content="IP 주소의 위치 및 기타 정보를 확인할 수 있는 도구입니다.">
    <meta property="og:title" content="IP 정보 확인">
    <meta property="og:description" content="IP 주소의 위치 및 기타 정보를 확인할 수 있는 도구입니다.">
    <meta property="og:url" content="https://googsu.com/007-security-tools/ip-info">
    <meta property="og:image" content="https://googsu.com/images/ip-info-og-image.png">
    <style>
        .ip-info-container {
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
            <div class="ip-info-container">
                <div class="input-group">
                    <label for="ipInput">IP 주소 입력:</label>
                    <input type="text" id="ipInput" placeholder="예: 192.168.1.1">
                    <button class="btn" onclick="checkIPInfo()">IP 정보 확인</button>
                </div>
                <div class="result" id="userIpResult">
                    <h3>당신의 공인 IP 주소</h3>
                    <pre id="userIpText">IP 주소를 확인 중...</pre>
                </div>
                <div class="result" id="ipResult">
                    <h3>결과</h3>
                    <pre id="resultText">IP 주소를 입력하고 'IP 정보 확인' 버튼을 클릭하세요.</pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const response = await fetch('https://api.ipify.org?format=json');
                const data = await response.json();
                const ip = data.ip;
                
                // IP 정보 표시
                document.getElementById('userIpText').textContent = ip;
            } catch (error) {
                console.error('IP 주소를 가져오는데 실패했습니다:', error);
                document.getElementById('userIpText').textContent = '오류 발생';
            }
        });

        function checkIPInfo() {
            const ipInput = document.getElementById('ipInput').value.trim();
            const resultText = document.getElementById('resultText');

            if (!ipInput) {
                resultText.textContent = 'IP 주소를 입력하세요.';
                return;
            }

            resultText.textContent = 'IP 정보 확인 중...';

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    ip: ipInput
                })
            })
            .then(response => response.json())
            .then(data => {
                resultText.textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                resultText.textContent = 'IP 정보를 가져오는 중 오류가 발생했습니다.';
            });
        }
    </script>
</body>
</html> 