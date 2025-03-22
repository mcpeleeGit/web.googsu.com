<?php
$page_title = '문자 수 세기 / 바이트 계산기';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>문자 수 세기 / 바이트 계산기</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-5">
                        <textarea name="input" 
                                  class="form-control large-textarea" 
                                  rows="8" 
                                  placeholder="문자 수를 세거나 바이트를 계산할 텍스트를 입력하세요"
                                  required><?php echo isset($_POST['input']) ? htmlspecialchars($_POST['input']) : ''; ?></textarea>
                    </div>
                    
                    <div class="button-group mt-4">
                        <button type="submit" name="action" value="count" class="mui-button large-button">
                            <i class="fas fa-calculator"></i> 계산하기
                        </button>
                    </div>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $input = $_POST['input'] ?? '';
                    $result = [];
                    $error = '';

                    if (!empty($input)) {
                        // 문자 수 계산
                        $result = [
                            'char_count' => mb_strlen($input, 'UTF-8'),
                            'byte_count' => strlen($input),
                            'word_count' => str_word_count($input),
                            'line_count' => substr_count($input, "\n") + 1,
                            'byte_utf8' => mb_strlen($input, 'UTF-8') * 3, // UTF-8 기준 (한글 3바이트)
                            'byte_ascii' => strlen($input), // ASCII 기준
                            'byte_unicode' => mb_strlen($input, 'UTF-8') * 2, // Unicode 기준 (한글 2바이트)
                        ];
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
                        <h3>계산 결과</h3>
                        <div class="result-box counter-results">
                            <div class="counter-item">
                                <div class="counter-label">문자 수 (공백 포함)</div>
                                <div class="counter-value"><?php echo number_format($result['char_count']); ?>자</div>
                            </div>
                            <div class="counter-item">
                                <div class="counter-label">단어 수</div>
                                <div class="counter-value"><?php echo number_format($result['word_count']); ?>개</div>
                            </div>
                            <div class="counter-item">
                                <div class="counter-label">줄 수</div>
                                <div class="counter-value"><?php echo number_format($result['line_count']); ?>줄</div>
                            </div>
                            <div class="counter-item">
                                <div class="counter-label">바이트 (ASCII)</div>
                                <div class="counter-value"><?php echo number_format($result['byte_ascii']); ?>바이트</div>
                            </div>
                            <div class="counter-item">
                                <div class="counter-label">바이트 (UTF-8)</div>
                                <div class="counter-value"><?php echo number_format($result['byte_utf8']); ?>바이트</div>
                            </div>
                            <div class="counter-item">
                                <div class="counter-label">바이트 (Unicode)</div>
                                <div class="counter-value"><?php echo number_format($result['byte_unicode']); ?>바이트</div>
                            </div>
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
                    <li>입력한 텍스트의 문자 수, 단어 수, 줄 수, 바이트 수를 계산합니다.</li>
                    <li>바이트 계산 방식:
                        <ul>
                            <li>ASCII: 영문 1바이트, 한글 1바이트</li>
                            <li>UTF-8: 영문 1바이트, 한글 3바이트</li>
                            <li>Unicode: 영문 1바이트, 한글 2바이트</li>
                        </ul>
                    </li>
                    <li>단어 수는 공백으로 구분된 단어의 개수를 계산합니다.</li>
                    <li>줄 수는 줄바꿈 문자(\n)의 개수 + 1로 계산합니다.</li>
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
    text-align: left;
}

.counter-results {
    background-color: #fff;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.counter-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    border-bottom: 1px solid #eee;
}

.counter-item:last-child {
    border-bottom: none;
}

.counter-label {
    font-weight: bold;
    color: var(--mui-text-secondary);
}

.counter-value {
    font-size: 1.2rem;
    color: var(--mui-primary);
    font-weight: bold;
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

<?php
include_once 'includes/footer.php';
?> 