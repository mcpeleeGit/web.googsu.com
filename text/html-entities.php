<?php
$page_title = 'HTML 특수문자 변환기';
$additional_css = ['/css/text-compare.css'];
include_once '../includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>HTML 특수문자 변환기</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-5">
                        <div class="direction-selector">
                            <label class="radio-label">
                                <input type="radio" name="direction" value="to_entities" <?php echo (!isset($_POST['direction']) || $_POST['direction'] === 'to_entities') ? 'checked' : ''; ?>>
                                <span>일반 텍스트 → HTML 엔티티</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="direction" value="to_text" <?php echo (isset($_POST['direction']) && $_POST['direction'] === 'to_text') ? 'checked' : ''; ?>>
                                <span>HTML 엔티티 → 일반 텍스트</span>
                            </label>
                        </div>
                        
                        <div class="text-input-group">
                            <label for="input_text">변환할 텍스트</label>
                            <textarea name="input_text" 
                                      id="input_text" 
                                      class="form-control large-textarea" 
                                      rows="8" 
                                      placeholder="변환할 텍스트를 입력하세요"
                                      required><?php echo isset($_POST['input_text']) ? htmlspecialchars($_POST['input_text']) : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="button-group mt-4">
                        <button type="submit" name="action" value="convert" class="mui-button large-button">
                            <i class="fas fa-exchange-alt"></i> 변환하기
                        </button>
                    </div>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $input_text = $_POST['input_text'] ?? '';
                    $direction = $_POST['direction'] ?? 'to_entities';
                    $result = '';
                    $error = '';

                    if (!empty($input_text)) {
                        if ($direction === 'to_entities') {
                            $result = htmlspecialchars($input_text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                        } else {
                            $result = htmlspecialchars_decode($input_text, ENT_QUOTES | ENT_HTML5);
                        }
                    }
                }
                ?>

                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($result) && !empty($result)): ?>
                    <div class="result-section">
                        <h3>변환 결과</h3>
                        <div class="result-box">
                            <pre class="result-text"><?php echo htmlspecialchars($result); ?></pre>
                        </div>
                        <div class="button-group mt-4">
                            <button class="mui-button" onclick="copyToClipboard('<?php echo addslashes($result); ?>')">
                                <i class="fas fa-copy"></i> 결과 복사
                            </button>
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
                    <li>HTML 특수문자와 일반 텍스트를 서로 변환할 수 있습니다.</li>
                    <li>주요 변환 예시:
                        <ul>
                            <li>&lt; → &amp;lt;</li>
                            <li>&gt; → &amp;gt;</li>
                            <li>&amp; → &amp;amp;</li>
                            <li>" → &amp;quot;</li>
                            <li>' → &amp;apos;</li>
                        </ul>
                    </li>
                    <li>변환 방향을 선택하여 원하는 형식으로 변환할 수 있습니다.</li>
                    <li>변환된 결과는 복사 버튼을 통해 클립보드에 복사할 수 있습니다.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.direction-selector {
    display: flex;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.radio-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.radio-label input[type="radio"] {
    margin: 0;
}

.text-input-group {
    margin-bottom: 1rem;
}

.text-input-group label {
    display: block;
    margin-bottom: 0.5rem;
}

.large-textarea {
    font-size: 1.1rem;
    padding: 1rem;
    min-height: 200px;
    resize: vertical;
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    display: block;
}

.result-box {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
    text-align: left;
    overflow-x: auto;
}

.result-text {
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: monospace;
    font-size: 1.1rem;
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

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}
</style>

<script>
function copyToClipboard(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
    
    // 복사 완료 알림
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check"></i> 복사 완료';
    setTimeout(() => {
        button.innerHTML = originalText;
    }, 2000);
}
</script>

<?php
include_once '../includes/footer.php';
?>