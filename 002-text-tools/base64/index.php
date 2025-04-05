<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Googsu Base64 인코더/디코더</title>
    <meta name="description" content="Googsu의 Base64 인코더/디코더를 사용하여 텍스트를 인코딩하거나 디코딩하세요.">
    <meta property="og:title" content="Googsu Base64 인코더/디코더">
    <meta property="og:description" content="Googsu의 Base64 인코더/디코더를 사용하여 텍스트를 인코딩하거나 디코딩하세요.">
    <meta property="og:url" content="https://googsu.com/003-encoder/base64">
    <meta property="og:image" content="https://googsu.com/images/base64-og-image.png">
    <style>
        .base64-encoder-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            padding: 20px;
        }

        .input-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .input-group label {
            font-weight: bold;
            color: #495057;
        }

        textarea {
            width: 100%;
            height: 120px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            resize: vertical;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .action-button {
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

        .encode-button {
            background-color: #1971c2;
            color: white;
        }

        .encode-button:hover {
            background-color: #1864ab;
        }

        .decode-button {
            background-color: #e9ecef;
            color: #495057;
        }

        .decode-button:hover {
            background-color: #dee2e6;
        }

        .result-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .result-title {
            font-size: 1.1em;
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .result-box {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .result-box:last-child {
            margin-bottom: 0;
        }

        .part-header {
            font-size: 0.9em;
            color: #1971c2;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .part-content {
            font-family: monospace;
            font-size: 0.9em;
            color: #495057;
            white-space: pre-wrap;
            word-break: break-all;
        }

        .error-message {
            color: #e03131;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="base64-encoder-container">
                <div class="input-section">
                    <div class="input-group">
                        <label>텍스트 입력</label>
                        <textarea name="input" placeholder="인코딩 또는 디코딩할 텍스트를 입력하세요"><?php echo isset($_POST['input']) ? htmlspecialchars($_POST['input']) : ''; ?></textarea>
                    </div>
                    <div class="buttons">
                        <button class="action-button encode-button" type="submit" name="action" value="encode">
                            <i class="fas fa-arrow-up"></i> 인코딩
                        </button>
                        <button class="action-button decode-button" type="submit" name="action" value="decode">
                            <i class="fas fa-arrow-down"></i> 디코딩
                        </button>
                    </div>
                </div>
                <div class="result-section">
                    <div class="result-title">
                        <i class="fas fa-file-code"></i>
                        결과
                    </div>
                    <div class="result-box">
                        <textarea class="form-control" rows="4" readonly><?php echo isset($result) ? htmlspecialchars($result) : ''; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script>
        function encodeBase64() {
            const input = document.querySelector('textarea[name="input"]').value;
            try {
                const encoded = btoa(input);
                document.querySelector('.result-box textarea').value = encoded;
            } catch (error) {
                alert('인코딩 중 오류가 발생했습니다.');
            }
        }

        function decodeBase64() {
            const input = document.querySelector('textarea[name="input"]').value;
            try {
                const decoded = atob(input);
                document.querySelector('.result-box textarea').value = decoded;
            } catch (error) {
                alert('디코딩 중 오류가 발생했습니다.');
            }
        }

        document.querySelector('.encode-button').addEventListener('click', encodeBase64);
        document.querySelector('.decode-button').addEventListener('click', decodeBase64);
    </script>
</body>
</html> 