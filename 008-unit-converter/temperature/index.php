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
                    <label for="temperatureInput">온도 입력:</label>
                    <input type="number" id="temperatureInput" placeholder="예: 25">
                </div>
                <div class="input-group">
                    <label for="unitSelect">단위 선택:</label>
                    <select id="unitSelect">
                        <option value="celsius">섭씨</option>
                        <option value="fahrenheit">화씨</option>
                        <option value="kelvin">켈빈</option>
                    </select>
                </div>
                <button class="btn" onclick="convertTemperature()">변환</button>
                <div class="result" id="conversionResult">
                    <h3>결과</h3>
                    <pre id="resultText">온도를 입력하고 단위를 선택한 후 '변환' 버튼을 클릭하세요.</pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        function convertTemperature() {
            const temperatureInput = parseFloat(document.getElementById('temperatureInput').value);
            const unitSelect = document.getElementById('unitSelect').value;
            const resultText = document.getElementById('resultText');

            if (isNaN(temperatureInput)) {
                resultText.textContent = '유효한 온도를 입력하세요.';
                return;
            }

            let celsius, fahrenheit, kelvin;

            switch (unitSelect) {
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
                default:
                    celsius = temperatureInput;
                    fahrenheit = (temperatureInput * 9/5) + 32;
                    kelvin = temperatureInput + 273.15;
            }

            resultText.textContent = `섭씨: ${celsius.toFixed(2)} °C\n화씨: ${fahrenheit.toFixed(2)} °F\n켈빈: ${kelvin.toFixed(2)} K`;
        }
    </script>
</body>
</html> 