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
                    <label for="lengthInput">길이 입력:</label>
                    <input type="number" id="lengthInput" placeholder="예: 100" oninput="convertLength()">
                    <select id="unitSelect" onchange="convertLength()">
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
                <div class="result" id="conversionResult">
                    <!-- Conversion results will be dynamically inserted here -->
                </div>
                <button class="btn" onclick="showUnitInfo()">ℹ️ 단위 설명 보기</button>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>

    <script>
        function convertLength() {
            const lengthInput = parseFloat(document.getElementById('lengthInput').value);
            const inputUnit = document.getElementById('unitSelect').value;
            const resultContainer = document.getElementById('conversionResult');

            if (isNaN(lengthInput)) {
                resultContainer.innerHTML = '<div class="result-item">유효한 길이를 입력하세요.</div>';
                return;
            }

            const conversionFactors = {
                meters: 1,
                kilometers: 0.001,
                centimeters: 100,
                millimeters: 1000,
                inches: 39.3701,
                feet: 3.28084,
                yards: 1.09361,
                miles: 0.000621371
            };

            const unitNames = {
                meters: '미터',
                kilometers: '킬로미터',
                centimeters: '센티미터',
                millimeters: '밀리미터',
                inches: '인치',
                feet: '피트',
                yards: '야드',
                miles: '마일'
            };

            const lengthInMeters = lengthInput / conversionFactors[inputUnit];

            const results = Object.keys(conversionFactors).map(unit => {
                const convertedLength = lengthInMeters * conversionFactors[unit];
                return `<div class="result-item">${convertedLength.toFixed(2)} ${unitNames[unit]} <button onclick="copyToClipboard('${convertedLength.toFixed(2)} ${unitNames[unit]}')">복사</button></div>`;
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