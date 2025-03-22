<?php
$page_title = 'Markdown 뷰어/변환기';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>Markdown 뷰어/변환기</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-5">
                        <textarea name="input" 
                                  class="form-control large-textarea" 
                                  rows="8" 
                                  placeholder="Markdown 텍스트를 입력하세요"
                                  required><?php echo isset($_POST['input']) ? htmlspecialchars($_POST['input']) : '# 제목 1
## 제목 2
### 제목 3

- 순서 없는 목록
- 항목 2
- 항목 3

1. 순서 있는 목록
2. 항목 2
3. 항목 3

**굵은 텍스트**와 *기울임꼴*

[링크](https://example.com)

```php
echo "Hello, World!";
```'; ?></textarea>
                    </div>
                    
                    <div class="button-group mt-4">
                        <button type="submit" name="action" value="preview" class="mui-button large-button">
                            <i class="fas fa-eye"></i> 미리보기
                        </button>
                        <button type="submit" name="action" value="html" class="mui-button large-button">
                            <i class="fas fa-code"></i> HTML 변환
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
                            case 'preview':
                                // Markdown 변환 로직 개선
                                $result = $input;
                                
                                // 코드 블록 처리 (개선된 버전)
                                $result = preg_replace_callback('/```(\w+)?\s*(.*?)```/s', function($matches) {
                                    $language = !empty($matches[1]) ? htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8') : '';
                                    $code = htmlspecialchars(trim($matches[2]), ENT_QUOTES, 'UTF-8');
                                    return sprintf('<pre><code class="language-%s">%s</code></pre>', $language, $code);
                                }, $result);
                                
                                // 인라인 코드 처리 (개선된 버전)
                                $result = preg_replace_callback('/`([^`]+)`/', function($matches) {
                                    return '<code>' . htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8') . '</code>';
                                }, $result);
                                
                                // 제목 처리 (개선된 버전)
                                $result = preg_replace('/^# (.*)$/m', '<h1>$1</h1>', $result);
                                $result = preg_replace('/^## (.*)$/m', '<h2>$1</h2>', $result);
                                $result = preg_replace('/^### (.*)$/m', '<h3>$1</h3>', $result);
                                
                                // 굵은 텍스트와 기울임꼴 처리 (개선된 버전)
                                $result = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $result);
                                $result = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $result);
                                
                                // 링크 처리 (개선된 버전)
                                $result = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $result);
                                
                                // 순서 없는 목록 처리 (개선된 버전)
                                $result = preg_replace('/^\s*[-*]\s+(.*)$/m', '<li>$1</li>', $result);
                                $result = preg_replace('/(<li>.*<\/li>)\n?/s', '<ul>$1</ul>', $result);
                                
                                // 순서 있는 목록 처리 (개선된 버전)
                                $result = preg_replace('/^\s*\d+\.\s+(.*)$/m', '<li>$1</li>', $result);
                                $result = preg_replace('/(<li>.*<\/li>)\n?/s', '<ol>$1</ol>', $result);
                                
                                // 줄바꿈 처리
                                $result = nl2br($result);
                                
                                // 중복된 ul/ol 태그 제거
                                $result = preg_replace('/<\/ul>\s*<ul>/', '', $result);
                                $result = preg_replace('/<\/ol>\s*<ol>/', '', $result);
                                
                                // 불필요한 빈 줄 제거
                                $result = preg_replace('/<br\s*\/?>\s*<br\s*\/?>/', '<br>', $result);
                                break;
                            case 'html':
                                // HTML로 변환 (실제 구현에서는 Markdown 파서 라이브러리 사용 권장)
                                $result = $input;
                                
                                // 코드 블록 마커 제거
                                $result = preg_replace('/```(\w+)?\n/', '', $result);
                                $result = preg_replace('/```$/', '', $result);
                                
                                // 인라인 코드 마커 제거
                                $result = preg_replace('/`([^`]+)`/', '$1', $result);
                                
                                // HTML 특수문자 이스케이프
                                $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
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
                        <div class="result-box markdown-preview">
                            <?php echo $result; ?>
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
                    <li>미리보기: Markdown 텍스트를 HTML로 변환하여 보여줍니다.</li>
                    <li>HTML 변환: Markdown 텍스트를 HTML 코드로 변환합니다.</li>
                    <li>복사하기 버튼을 클릭하면 결과를 클립보드에 복사할 수 있습니다.</li>
                    <li>지원되는 Markdown 문법:
                        <ul>
                            <li>제목 (#, ##, ###)</li>
                            <li>굵은 텍스트 (**텍스트**)</li>
                            <li>기울임꼴 (*텍스트*)</li>
                            <li>링크 [텍스트](URL)</li>
                            <li>코드 블록 (```)</li>
                            <li>순서 있는/없는 목록</li>
                        </ul>
                    </li>
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

.result-box pre {
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: monospace;
}

.markdown-preview {
    background-color: #fff;
    padding: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.markdown-preview h1 {
    font-size: 2em;
    margin-bottom: 0.5em;
    color: var(--mui-primary);
}

.markdown-preview h2 {
    font-size: 1.5em;
    margin-bottom: 0.5em;
    color: var(--mui-primary);
}

.markdown-preview h3 {
    font-size: 1.2em;
    margin-bottom: 0.5em;
    color: var(--mui-primary);
}

.markdown-preview ul, .markdown-preview ol {
    padding-left: 2em;
    margin-bottom: 1em;
}

.markdown-preview li {
    margin-bottom: 0.5em;
}

.markdown-preview code {
    background-color: #f8f9fa;
    padding: 0.2em 0.4em;
    border-radius: 3px;
    font-family: monospace;
}

.markdown-preview pre {
    background-color: #f8f9fa;
    padding: 1em;
    border-radius: 4px;
    overflow-x: auto;
}

.markdown-preview a {
    color: var(--mui-primary);
    text-decoration: none;
}

.markdown-preview a:hover {
    text-decoration: underline;
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