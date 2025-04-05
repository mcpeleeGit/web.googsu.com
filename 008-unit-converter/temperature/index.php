<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>온도 변환</title>
    <meta name="description" content="섭씨, 화씨, 켈빈 등 다양한 온도 단위를 변환합니다.">
    <meta property="og:title" content="온도 변환">
    <meta property="og:description" content="섭씨, 화씨, 켈빈 등 다양한 온도 단위를 변환합니다.">
    <meta property="og:url" content="https://googsu.com/008-unit-converter/temperature">
    <meta property="og:image" content="https://googsu.com/images/temperature-converter-og-image.png">
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
                    <label for="temperatureInput">온도 입력:</label>
                    <input type="number" id="temperatureInput" placeholder="예: 25" oninput="convertTemperature()">
                    <select id="unitSelect" onchange="convertTemperature()">
                        <option value="celsius">섭씨</option>
                        <option value="fahrenheit">화씨</option>
                        <option value="kelvin">켈빈</option>
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
        function convertTemperature() {
            const temperatureInput = parseFloat(document.getElementById('temperatureInput').value);
            const inputUnit = document.getElementById('unitSelect').value;
            const resultContainer = document.getElementById('conversionResult');

            if (isNaN(temperatureInput)) {
                resultContainer.innerHTML = '<div class="result-item">유효한 온도를 입력하세요.</div>';
                return;
            }

            let celsius, fahrenheit, kelvin;

            switch (inputUnit) {
                case 'celsius':
                    celsius = temperatureInput;
                    fahrenheit = (temperatureInput * 9/5) + 32;
                    kelvin = temperatureInput + 273.15;
                    break;
                case 'fahrenheit':
                    celsius = (temperatureInput - 32) * 5/9;
                    fahrenheit = temperatureInput;
                    kelvin = (temperatureInput - 32) * 5/9 + 273.15;
                    break;
                case 'kelvin':
                    celsius = temperatureInput - 273.15;
                    fahrenheit = (temperatureInput - 273.15) * 9/5 + 32;
                    kelvin = temperatureInput;
                    break;
            }

            const results = [
                { value: celsius.toFixed(2), unit: '섭씨', symbol: '°C' },
                { value: fahrenheit.toFixed(2), unit: '화씨', symbol: '°F' },
                { value: kelvin.toFixed(2), unit: '켈빈', symbol: 'K' }
            ].map(result => {
                return `<div class="result-item">${result.value} ${result.unit} (${result.symbol}) <button onclick="copyToClipboard('${result.value} ${result.unit} (${result.symbol})')">복사</button></div>`;
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