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
            flex-direction: row;
            gap: 10px;
            margin-bottom: 20px;
        }

        .input-group label {
            flex: 1;
        }

        .input-group input, .input-group select {
            flex: 2;
            padding: 15px;
            font-size: 18px;
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
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .result-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #f8f9fa;
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
                    <input type="number" id="weightInput" placeholder="예: 100" oninput="convertWeight()">
                    <select id="unitSelect" onchange="convertWeight()">
                        <option value="kilograms">킬로그램</option>
                        <option value="grams">그램</option>
                        <option value="milligrams">밀리그램</option>
                        <option value="pounds">파운드</option>
                        <option value="ounces">온스</option>
                        <option value="stones">스톤</option>
                    </select>
                </div>
                <div class="result" id="conversionResult">
                    <!-- Conversion results will be dynamically inserted here -->
                </div>
                <button class="btn" onclick="showUnitInfo()">ℹ️ 단위 설명 보기</button>
            </div>
        </div>
    </div>

    <script>
        function convertWeight() {
            const weightInput = parseFloat(document.getElementById('weightInput').value);
            const inputUnit = document.getElementById('unitSelect').value;
            const resultContainer = document.getElementById('conversionResult');

            if (isNaN(weightInput)) {
                resultContainer.innerHTML = '<div class="result-item">유효한 무게를 입력하세요.</div>';
                return;
            }

            const conversionFactors = {
                kilograms: 1,
                grams: 1000,
                milligrams: 1000000,
                pounds: 2.20462,
                ounces: 35.274,
                stones: 0.157473
            };

            const unitNames = {
                kilograms: '킬로그램',
                grams: '그램',
                milligrams: '밀리그램',
                pounds: '파운드',
                ounces: '온스',
                stones: '스톤'
            };

            const weightInKilograms = weightInput / conversionFactors[inputUnit];

            const results = Object.keys(conversionFactors).map(unit => {
                const convertedWeight = weightInKilograms * conversionFactors[unit];
                return `<div class="result-item">${convertedWeight.toFixed(2)} ${unitNames[unit]} <button onclick="copyToClipboard('${convertedWeight.toFixed(2)} ${unitNames[unit]}')">복사</button></div>`;
            }).join('');

            resultContainer.innerHTML = results;
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('복사되었습니다: ' + text);
            });
        }

        function showUnitInfo() {
            alert('단위 설명 및 변환 공식은 여기에 표시됩니다.');
        }
    </script>
</body>
</html> 