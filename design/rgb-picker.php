<?php
$page_title = 'RGB 코드 피커';
$additional_css = ['/css/text-compare.css'];
include_once '../includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>RGB 코드 피커</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <div class="color-picker-container">
                    <div class="color-preview" id="colorPreview"></div>
                    <div class="color-inputs">
                        <div class="input-group mb-4">
                            <label class="mui-label">색상 선택</label>
                            <input type="color" 
                                   class="form-control color-input" 
                                   id="colorPicker" 
                                   value="#1976d2">
                        </div>
                        
                        <div class="input-group mb-4">
                            <label class="mui-label">HEX</label>
                            <input type="text" 
                                   class="form-control mui-input" 
                                   id="hexInput" 
                                   value="#1976d2"
                                   readonly>
                            <button class="mui-button copy-button" data-clipboard-target="#hexInput">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>

                        <div class="input-group mb-4">
                            <label class="mui-label">RGB</label>
                            <input type="text" 
                                   class="form-control mui-input" 
                                   id="rgbInput" 
                                   value="rgb(25, 118, 210)"
                                   readonly>
                            <button class="mui-button copy-button" data-clipboard-target="#rgbInput">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>

                        <div class="input-group mb-4">
                            <label class="mui-label">HSL</label>
                            <input type="text" 
                                   class="form-control mui-input" 
                                   id="hslInput" 
                                   value="hsl(207, 79%, 46%)"
                                   readonly>
                            <button class="mui-button copy-button" data-clipboard-target="#hslInput">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mui-card mt-4">
            <div class="mui-card-header">
                <h3>색상 팔레트</h3>
            </div>
            <div class="mui-card-content">
                <div class="color-palette" id="colorPalette">
                    <!-- JavaScript로 동적 생성됨 -->
                </div>
            </div>
        </div>

        <div class="mui-card mt-4">
            <div class="mui-card-header">
                <h3>사용 방법</h3>
            </div>
            <div class="mui-card-content">
                <ol class="instruction-list">
                    <li>색상 선택기를 클릭하여 원하는 색상을 선택하세요.</li>
                    <li>선택한 색상의 HEX, RGB, HSL 값이 자동으로 표시됩니다.</li>
                    <li>복사 버튼을 클릭하여 원하는 형식의 색상 코드를 클립보드에 복사할 수 있습니다.</li>
                    <li>색상 팔레트에서 미리 정의된 색상을 선택할 수도 있습니다.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<style>
.color-picker-container {
    display: flex;
    gap: 2rem;
    padding: 1rem;
}

.color-preview {
    width: 200px;
    height: 200px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    background-color: #1976d2;
}

.color-inputs {
    flex: 1;
}

.input-group {
    position: relative;
}

.color-input {
    width: 100%;
    height: 40px;
    padding: 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.copy-button {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    padding: 0.5rem;
    min-width: auto;
    margin-right: 0.5rem;
}

.color-palette {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    gap: 0.5rem;
    padding: 1rem;
}

.palette-color {
    width: 100%;
    padding-bottom: 100%;
    border-radius: 4px;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.palette-color:hover {
    transform: scale(1.1);
}

.instruction-list {
    padding-left: 1.5rem;
    margin: 0;
}

.instruction-list li {
    margin-bottom: 0.5rem;
    color: var(--mui-text-secondary);
}

@media (max-width: 768px) {
    .color-picker-container {
        flex-direction: column;
        align-items: center;
    }

    .color-preview {
        width: 150px;
        height: 150px;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorPicker = document.getElementById('colorPicker');
    const colorPreview = document.getElementById('colorPreview');
    const hexInput = document.getElementById('hexInput');
    const rgbInput = document.getElementById('rgbInput');
    const hslInput = document.getElementById('hslInput');
    const colorPalette = document.getElementById('colorPalette');

    // 클립보드 초기화
    new ClipboardJS('.copy-button');

    // Material Design 색상 팔레트
    const materialColors = [
        '#f44336', '#e91e63', '#9c27b0', '#673ab7', '#3f51b5', '#2196f3', 
        '#03a9f4', '#00bcd4', '#009688', '#4caf50', '#8bc34a', '#cddc39',
        '#ffeb3b', '#ffc107', '#ff9800', '#ff5722', '#795548', '#9e9e9e'
    ];

    // 팔레트 색상 생성
    materialColors.forEach(color => {
        const div = document.createElement('div');
        div.className = 'palette-color';
        div.style.backgroundColor = color;
        div.addEventListener('click', () => {
            colorPicker.value = color;
            updateColor(color);
        });
        colorPalette.appendChild(div);
    });

    // RGB를 HSL로 변환하는 함수
    function rgbToHsl(r, g, b) {
        r /= 255;
        g /= 255;
        b /= 255;

        const max = Math.max(r, g, b);
        const min = Math.min(r, g, b);
        let h, s, l = (max + min) / 2;

        if (max === min) {
            h = s = 0;
        } else {
            const d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);

            switch (max) {
                case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                case g: h = (b - r) / d + 2; break;
                case b: h = (r - g) / d + 4; break;
            }

            h /= 6;
        }

        return [
            Math.round(h * 360),
            Math.round(s * 100),
            Math.round(l * 100)
        ];
    }

    // 색상 업데이트 함수
    function updateColor(color) {
        // HEX 업데이트
        hexInput.value = color;
        colorPreview.style.backgroundColor = color;

        // RGB 업데이트
        const r = parseInt(color.substr(1,2), 16);
        const g = parseInt(color.substr(3,2), 16);
        const b = parseInt(color.substr(5,2), 16);
        rgbInput.value = `rgb(${r}, ${g}, ${b})`;

        // HSL 업데이트
        const [h, s, l] = rgbToHsl(r, g, b);
        hslInput.value = `hsl(${h}, ${s}%, ${l}%)`;
    }

    // 색상 선택 이벤트
    colorPicker.addEventListener('input', (e) => {
        updateColor(e.target.value);
    });

    // 초기 색상 설정
    updateColor(colorPicker.value);
});
</script>

<?php
include_once '../includes/footer.php';
?> 