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

        .palette-preview {
            display: flex;
            gap: 10px;
        }

        .palette-color {
            width: 50px;
            height: 50px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            position: relative;
            cursor: pointer;
        }

        .palette-color span {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.7);
            text-align: center;
            font-size: 12px;
        }

        .palette-color button {
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.7);
            border: none;
            cursor: pointer;
            font-size: 10px;
        }

        .saved-palettes {
            margin-top: 20px;
        }
        .saved-palette-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .saved-palette-item button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="palette-container">
                <div class="palette-preview" id="palettePreview"></div>
                <button class="btn" onclick="addColorToPalette()">색상 추가</button>
                <button class="btn" onclick="generateRandomPalette()">랜덤 생성</button>
                <button class="btn" onclick="savePalette()">저장</button>
                <div id="palette"></div>
                <div class="saved-palettes" id="savedPalettes"></div>
            </div>
        </div>
    </div>

    <script>
        const palette = [];

        function addColorToPalette() {
            const randomColor = `#${Math.floor(Math.random()*16777215).toString(16).padStart(6, '0')}`;
            palette.push(randomColor);
            updatePalettePreview();
        }

        function generateRandomPalette() {
            palette.length = 0; // Clear existing palette
            for (let i = 0; i < 5; i++) {
                const randomColor = `#${Math.floor(Math.random()*16777215).toString(16).padStart(6, '0')}`;
                palette.push(randomColor);
            }
            updatePalettePreview();
        }

        function updatePalettePreview() {
            const palettePreview = document.getElementById('palettePreview');
            palettePreview.innerHTML = palette.map((color, index) => `<div class="palette-color" style="background-color: ${color};" onclick="editColor(${index})"><span>${color}</span><button onclick="copyToClipboard('${color}'); event.stopPropagation();">복사</button></div>`).join('');
        }

        function rgbToHex(rgb) {
            const result = rgb.match(/\d+/g);
            return `#${((1 << 24) + (parseInt(result[0]) << 16) + (parseInt(result[1]) << 8) + parseInt(result[2])).toString(16).slice(1).toUpperCase()}`;
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('복사되었습니다: ' + text);
            });
        }

        function editColor(index) {
            const newColor = prompt('새로운 색상 HEX 코드를 입력하세요:', palette[index]);
            if (newColor) {
                palette[index] = newColor;
                updatePalettePreview();
            }
        }

        function savePalette() {
            const savedPalettes = JSON.parse(localStorage.getItem('savedPalettes')) || [];
            savedPalettes.push([...palette]);
            localStorage.setItem('savedPalettes', JSON.stringify(savedPalettes));
            alert('팔레트가 저장되었습니다.');
            updateSavedPalettes();
        }

        function loadPalette() {
            const savedPalette = JSON.parse(localStorage.getItem('savedPalette'));
            if (savedPalette) {
                palette.length = 0;
                palette.push(...savedPalette);
                updatePalettePreview();
                alert('팔레트가 불러와졌습니다.');
            } else {
                alert('저장된 팔레트가 없습니다.');
            }
        }

        function updateSavedPalettes() {
            const savedPalettes = JSON.parse(localStorage.getItem('savedPalettes')) || [];
            const savedPalettesContainer = document.getElementById('savedPalettes');
            savedPalettesContainer.innerHTML = savedPalettes.map((palette, index) => `
                <div class="saved-palette-item">
                    <div style="display: flex; gap: 10px;">
                        ${palette.map(color => `<div class="palette-color" style="background-color: ${color};"><span>${color}</span></div>`).join('')}
                    </div>
                    <div>
                        <button class="btn" onclick="addSavedPaletteToCurrent(${index})">추가</button>
                        <button class="btn" onclick="deleteSavedPalette(${index})">삭제</button>
                    </div>
                </div>
            `).join('');
        }

        function addSavedPaletteToCurrent(index) {
            const savedPalettes = JSON.parse(localStorage.getItem('savedPalettes')) || [];
            if (savedPalettes[index]) {
                palette.push(...savedPalettes[index]);
                updatePalettePreview();
                alert('팔레트가 추가되었습니다.');
            }
        }

        function deleteSavedPalette(index) {
            const savedPalettes = JSON.parse(localStorage.getItem('savedPalettes')) || [];
            if (savedPalettes[index]) {
                savedPalettes.splice(index, 1);
                localStorage.setItem('savedPalettes', JSON.stringify(savedPalettes));
                alert('팔레트가 삭제되었습니다.');
                updateSavedPalettes();
            }
        }

        // Initialize saved palettes on page load
        document.addEventListener('DOMContentLoaded', updateSavedPalettes);
    </script>
</body>
</html> 