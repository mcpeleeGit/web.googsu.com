<?php
$page_title = 'QR코드 변환기';
$additional_css = ['/css/qr-generator.css'];
$additional_js = ['/js/qr-generator.js'];

require_once 'includes/header.php';
?>

<div class="container">
    <h1>QR코드 변환기</h1>
    <p class="description">텍스트나 URL을 QR코드로 변환합니다.</p>

    <div class="qr-generator-form">
        <div class="input-group">
            <label for="content">텍스트 또는 URL 입력</label>
            <textarea id="content" name="content" placeholder="변환할 텍스트나 URL을 입력하세요" required></textarea>
        </div>
        <div class="options-group">
            <div class="size-option">
                <label for="size">QR코드 크기</label>
                <select id="size" name="size">
                    <option value="100">100x100</option>
                    <option value="200" selected>200x200</option>
                    <option value="300">300x300</option>
                    <option value="400">400x400</option>
                </select>
            </div>
            <div class="margin-option">
                <label for="margin">여백</label>
                <select id="margin" name="margin">
                    <option value="0">없음</option>
                    <option value="1" selected>작게</option>
                    <option value="2">보통</option>
                    <option value="4">크게</option>
                </select>
            </div>
        </div>
        <button type="button" id="generate-qr" class="btn-primary">QR코드 생성</button>
    </div>

    <div class="result-container">
        <div id="loading" class="loading" style="display: none;">
            <div class="spinner"></div>
            <p>QR코드를 생성하는 중...</p>
        </div>
        <div id="result" class="result" style="display: none;">
            <div class="qr-code-container">
                <img id="qr-code" src="" alt="생성된 QR코드">
            </div>
            <div class="download-section">
                <button type="button" id="download-png" class="btn-secondary">PNG 다운로드</button>
                <button type="button" id="download-svg" class="btn-secondary">SVG 다운로드</button>
            </div>
        </div>
        <div id="error-message" class="error-message"></div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 