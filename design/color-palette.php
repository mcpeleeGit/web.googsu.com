<?php
$page_title = '웹 색상 팔레트 추천기';
$additional_css = ['/css/text-compare.css'];
include_once '../includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>웹 색상 팔레트 추천기</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-5">
                        <div class="color-input-group">
                            <label for="base_color">기본 색상 선택</label>
                            <input type="color" id="base_color" name="base_color" value="<?php echo isset($_POST['base_color']) ? htmlspecialchars($_POST['base_color']) : '#4A90E2'; ?>">
                            <input type="text" id="base_color_hex" name="base_color_hex" value="<?php echo isset($_POST['base_color_hex']) ? htmlspecialchars($_POST['base_color_hex']) : '#4A90E2'; ?>" class="hex-input">
                        </div>
                        
                        <div class="palette-options">
                            <label>팔레트 스타일</label>
                            <select name="palette_style" class="form-control">
                                <option value="analogous" <?php echo (isset($_POST['palette_style']) && $_POST['palette_style'] === 'analogous') ? 'selected' : ''; ?>>유사색 (Analogous)</option>
                                <option value="complementary" <?php echo (isset($_POST['palette_style']) && $_POST['palette_style'] === 'complementary') ? 'selected' : ''; ?>>보색 (Complementary)</option>
                                <option value="triadic" <?php echo (isset($_POST['palette_style']) && $_POST['palette_style'] === 'triadic') ? 'selected' : ''; ?>>삼색 (Triadic)</option>
                                <option value="split_complementary" <?php echo (isset($_POST['palette_style']) && $_POST['palette_style'] === 'split_complementary') ? 'selected' : ''; ?>>분할 보색 (Split Complementary)</option>
                                <option value="tetradic" <?php echo (isset($_POST['palette_style']) && $_POST['palette_style'] === 'tetradic') ? 'selected' : ''; ?>>사색 (Tetradic)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="button-group mt-4">
                        <button type="submit" name="action" value="generate" class="mui-button large-button">
                            <i class="fas fa-palette"></i> 팔레트 생성
                        </button>
                    </div>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $base_color = $_POST['base_color'] ?? '#4A90E2';
                    $palette_style = $_POST['palette_style'] ?? 'analogous';
                    $palette = [];
                    
                    // HSL로 변환
                    $rgb = sscanf($base_color, "#%02x%02x%02x");
                    $hsl = rgbToHsl($rgb[0], $rgb[1], $rgb[2]);
                    
                    switch ($palette_style) {
                        case 'analogous':
                            $palette = generateAnalogousPalette($hsl);
                            break;
                        case 'complementary':
                            $palette = generateComplementaryPalette($hsl);
                            break;
                        case 'triadic':
                            $palette = generateTriadicPalette($hsl);
                            break;
                        case 'split_complementary':
                            $palette = generateSplitComplementaryPalette($hsl);
                            break;
                        case 'tetradic':
                            $palette = generateTetradicPalette($hsl);
                            break;
                    }
                }
                ?>

                <?php if (isset($palette) && !empty($palette)): ?>
                    <div class="result-section">
                        <h3>생성된 팔레트</h3>
                        <div class="palette-grid">
                            <?php foreach ($palette as $color): ?>
                                <div class="color-box">
                                    <div class="color-preview" style="background-color: <?php echo $color; ?>"></div>
                                    <div class="color-info">
                                        <div class="color-hex"><?php echo $color; ?></div>
                                        <div class="color-rgb"><?php echo hexToRgb($color); ?></div>
                                        <div class="color-hsl"><?php echo hexToHsl($color); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mui-card mt-4">
            <div class="mui-card-header">
                <h3>도움말</h3>
            </div>
            <div class="mui-card-content">
                <ul class="help-list">
                    <li>기본 색상을 선택하고 원하는 팔레트 스타일을 선택하여 조화로운 색상 조합을 생성합니다.</li>
                    <li>팔레트 스타일 설명:
                        <ul>
                            <li>유사색 (Analogous): 선택한 색상과 인접한 색상들로 구성</li>
                            <li>보색 (Complementary): 선택한 색상의 정반대 색상으로 구성</li>
                            <li>삼색 (Triadic): 색상환에서 120도 간격으로 떨어진 세 색상으로 구성</li>
                            <li>분할 보색 (Split Complementary): 보색의 양쪽 색상으로 구성</li>
                            <li>사색 (Tetradic): 두 쌍의 보색으로 구성</li>
                        </ul>
                    </li>
                    <li>각 색상의 HEX, RGB, HSL 값을 확인할 수 있습니다.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.color-input-group {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.color-input-group label {
    min-width: 120px;
}

input[type="color"] {
    width: 60px;
    height: 40px;
    padding: 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.hex-input {
    width: 100px;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.palette-options {
    margin-bottom: 1rem;
}

.palette-options label {
    display: block;
    margin-bottom: 0.5rem;
}

.palette-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.color-box {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.color-preview {
    height: 100px;
    width: 100%;
}

.color-info {
    padding: 1rem;
}

.color-hex {
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.color-rgb, .color-hsl {
    font-size: 0.9rem;
    color: var(--mui-text-secondary);
}

.button-group {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.large-button {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    min-width: 150px;
}

.large-button i {
    font-size: 1.2rem;
    margin-right: 0.5rem;
}

.result-section {
    margin-top: 2rem;
    text-align: center;
}

.result-section h3 {
    color: var(--mui-primary);
    margin-bottom: 1rem;
}

.help-list {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin: 0;
}

.help-list li {
    margin-bottom: 0.5rem;
    color: var(--mui-text-secondary);
}

.help-list ul {
    list-style-type: circle;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}
</style>

<script>
document.getElementById('base_color').addEventListener('input', function(e) {
    document.getElementById('base_color_hex').value = e.target.value;
});

document.getElementById('base_color_hex').addEventListener('input', function(e) {
    if (/^#[0-9A-F]{6}$/i.test(e.target.value)) {
        document.getElementById('base_color').value = e.target.value;
    }
});
</script>

<?php
function rgbToHsl($r, $g, $b) {
    $r /= 255;
    $g /= 255;
    $b /= 255;
    
    $max = max($r, $g, $b);
    $min = min($r, $g, $b);
    $h = $s = $l = ($max + $min) / 2;
    
    if ($max === $min) {
        $h = $s = 0;
    } else {
        $d = $max - $min;
        $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
        
        switch ($max) {
            case $r:
                $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
                break;
            case $g:
                $h = ($b - $r) / $d + 2;
                break;
            case $b:
                $h = ($r - $g) / $d + 4;
                break;
        }
        $h /= 6;
    }
    
    $h = round($h * 360);
    $s = round($s * 100);
    $l = round($l * 100);
    
    return [$h, $s, $l];
}

function hslToHex($h, $s, $l) {
    $s /= 100;
    $l /= 100;
    
    $c = (1 - abs(2 * $l - 1)) * $s;
    $x = $c * (1 - abs(fmod(($h / 60), 2) - 1));
    $m = $l - $c/2;
    $r = $g = $b = 0;
    
    if ($h < 60) {
        $r = $c; $g = $x; $b = 0;
    } else if ($h < 120) {
        $r = $x; $g = $c; $b = 0;
    } else if ($h < 180) {
        $r = 0; $g = $c; $b = $x;
    } else if ($h < 240) {
        $r = 0; $g = $x; $b = $c;
    } else if ($h < 300) {
        $r = $x; $g = 0; $b = $c;
    } else {
        $r = $c; $g = 0; $b = $x;
    }
    
    $r = round(($r + $m) * 255);
    $g = round(($g + $m) * 255);
    $b = round(($b + $m) * 255);
    
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

function generateAnalogousPalette($hsl) {
    $palette = [];
    $palette[] = hslToHex($hsl[0], $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 30) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 60) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] - 30 + 360) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] - 60 + 360) % 360), $hsl[1], $hsl[2]);
    return $palette;
}

