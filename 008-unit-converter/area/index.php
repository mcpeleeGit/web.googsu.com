<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>면적 변환</title>
    <meta name="description" content="다양한 단위의 면적을 상호 변환할 수 있는 도구입니다.">
    <meta property="og:title" content="면적 변환">
    <meta property="og:description" content="다양한 단위의 면적을 상호 변환할 수 있는 도구입니다.">
    <meta property="og:url" content="https://googsu.com/008-unit-converter/area">
    <meta property="og:image" content="https://googsu.com/images/area-converter-og-image.png">
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
                    <label for="areaInput">면적 입력:</label>
                    <input type="number" id="areaInput" placeholder="예: 100">
                </div>
                <div class="input-group">
                    <label for="unitSelect">단위 선택:</label>
                    <select id="unitSelect">
                        <option value="squareMeters">제곱미터</option>
                        <option value="squareKilometers">제곱킬로미터</option>
                        <option value="squareCentimeters">제곱센티미터</option>
                        <option value="squareMillimeters">제곱밀리미터</option>
                        <option value="squareInches">제곱인치</option>
                        <option value="squareFeet">제곱피트</option>
                        <option value="squareYards">제곱야드</option>
                        <option value="acres">에이커</option>
                        <option value="hectares">헥타르</option>
                    </select>
                </div>
                <button class="btn" onclick="convertArea()">변환</button>
                <div class="result" id="conversionResult">
                    <h3>결과</h3>
                    <pre id="resultText">면적을 입력하고 단위를 선택한 후 '변환' 버튼을 클릭하세요.</pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        function convertArea() {
            const areaInput = parseFloat(document.getElementById('areaInput').value);
            const unitSelect = document.getElementById('unitSelect').value;
            const resultText = document.getElementById('resultText');

            if (isNaN(areaInput)) {
                resultText.textContent = '유효한 면적을 입력하세요.';
                return;
            }

            // 면적 변환 로직 (예시)
            let convertedArea;
            switch (unitSelect) {
                case 'squareMeters':
                    convertedArea = areaInput;
                    break;
                case 'squareKilometers':
                    convertedArea = areaInput / 1e6;
                    break;
                case 'squareCentimeters':
                    convertedArea = areaInput * 1e4;
                    break;
                case 'squareMillimeters':
                    convertedArea = areaInput * 1e6;
                    break;
                case 'squareInches':
                    convertedArea = areaInput * 1550.003;
                    break;
                case 'squareFeet':
                    convertedArea = areaInput * 10.7639;
                    break;
                case 'squareYards':
                    convertedArea = areaInput * 1.19599;
                    break;
                case 'acres':
                    convertedArea = areaInput / 4046.86;
                    break;
                case 'hectares':
                    convertedArea = areaInput / 10000;
                    break;
                default:
                    convertedArea = areaInput;
            }

            resultText.textContent = `변환된 면적: ${convertedArea.toFixed(2)} ${unitSelect}`;
        }
    </script>
</body>
</html> 