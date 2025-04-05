<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Hash 생성기</title>
    <meta name="description" content="다양한 해시 알고리즘을 사용하여 문자열의 해시를 생성합니다.">
    <meta property="og:title" content="Hash 생성기">
    <meta property="og:description" content="다양한 해시 알고리즘을 사용하여 문자열의 해시를 생성합니다.">
    <meta property="og:url" content="https://googsu.com/002-text-tools/hash-generator">
    <meta property="og:image" content="https://googsu.com/images/hash-generator-og-image.png">
    <style>
        .hash-generator-container {
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

        .generate-button {
            background-color: #1971c2;
            color: white;
        }

        .generate-button:hover {
            background-color: #1864ab;
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
            <div class="hash-generator-container">
                <div class="input-section">
                    <div class="input-group">
                        <label>문자열 입력</label>
                        <textarea name="input" placeholder="해시를 생성할 문자열을 입력하세요"></textarea>
                    </div>
                    <div class="buttons">
                        <button class="action-button generate-button" type="button" onclick="generateHash()">
                            <i class="fas fa-hashtag"></i> 해시 생성
                        </button>
                    </div>
                </div>
                <div class="result-section">
                    <div class="result-title">
                        <i class="fas fa-file-code"></i>
                        결과
                    </div>
                    <div class="result-box">
                        <div class="part-header">MD5</div>
                        <div class="part-content" id="md5-result"></div>
                    </div>
                    <div class="result-box">
                        <div class="part-header">SHA-1</div>
                        <div class="part-content" id="sha1-result"></div>
                    </div>
                    <div class="result-box">
                        <div class="part-header">SHA-256</div>
                        <div class="part-content" id="sha256-result"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateHash() {
            const input = document.querySelector('textarea[name="input"]').value;
            if (!input) {
                alert('문자열을 입력하세요.');
                return;
            }

            // MD5 해시 생성
            const md5 = CryptoJS.MD5(input);
            document.getElementById('md5-result').textContent = md5;

            // SHA-1 해시 생성
            const sha1 = CryptoJS.SHA1(input);
            document.getElementById('sha1-result').textContent = sha1;

            // SHA-256 해시 생성
            const sha256 = CryptoJS.SHA256(input);
            document.getElementById('sha256-result').textContent = sha256;
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
</body>
</html> 