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
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .input-group input[type="range"] {
            width: 100%;
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
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="rgb-picker-container">
                <div class="input-group">
                    <label for="red">Red: <span id="redValue">0</span></label>
                    <input type="range" id="red" min="0" max="255" value="0" oninput="updateColor()">
                </div>
                <div class="input-group">
                    <label for="green">Green: <span id="greenValue">0</span></label>
                    <input type="range" id="green" min="0" max="255" value="0" oninput="updateColor()">
                </div>
                <div class="input-group">
                    <label for="blue">Blue: <span id="blueValue">0</span></label>
                    <input type="range" id="blue" min="0" max="255" value="0" oninput="updateColor()">
                </div>
                <div class="color-preview" id="colorPreview"></div>
            </div>
        </div>
    </div>

    <script>
        function updateColor() {
            const red = document.getElementById('red').value;
            const green = document.getElementById('green').value;
            const blue = document.getElementById('blue').value;

            document.getElementById('redValue').textContent = red;
            document.getElementById('greenValue').textContent = green;
            document.getElementById('blueValue').textContent = blue;

            const color = `rgb(${red}, ${green}, ${blue})`;
            document.getElementById('colorPreview').style.backgroundColor = color;
        }
    </script>
</body>
</html> 