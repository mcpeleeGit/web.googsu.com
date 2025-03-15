<?php
$page_title = 'URL 인코더/디코더 - 유틸리티 모음';
$additional_css = ['css/url-encoder.css'];
$additional_js = ['js/url-encoder.js'];
include 'includes/header.php';
?>

        <main>
            <section class="url-encoder-section">
                <h2>URL 인코더/디코더</h2>
                <div class="url-encoder">
                    <div class="input-group">
                        <label for="input-text">입력 텍스트:</label>
                        <textarea id="input-text" rows="4" placeholder="인코딩하거나 디코딩할 텍스트를 입력하세요..."></textarea>
                    </div>
                    
                    <div class="button-group">
                        <button class="btn encode" onclick="encodeURL()">인코딩</button>
                        <button class="btn decode" onclick="decodeURL()">디코딩</button>
                        <button class="btn clear" onclick="clearText()">초기화</button>
                    </div>

                    <div class="output-group">
                        <label for="output-text">결과:</label>
                        <textarea id="output-text" rows="4" readonly></textarea>
                    </div>

                    <div class="copy-group">
                        <button class="btn copy" onclick="copyToClipboard()">결과 복사</button>
                    </div>
                </div>
            </section>
        </main>

<?php include 'includes/footer.php'; ?> 