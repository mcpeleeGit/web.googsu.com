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

        .card {
            background: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin: 10px;
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
                    <label for="areaInput">면적 입력:</label>
                    <input type="number" id="areaInput" placeholder="예: 1000" oninput="convertArea()">
                    <select id="unitSelect" onchange="convertArea()">
                        <option value="squareMeters">제곱미터</option>
                        <option value="pyeong">평</option>
                        <option value="ares">아르</option>
                        <option value="hectares">헥타르</option>
                        <option value="squareKilometers">제곱킬로미터</option>
                        <option value="squareFeet">제곱피트</option>
                        <option value="squareYards">제곱야드</option>
                        <option value="acres">에이커</option>
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
        function convertArea() {
            const areaInput = parseFloat(document.getElementById('areaInput').value);
            const inputUnit = document.getElementById('unitSelect').value;
            const resultContainer = document.getElementById('conversionResult');

            if (isNaN(areaInput)) {
                resultContainer.innerHTML = '<div class="result-item">유효한 면적을 입력하세요.</div>';
                return;
            }

            const conversionFactors = {
                squareMeters: 1,
                pyeong: 3.3058,
                ares: 100,
                hectares: 10000,
                squareKilometers: 1e6,
                squareFeet: 0.092903,
                squareYards: 0.836127,
                acres: 4046.86
            };

            const unitNames = {
                squareMeters: '제곱미터',
                pyeong: '평',
                ares: '아르',
                hectares: '헥타르',
                squareKilometers: '제곱킬로미터',
                squareFeet: '제곱피트',
                squareYards: '제곱야드',
                acres: '에이커'
            };

            const areaInSquareMeters = areaInput * conversionFactors[inputUnit];

            const results = Object.keys(conversionFactors).map(unit => {
                const convertedArea = areaInSquareMeters / conversionFactors[unit];
                return `<div class="result-item">${convertedArea.toFixed(2)} ${unitNames[unit]} <button onclick="copyToClipboard('${convertedArea.toFixed(2)} ${unitNames[unit]}')">복사</button></div>`;
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