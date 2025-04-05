<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>길이 변환</title>
    <meta name="description" content="다양한 단위의 길이를 상호 변환할 수 있는 도구입니다.">
    <meta property="og:title" content="길이 변환">
    <meta property="og:description" content="다양한 단위의 길이를 상호 변환할 수 있는 도구입니다.">
    <meta property="og:url" content="https://googsu.com/008-unit-converter/length">
    <meta property="og:image" content="https://googsu.com/images/length-converter-og-image.png">
    <style>
        .converter-container {
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
            <div class="converter-container">
                <div class="input-group">
                    <label for="lengthInput">길이 입력:</label>
                    <input type="number" id="lengthInput" placeholder="예: 100">
                </div>
                <div class="input-group">
                    <label for="unitSelect">단위 선택:</label>
                    <select id="unitSelect">
                        <option value="meters">미터</option>
                        <option value="kilometers">킬로미터</option>
                        <option value="centimeters">센티미터</option>
                        <option value="millimeters">밀리미터</option>
                        <option value="inches">인치</option>
                        <option value="feet">피트</option>
                        <option value="yards">야드</option>
                        <option value="miles">마일</option>
                    </select>
                </div>
                <button class="btn" onclick="convertLength()">변환</button>
                <div class="result" id="conversionResult">
                    <h3>결과</h3>
                    <pre id="resultText">길이를 입력하고 단위를 선택한 후 '변환' 버튼을 클릭하세요.</pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        function convertLength() {
            const lengthInput = parseFloat(document.getElementById('lengthInput').value);
            const unitSelect = document.getElementById('unitSelect').value;
            const resultText = document.getElementById('resultText');

            if (isNaN(lengthInput)) {
                resultText.textContent = '유효한 길이를 입력하세요.';
                return;
            }

            // 길이 변환 로직 (예시)
            let convertedLength;
            switch (unitSelect) {
                case 'meters':
                    convertedLength = lengthInput;
                    break;
                case 'kilometers':
                    convertedLength = lengthInput / 1000;
                    break;
                case 'centimeters':
                    convertedLength = lengthInput * 100;
                    break;
                case 'millimeters':
                    convertedLength = lengthInput * 1000;
                    break;
                case 'inches':
                    convertedLength = lengthInput * 39.3701;
                    break;
                case 'feet':
                    convertedLength = lengthInput * 3.28084;
                    break;
                case 'yards':
                    convertedLength = lengthInput * 1.09361;
                    break;
                case 'miles':
                    convertedLength = lengthInput / 1609.34;
                    break;
                default:
                    convertedLength = lengthInput;
            }

            resultText.textContent = `변환된 길이: ${convertedLength.toFixed(2)} ${unitSelect}`;
        }
    </script>
</body>
</html> 