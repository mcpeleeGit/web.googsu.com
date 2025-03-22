<?php
$page_title = 'Base64 인코더/디코더';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>Base64 인코더/디코더</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-5">
                        <textarea name="input" 
                                  class="form-control large-textarea" 
                                  rows="8" 
                                  placeholder="인코딩/디코딩할 텍스트를 입력하세요"
                                  required><?php echo isset($_POST['input']) ? htmlspecialchars($_POST['input']) : '안녕하세요! 이것은 Base64 인코딩/디코딩 예시입니다.
이 텍스트를 인코딩하면 Base64 형식으로 변환되고,
Base64 형식의 텍스트를 디코딩하면 원래 텍스트로 돌아갑니다.'; ?></textarea>
                    </div>
                    
                    <div class="button-group mt-4">
                        <button type="submit" name="action" value="encode" class="mui-button large-button">
                            <i class="fas fa-lock"></i> 인코딩
                        </button>
                        <button type="submit" name="action" value="decode" class="mui-button large-button">
                            <i class="fas fa-lock-open"></i> 디코딩
                        </button>
                    </div>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $input = $_POST['input'] ?? '';
                    $action = $_POST['action'] ?? '';
                    $result = '';
                    $error = '';

                    if (!empty($input)) {
                        if ($action === 'encode') {
                            $result = base64_encode($input);
                        } elseif ($action === 'decode') {
                            $decoded = base64_decode($input, true);
                            if ($decoded !== false) {
                                $result = $decoded;
                            } else {
                                $error = '올바른 Base64 형식이 아닙니다.';
                            }
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
                        <h3>결과</h3>
                        <div class="result-box">
                            <pre><?php echo htmlspecialchars($result); ?></pre>
                        </div>
                        <button class="mui-button copy-button" data-clipboard-text="<?php echo htmlspecialchars($result); ?>">
                            <i class="fas fa-copy"></i> 복사하기
                        </button>
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
                    <li>Base64는 바이너리 데이터를 ASCII 문자로 인코딩하는 방식입니다.</li>
                    <li>인코딩: 일반 텍스트를 Base64 형식으로 변환합니다.</li>
                    <li>디코딩: Base64 형식의 텍스트를 원래 형태로 변환합니다.</li>
                    <li>복사하기 버튼을 클릭하면 결과를 클립보드에 복사할 수 있습니다.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.button-group {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
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
}

.result-section h3 {
    color: var(--mui-primary);
    margin-bottom: 1rem;
}

.result-box {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.result-box pre {
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: monospace;
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

.copy-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.input-group {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
}

.mb-5 {
    margin-bottom: 3rem !important;
}

.mt-4 {
    margin-top: 1.5rem !important;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new ClipboardJS('.copy-button');
});
</script>

<?php
include_once 'includes/footer.php';
?> 