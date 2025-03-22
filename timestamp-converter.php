<?php
$page_title = '타임스탬프 변환기';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>타임스탬프 변환기</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-5">
                        <textarea name="input" 
                                  class="form-control large-textarea" 
                                  rows="4" 
                                  placeholder="변환할 타임스탬프나 날짜를 입력하세요"
                                  required><?php echo isset($_POST['input']) ? htmlspecialchars($_POST['input']) : time(); ?></textarea>
                    </div>
                    
                    <div class="button-group mt-4">
                        <button type="submit" name="action" value="timestamp_to_date" class="mui-button large-button">
                            <i class="fas fa-calendar"></i> 타임스탬프 → 날짜
                        </button>
                        <button type="submit" name="action" value="date_to_timestamp" class="mui-button large-button">
                            <i class="fas fa-clock"></i> 날짜 → 타임스탬프
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
                        switch ($action) {
                            case 'timestamp_to_date':
                                if (is_numeric($input)) {
                                    $timestamp = (int)$input;
                                    if ($timestamp > 0) {
                                        $result = date('Y-m-d H:i:s', $timestamp);
                                    } else {
                                        $error = '올바른 타임스탬프를 입력해주세요.';
                                    }
                                } else {
                                    $error = '올바른 타임스탬프를 입력해주세요.';
                                }
                                break;
                            case 'date_to_timestamp':
                                $timestamp = strtotime($input);
                                if ($timestamp !== false) {
                                    $result = $timestamp;
                                } else {
                                    $error = '올바른 날짜 형식을 입력해주세요. (예: 2024-03-21 15:30:00)';
                                }
                                break;
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
                            <pre><?php echo htmlspecialchars($result); ?></pre>
                        </div>
                        <button class="mui-button copy-button" data-clipboard-text="<?php echo htmlspecialchars($result); ?>">
                            <i class="fas fa-copy"></i> 결과 복사
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
                    <li>타임스탬프 → 날짜: Unix 타임스탬프를 읽기 쉬운 날짜 형식으로 변환합니다.</li>
                    <li>날짜 → 타임스탬프: 날짜를 Unix 타임스탬프로 변환합니다.</li>
                    <li>날짜 형식 예시: 2024-03-21 15:30:00</li>
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
    text-align: center;
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