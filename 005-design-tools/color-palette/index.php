<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>색상 팔레트 생성기</title>
    <meta name="description" content="다양한 색상 팔레트를 생성하고 관리할 수 있는 도구입니다.">
    <meta property="og:title" content="색상 팔레트 생성기">
    <meta property="og:description" content="다양한 색상 팔레트를 생성하고 관리할 수 있는 도구입니다.">
    <meta property="og:url" content="https://googsu.com/005-design-tools/color-palette">
    <meta property="og:image" content="https://googsu.com/images/color-palette-og-image.png">
    <style>
        .palette-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .color-box {
            width: 100px;
            height: 100px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 10px;
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
            <div class="palette-container">
                <div class="color-box" id="colorBox"></div>
                <button class="btn" onclick="addColorToPalette()">색상 추가</button>
                <div id="palette"></div>
            </div>
        </div>
    </div>

    <script>
        function addColorToPalette() {
            const colorBox = document.getElementById('colorBox');
            const palette = document.getElementById('palette');
            const newColor = document.createElement('div');
            newColor.className = 'color-box';
            newColor.style.backgroundColor = colorBox.style.backgroundColor || 'rgb(255, 255, 255)';
            palette.appendChild(newColor);
        }

        // Example function to change the color of the colorBox
        function changeColor(r, g, b) {
            const colorBox = document.getElementById('colorBox');
            colorBox.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
        }
    </script>
</body>
</html> 