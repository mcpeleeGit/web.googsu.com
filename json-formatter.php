<?php
$page_title = 'JSON 포맷터/뷰어';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>JSON 포맷터/뷰어</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-5">
                        <textarea name="input" 
                                  class="form-control large-textarea" 
                                  rows="8" 
                                  placeholder="JSON 데이터를 입력하세요"
                                  required><?php echo isset($_POST['input']) ? htmlspecialchars($_POST['input']) : '{
  "name": "홍길동",
  "age": 30,
  "email": "hong@example.com",
  "address": {
    "street": "서울시 강남구",
    "city": "서울",
    "country": "대한민국"
  },
  "hobbies": ["독서", "운동", "음악"],
  "isActive": true
}'; ?></textarea>
                    </div>
                    
                    <div class="button-group mt-4">
                        <button type="submit" name="action" value="format" class="mui-button large-button">
                            <i class="fas fa-code"></i> 포맷팅
                        </button>
                        <button type="submit" name="action" value="minify" class="mui-button large-button">
                            <i class="fas fa-compress-alt"></i> 압축
                        </button>
                        <button type="submit" name="action" value="validate" class="mui-button large-button">
                            <i class="fas fa-check-circle"></i> 검증
                        </button>
                    </div>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $input = $_POST['input'] ?? '';
                    $action = $_POST['action'] ?? '';
                    $result = '';
                    $error = '';
                    $isValid = false;

                    if (!empty($input)) {
                        $json = json_decode($input);
                        $isValid = json_last_error() === JSON_ERROR_NONE;

                        if ($isValid) {
                            switch ($action) {
                                case 'format':
                                    $result = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    break;
                                case 'minify':
                                    $result = json_encode($json, JSON_UNESCAPED_UNICODE);
                                    break;
                                case 'validate':
                                    $result = "JSON 데이터가 유효합니다.\n\n구조:\n" . json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    break;
                            }
                        } else {
                            $error = '올바른 JSON 형식이 아닙니다: ' . json_last_error_msg();
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
                    <li>포맷팅: JSON 데이터를 보기 좋게 들여쓰기하여 표시합니다.</li>
                    <li>압축: JSON 데이터에서 불필요한 공백을 제거합니다.</li>
                    <li>검증: JSON 데이터의 유효성을 검사하고 구조를 보여줍니다.</li>
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

.mb-5 {
    margin-bottom: 3rem !important;
}

.mt-4 {
    margin-top: 1.5rem !important;
}

.input-group {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
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