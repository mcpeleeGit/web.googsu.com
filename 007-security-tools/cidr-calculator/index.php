<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>CIDR 계산기</title>
    <meta name="description" content="CIDR 표기법을 사용하여 네트워크 범위를 계산합니다.">
    <meta property="og:title" content="CIDR 계산기">
    <meta property="og:description" content="CIDR 표기법을 사용하여 네트워크 범위를 계산합니다.">
    <meta property="og:url" content="https://googsu.com/007-security-tools/cidr-calculator">
    <meta property="og:image" content="https://googsu.com/images/cidr-calculator-og-image.png">
    <style>
        .cidr-calculator-container {
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
            <div class="cidr-calculator-container">
                <div class="input-group">
                    <label for="cidrInput">CIDR 표기법 입력:</label>
                    <input type="text" id="cidrInput" placeholder="예: 192.168.0.0/24">
                    <button class="btn" onclick="calculateCIDR()">계산</button>
                </div>
                <div class="result" id="cidrResult">
                    <h3>결과</h3>
                    <pre id="resultText">CIDR 표기법을 입력하고 '계산' 버튼을 클릭하세요.</pre>
                </div>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>

    <script>
        function calculateCIDR() {
            const cidrInput = document.getElementById('cidrInput').value.trim();
            const resultText = document.getElementById('resultText');

            if (!cidrInput) {
                resultText.textContent = 'CIDR 표기법을 입력하세요.';
                return;
            }

            const [ip, prefixLength] = cidrInput.split('/');
            if (!ip || !prefixLength || isNaN(prefixLength)) {
                resultText.textContent = '유효한 CIDR 표기법을 입력하세요.';
                return;
            }

            const subnetMask = -1 << (32 - parseInt(prefixLength));
            const ipParts = ip.split('.').map(Number);
            const ipAddress = (ipParts[0] << 24) | (ipParts[1] << 16) | (ipParts[2] << 8) | ipParts[3];
            const networkAddress = ipAddress & subnetMask;
            const broadcastAddress = networkAddress | ~subnetMask;

            const networkAddressStr = [
                (networkAddress >>> 24) & 255,
                (networkAddress >>> 16) & 255,
                (networkAddress >>> 8) & 255,
                networkAddress & 255
            ].join('.');

            const broadcastAddressStr = [
                (broadcastAddress >>> 24) & 255,
                (broadcastAddress >>> 16) & 255,
                (broadcastAddress >>> 8) & 255,
                broadcastAddress & 255
            ].join('.');

            let ipList = '';
            for (let i = networkAddress + 1; i < broadcastAddress; i++) {
                const ipStr = [
                    (i >>> 24) & 255,
                    (i >>> 16) & 255,
                    (i >>> 8) & 255,
                    i & 255
                ].join('.');
                ipList += ipStr + '\t';
                if ((i - networkAddress) % 7 === 0) ipList += '\n';
            }

            resultText.textContent = `네트워크 주소: ${networkAddressStr}\n브로드캐스트 주소: ${broadcastAddressStr}\n\nIP 목록:\n${ipList}`;
        }
    </script>
</body>
</html> 