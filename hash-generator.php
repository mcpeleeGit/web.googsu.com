<?php
$page_title = 'Hash 생성기';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>Hash 생성기</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-5">
                        <textarea name="input" 
                                  class="form-control large-textarea" 
                                  rows="8" 
                                  placeholder="해시를 생성할 텍스트를 입력하세요"
                                  required><?php echo isset($_POST['input']) ? htmlspecialchars($_POST['input']) : ''; ?></textarea>
                    </div>
                    
                    <div class="button-group mt-4">
                        <button type="submit" name="action" value="generate" class="mui-button large-button">
                            <i class="fas fa-hashtag"></i> 해시 생성
                        </button>
                    </div>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $input = $_POST['input'] ?? '';
                    $result = [];
                    $error = '';

                    if (!empty($input)) {
                        // 다양한 해시 알고리즘으로 해시 생성
                        $result = [
                            'md5' => md5($input),
                            'sha1' => sha1($input),
                            'sha256' => hash('sha256', $input),
                            'sha384' => hash('sha384', $input),
                            'sha512' => hash('sha512', $input),
                            'ripemd160' => hash('ripemd160', $input),
                            'whirlpool' => hash('whirlpool', $input),
                            'tiger192,4' => hash('tiger192,4', $input),
                            'snefru256' => hash('snefru256', $input),
                            'gost' => hash('gost', $input),
                            'adler32' => hash('adler32', $input),
                            'crc32' => hash('crc32', $input),
                            'crc32b' => hash('crc32b', $input),
                            'fnv132' => hash('fnv132', $input),
                            'fnv164' => hash('fnv164', $input),
                            'joaat' => hash('joaat', $input),
                            'haval128,3' => hash('haval128,3', $input),
                            'haval160,3' => hash('haval160,3', $input),
                            'haval192,3' => hash('haval192,3', $input),
                            'haval224,3' => hash('haval224,3', $input),
                            'haval256,3' => hash('haval256,3', $input)
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
                        <h3>해시 결과</h3>
                        <div class="result-box hash-results">
                            <?php foreach ($result as $algorithm => $hash): ?>
                                <div class="hash-item">
                                    <div class="hash-algorithm"><?php echo strtoupper($algorithm); ?></div>
                                    <div class="hash-value">
                                        <code><?php echo $hash; ?></code>
                                        <button class="mui-button copy-button" data-clipboard-text="<?php echo htmlspecialchars($hash); ?>">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
                    <li>입력한 텍스트를 다양한 해시 알고리즘으로 변환합니다.</li>
                    <li>지원되는 해시 알고리즘:
                        <ul>
                            <li>MD5 (128비트)</li>
                            <li>SHA1 (160비트)</li>
                            <li>SHA256 (256비트)</li>
                            <li>SHA384 (384비트)</li>
                            <li>SHA512 (512비트)</li>
                            <li>RIPEMD160 (160비트)</li>
                            <li>Whirlpool (512비트)</li>
                            <li>Tiger (192비트)</li>
                            <li>Snefru (256비트)</li>
                            <li>GOST (256비트)</li>
                            <li>Adler32 (32비트)</li>
                            <li>CRC32 (32비트)</li>
                            <li>FNV1 (32비트, 64비트)</li>
                            <li>JOAAT (32비트)</li>
                            <li>HAVAL (128~256비트)</li>
                        </ul>
                    </li>
                    <li>각 해시 값 옆의 복사 버튼을 클릭하여 해당 해시를 클립보드에 복사할 수 있습니다.</li>
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

.hash-results {
    background-color: #fff;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.hash-item {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    border-bottom: 1px solid #eee;
}

.hash-item:last-child {
    border-bottom: none;
}

.hash-algorithm {
    min-width: 150px;
    font-weight: bold;
    color: var(--mui-primary);
}

.hash-value {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-family: monospace;
    word-break: break-all;
}

.hash-value code {
    flex: 1;
    background-color: #f8f9fa;
    padding: 0.5rem;
    border-radius: 4px;
}

.copy-button {
    padding: 0.5rem;
    min-width: auto;
}

.copy-button i {
    margin-right: 0;
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new ClipboardJS('.copy-button');
});
</script>

<?php
include_once 'includes/footer.php';
?> 