function generateComplementaryPalette($hsl) {
    $palette = [];
    $palette[] = hslToHex($hsl[0], $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 180) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex($hsl[0], $hsl[1], max(0, $hsl[2] - 20));
    $palette[] = hslToHex(round(($hsl[0] + 180) % 360), $hsl[1], max(0, $hsl[2] - 20));
    $palette[] = hslToHex($hsl[0], $hsl[1], min(100, $hsl[2] + 20));
    return $palette;
}

function generateTriadicPalette($hsl) {
    $palette = [];
    $palette[] = hslToHex($hsl[0], $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 120) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 240) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex($hsl[0], $hsl[1], max(0, $hsl[2] - 20));
    $palette[] = hslToHex(round(($hsl[0] + 120) % 360), $hsl[1], max(0, $hsl[2] - 20));
    return $palette;
}

function generateSplitComplementaryPalette($hsl) {
    $palette = [];
    $palette[] = hslToHex($hsl[0], $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 150) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 210) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex($hsl[0], $hsl[1], max(0, $hsl[2] - 20));
    $palette[] = hslToHex(round(($hsl[0] + 150) % 360), $hsl[1], max(0, $hsl[2] - 20));
    return $palette;
}

function generateTetradicPalette($hsl) {
    $palette = [];
    $palette[] = hslToHex($hsl[0], $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 90) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 180) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex(round(($hsl[0] + 270) % 360), $hsl[1], $hsl[2]);
    $palette[] = hslToHex($hsl[0], $hsl[1], max(0, $hsl[2] - 20));
    return $palette;
}

function hexToRgb($hex) {
    $hex = ltrim($hex, '#');
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "rgb($r, $g, $b)";
}

function hexToHsl($hex) {
    $hex = ltrim($hex, '#');
    $r = hexdec(substr($hex, 0, 2)) / 255;
    $g = hexdec(substr($hex, 2, 2)) / 255;
    $b = hexdec(substr($hex, 4, 2)) / 255;
    
    $max = max($r, $g, $b);
    $min = min($r, $g, $b);
    $h = $s = $l = ($max + $min) / 2;
    
    if ($max === $min) {
        $h = $s = 0;
    } else {
        $d = $max - $min;
        $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
        
        switch ($max) {
            case $r:
                $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
                break;
            case $g:
                $h = ($b - $r) / $d + 2;
                break;
            case $b:
                $h = ($r - $g) / $d + 4;
                break;
        }
        $h /= 6;
    }
    
    $h = round($h * 360);
    $s = round($s * 100);
    $l = round($l * 100);
    
    return sprintf("hsl(%d, %d%%, %d%%)", $h, $s, $l);
}
?>

<?php
include_once '../includes/footer.php';
?> 