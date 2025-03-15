<?php
$page_title = 'XML 검증 - 유틸리티 모음';
$additional_css = ['css/xml-validator.css'];
$additional_js = ['js/xml-validator.js'];
include 'includes/header.php';
?>

        <main>
            <section class="xml-validator-section">
                <h2>XML 검증</h2>
                <div class="xml-validator">
                    <div class="input-group">
                        <label for="xml-input">XML 문서:</label>
                        <textarea id="xml-input" rows="10" placeholder="XML 문서를 입력하세요...">&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;bookstore&gt;
    &lt;book category="cooking"&gt;
        &lt;title lang="ko"&gt;한국 요리 백과&lt;/title&gt;
        &lt;author&gt;김요리&lt;/author&gt;
        &lt;year&gt;2024&lt;/year&gt;
        &lt;price&gt;35000&lt;/price&gt;
    &lt;/book&gt;
    &lt;book category="programming"&gt;
        &lt;title lang="ko"&gt;웹 개발 입문&lt;/title&gt;
        &lt;author&gt;박코딩&lt;/author&gt;
        &lt;year&gt;2024&lt;/year&gt;
        &lt;price&gt;28000&lt;/price&gt;
    &lt;/book&gt;
&lt;/bookstore&gt;</textarea>
                    </div>
                    
                    <div class="button-group">
                        <button class="btn validate" onclick="validateXML()">검증</button>
                        <button class="btn format" onclick="formatXML()">포맷팅</button>
                        <button class="btn clear" onclick="clearText()">초기화</button>
                    </div>

                    <div class="output-group">
                        <div class="output-section">
                            <h3>검증 결과</h3>
                            <div id="validation-result" class="result-output"></div>
                        </div>
                        <div class="output-section">
                            <h3>포맷팅된 XML</h3>
                            <pre id="formatted-output" class="xml-output"></pre>
                        </div>
                    </div>
                </div>
            </section>
        </main>

<?php include 'includes/footer.php'; ?> 