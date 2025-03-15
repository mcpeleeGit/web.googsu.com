<?php
require_once 'includes/functions.php';

$page_title = 'CURL 명령어 변환기';
$current_page = 'curl-converter';
$additional_css = ['css/curl-converter.css'];
$additional_js = ['js/curl-converter.js'];

include 'includes/header.php';
?>

        <main>
            <section class="tool-section">
                <h2>CURL 명령어 변환기</h2>
                <div class="curl-converter-container">
                    <div class="input-section">
                        <div class="form-group">
                            <label for="curl-input">CURL 명령어 입력:</label>
                            <textarea id="curl-input" rows="5" placeholder="curl 명령어를 입력하세요"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="target-language">변환할 언어 선택:</label>
                            <select id="target-language">
                                <option value="php">PHP</option>
                                <option value="python">Python</option>
                                <option value="javascript">JavaScript (Fetch)</option>
                                <option value="javascript-axios">JavaScript (Axios)</option>
                                <option value="java">Java</option>
                                <option value="go">Go</option>
                                <option value="ruby">Ruby</option>
                                <option value="csharp">C#</option>
                                <option value="swift">Swift</option>
                                <option value="kotlin">Kotlin</option>
                            </select>
                        </div>
                        <button id="convert-btn" class="btn btn-primary">변환</button>
                    </div>

                    <div class="output-section">
                        <div class="form-group">
                            <label for="converted-code">변환된 코드:</label>
                            <div class="code-container">
                                <pre><code id="converted-code" class="language-php"></code></pre>
                            </div>
                        </div>
                        <div class="button-group">
                            <button id="copy-btn" class="btn btn-secondary">코드 복사</button>
                            <button id="clear-btn" class="btn btn-secondary">초기화</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>

<?php include 'includes/footer.php'; ?> 