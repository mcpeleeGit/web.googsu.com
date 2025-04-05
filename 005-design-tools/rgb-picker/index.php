<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>RGB 코드 피커</title>
    <meta name="description" content="RGB 색상 코드를 선택하고 미리볼 수 있는 도구입니다.">
    <meta property="og:title" content="RGB 코드 피커">
    <meta property="og:description" content="RGB 색상 코드를 선택하고 미리볼 수 있는 도구입니다.">
    <meta property="og:url" content="https://googsu.com/005-design-tools/rgb-picker">
    <meta property="og:image" content="https://googsu.com/images/rgb-picker-og-image.png">
    <style>
        .rgb-picker-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: row;
            gap: 10px;
            align-items: center;
        }

        .input-group input[type="range"] {
            width: 100%;
        }

        .input-group input[type="text"], .input-group input[type="color"] {
            width: 120px;
            padding: 5px;
            font-size: 16px;
        }

        .color-preview {
            width: 100px;
            height: 100px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
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

        .recent-colors {
            display: flex;
            gap: 5px;
        }

        .recent-color {
            width: 20px;
            height: 20px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="rgb-picker-container">
                <div class="input-group">
                    <label for="colorPicker">색상 선택:</label>
                    <input type="color" id="colorPicker" onchange="updateFromColorPicker()">
                </div>
                <div class="input-group">
                    <label for="hexInput">HEX:</label>
                    <input type="text" id="hexInput" value="#000000" oninput="updateFromHex()">
                    <button class="btn" onclick="copyToClipboard('hex')">복사</button>
                </div>
                <div class="input-group">
                    <label for="rgbInput">RGB:</label>
                    <input type="text" id="rgbInput" value="0, 0, 0" readonly>
                    <button class="btn" onclick="copyToClipboard('rgb')">복사</button>
                </div>
                <div class="input-group">
                    <label for="red">R:</label>
                    <input type="range" id="red" min="0" max="255" value="0" oninput="updateColor()">
                    <span id="redValue">0</span>
                </div>
                <div class="input-group">
                    <label for="green">G:</label>
                    <input type="range" id="green" min="0" max="255" value="0" oninput="updateColor()">
                    <span id="greenValue">0</span>
                </div>
                <div class="input-group">
                    <label for="blue">B:</label>
                    <input type="range" id="blue" min="0" max="255" value="0" oninput="updateColor()">
                    <span id="blueValue">0</span>
                </div>
                <div class="color-preview" id="colorPreview"></div>
                <div class="recent-colors" id="recentColors"></div>
            </div>
        </div>
    </div>

    <script>
        const recentColors = [];

        function updateColor() {
            const red = document.getElementById('red').value;
            const green = document.getElementById('green').value;
            const blue = document.getElementById('blue').value;

            document.getElementById('redValue').textContent = red;
            document.getElementById('greenValue').textContent = green;
            document.getElementById('blueValue').textContent = blue;

            const color = `rgb(${red}, ${green}, ${blue})`;
            document.getElementById('colorPreview').style.backgroundColor = color;

            const hex = rgbToHex(red, green, blue);
            document.getElementById('hexInput').value = hex;
            document.getElementById('rgbInput').value = `${red}, ${green}, ${blue}`;

            addRecentColor(hex);
        }

        function updateFromHex() {
            const hex = document.getElementById('hexInput').value;
            const rgb = hexToRgb(hex);
            if (rgb) {
                document.getElementById('red').value = rgb.r;
                document.getElementById('green').value = rgb.g;
                document.getElementById('blue').value = rgb.b;
                updateColor();
            }
        }

        function updateFromColorPicker() {
            const hex = document.getElementById('colorPicker').value;
            document.getElementById('hexInput').value = hex;
            updateFromHex();
        }

        function rgbToHex(r, g, b) {
            return `#${((1 << 24) + (parseInt(r) << 16) + (parseInt(g) << 8) + parseInt(b)).toString(16).slice(1).toUpperCase()}`;
        }

        function hexToRgb(hex) {
            const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
            hex = hex.replace(shorthandRegex, (m, r, g, b) => r + r + g + g + b + b);
            const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }

        function copyToClipboard(type) {
            const text = type === 'hex' ? document.getElementById('hexInput').value : document.getElementById('rgbInput').value;
            navigator.clipboard.writeText(text).then(() => {
                alert('복사되었습니다: ' + text);
            });
        }

        function addRecentColor(hex) {
            if (!recentColors.includes(hex)) {
                if (recentColors.length >= 5) recentColors.shift();
                recentColors.push(hex);
                updateRecentColors();
            }
        }

        function updateRecentColors() {
            const recentColorsContainer = document.getElementById('recentColors');
            recentColorsContainer.innerHTML = recentColors.map(color => `<div class="recent-color" style="background-color: ${color};" onclick="selectRecentColor('${color}')"></div>`).join('');
        }

        function selectRecentColor(hex) {
            document.getElementById('hexInput').value = hex;
            updateFromHex();
        }
    </script>
</body>
</html> 