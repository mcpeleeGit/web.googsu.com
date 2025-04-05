<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>무게 변환</title>
    <meta name="description" content="다양한 단위의 무게를 상호 변환할 수 있는 도구입니다.">
    <meta property="og:title" content="무게 변환">
    <meta property="og:description" content="다양한 단위의 무게를 상호 변환할 수 있는 도구입니다.">
    <meta property="og:url" content="https://googsu.com/008-unit-converter/weight">
    <meta property="og:image" content="https://googsu.com/images/weight-converter-og-image.png">
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
                    <label for="weightInput">무게 입력:</label>
                    <input type="number" id="weightInput" placeholder="예: 100">
                </div>
                <div class="input-group">
                    <label for="unitSelect">단위 선택:</label>
                    <select id="unitSelect">
                        <option value="kilograms">킬로그램</option>
                        <option value="grams">그램</option>
                        <option value="milligrams">밀리그램</option>
                        <option value="pounds">파운드</option>
                        <option value="ounces">온스</option>
                        <option value="stones">스톤</option>
                    </select>
                </div>
                <button class="btn" onclick="convertWeight()">변환</button>
                <div class="result" id="conversionResult">
                    <h3>결과</h3>
                    <pre id="resultText">무게를 입력하고 단위를 선택한 후 '변환' 버튼을 클릭하세요.</pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        function convertWeight() {
            const weightInput = parseFloat(document.getElementById('weightInput').value);
            const unitSelect = document.getElementById('unitSelect').value;
            const resultText = document.getElementById('resultText');

            if (isNaN(weightInput)) {
                resultText.textContent = '유효한 무게를 입력하세요.';
                return;
            }

            // 무게 변환 로직 (예시)
            let convertedWeight;
            switch (unitSelect) {
                case 'kilograms':
                    convertedWeight = weightInput;
                    break;
                case 'grams':
                    convertedWeight = weightInput * 1000;
                    break;
                case 'milligrams':
                    convertedWeight = weightInput * 1000000;
                    break;
                case 'pounds':
                    convertedWeight = weightInput * 2.20462;
                    break;
                case 'ounces':
                    convertedWeight = weightInput * 35.274;
                    break;
                case 'stones':
                    convertedWeight = weightInput * 0.157473;
                    break;
                default:
                    convertedWeight = weightInput;
            }

            resultText.textContent = `변환된 무게: ${convertedWeight.toFixed(2)} ${unitSelect}`;
        }
    </script>
</body>
</html> 