<?php
$page_title = 'JWT 디코더 - 유틸리티 모음';
$additional_css = ['css/jwt-decoder.css'];
$additional_js = ['js/jwt-decoder.js'];
include 'includes/header.php';
?>

        <main>
            <section class="jwt-decoder-section">
                <h2>JWT 디코더</h2>
                <div class="jwt-decoder">
                    <div class="input-group">
                        <label for="jwt-input">JWT 토큰:</label>
                        <textarea id="jwt-input" rows="5" placeholder="JWT 토큰을 입력하세요...">eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJleHAiOjE1MTYyMzkwMjIsImFkbWluIjp0cnVlfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c</textarea>
                    </div>
                    
                    <div class="button-group">
                        <button class="btn decode" onclick="decodeJWT()">디코딩</button>
                        <button class="btn clear" onclick="clearText()">초기화</button>
                    </div>

                    <div class="output-group">
                        <div class="output-section">
                            <h3>헤더 (Header)</h3>
                            <pre id="header-output" class="json-output"></pre>
                        </div>
                        <div class="output-section">
                            <h3>페이로드 (Payload)</h3>
                            <pre id="payload-output" class="json-output"></pre>
                        </div>
                        <div class="output-section">
                            <h3>서명 (Signature)</h3>
                            <pre id="signature-output" class="json-output"></pre>
                        </div>
                    </div>
                </div>
            </section>
        </main>

<?php include 'includes/footer.php'; ?> 