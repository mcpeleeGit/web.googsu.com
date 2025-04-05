<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>QR Code Generator</title>
    <meta name="description" content="Generate QR codes easily from text input.">
    <meta property="og:title" content="QR Code Generator">
    <meta property="og:description" content="Generate QR codes easily from text input.">
    <meta property="og:url" content="https://googsu.com/004-converter/qr">
    <meta property="og:image" content="https://googsu.com/images/qr-code-og-image.png">
    <style>
        .qr-generator {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            padding: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .input-group label {
            font-weight: bold;
            color: #495057;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
        }

        .button-group {
            display: flex;
            gap: 10px;
        }

        .mui-button {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mui-button:hover {
            background-color: #1864ab;
        }

        .result-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .qr-box {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: white;
        }

        .qr-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="qr-generator">
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
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new ClipboardJS('.copy-button');
});
</script>
</body>
</html> 