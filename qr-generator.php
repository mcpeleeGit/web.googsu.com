<?php
$page_title = 'QR 코드 생성기';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>QR 코드 생성기</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-5">
                        <textarea name="input" 
                                  class="form-control large-textarea" 
                                  rows="4" 
                                  placeholder="QR 코드로 변환할 텍스트를 입력하세요"
                                  required><?php echo isset($_POST['input']) ? htmlspecialchars($_POST['input']) : 'https://googsu.com'; ?></textarea>
                    </div>
                    
                    <div class="button-group mt-4">
                        <button type="submit" name="action" value="generate" class="mui-button large-button">
                            <i class="fas fa-qrcode"></i> QR 코드 생성
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
                        // QR 코드 생성을 위한 API URL (QR Server API 사용)
                        $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($input);
                        $result = $qr_url;
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
                        <h3>생성된 QR 코드</h3>
                        <div class="qr-box">
                            <img src="<?php echo htmlspecialchars($result); ?>" alt="QR Code" class="qr-image">
                        </div>
                        <div class="button-group">
                            <a href="<?php echo htmlspecialchars($result); ?>" class="mui-button" download="qr-code.png">
                                <i class="fas fa-download"></i> QR 코드 다운로드
                            </a>
                            <button class="mui-button copy-button" data-clipboard-text="<?php echo htmlspecialchars($input); ?>">
                                <i class="fas fa-copy"></i> 텍스트 복사
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
                    <li>텍스트, URL, 전화번호 등을 입력하여 QR 코드를 생성할 수 있습니다.</li>
                    <li>생성된 QR 코드는 다운로드하여 사용할 수 있습니다.</li>
                    <li>입력한 텍스트는 복사하기 버튼으로 클립보드에 복사할 수 있습니다.</li>
                    <li>QR 코드는 300x300 픽셀 크기로 생성됩니다.</li>
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

.qr-box {
    background-color: #fff;
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.qr-image {
    max-width: 300px;
    height: auto;
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