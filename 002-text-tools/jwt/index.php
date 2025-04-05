<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Googsu JWT 디코더</title>
    <meta name="description" content="Googsu의 JWT 디코더를 사용하여 JWT 토큰을 쉽게 디코딩하세요.">
    <meta property="og:title" content="Googsu JWT 디코더">
    <meta property="og:description" content="Googsu의 JWT 디코더를 사용하여 JWT 토큰을 쉽게 디코딩하세요.">
    <meta property="og:url" content="https://googsu.com/003-encoder/jwt">
    <meta property="og:image" content="https://googsu.com/images/jwt-og-image.png">
    <style>
        .jwt-decoder-container {
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

        .decode-button {
            background-color: #1971c2;
            color: white;
        }

        .decode-button:hover {
            background-color: #1864ab;
        }

        .clear-button {
            background-color: #e9ecef;
            color: #495057;
        }

        .clear-button:hover {
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

        .result-part {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .result-part:last-child {
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
            <div class="jwt-decoder-container">
                <div class="input-section">
                    <div class="input-group">
                        <label>JWT 토큰</label>
                        <textarea id="input" placeholder="디코딩할 JWT 토큰을 입력하세요">eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c</textarea>
                    </div>
                    <div class="buttons">
                        <button class="action-button decode-button" onclick="decodeJwt()">
                            <i class="fas fa-key"></i> 디코딩
                        </button>
                        <button class="action-button clear-button" onclick="clearInput()">
                            <i class="fas fa-eraser"></i> 지우기
                        </button>
                    </div>
                </div>
                <div class="result-section">
                    <div class="result-title">
                        <i class="fas fa-file-code"></i>
                        디코딩 결과
                    </div>
                    <div id="result"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function decodeJwt() {
            const input = document.getElementById('input').value.trim();
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '';

            try {
                // JWT 파트 분리
                const parts = input.split('.');
                if (parts.length !== 3) {
                    throw new Error('유효하지 않은 JWT 형식입니다.');
                }

                // Base64Url 디코딩 함수
                const base64UrlDecode = (str) => {
                    // Base64Url을 Base64로 변환
                    const base64 = str.replace(/-/g, '+').replace(/_/g, '/');
                    const pad = base64.length % 4;
                    const paddedBase64 = pad ? base64 + '='.repeat(4 - pad) : base64;
                    
                    // Base64 디코딩 및 UTF-8 문자열로 변환
                    try {
                        return decodeURIComponent(atob(paddedBase64).split('').map(c =>
                            '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)
                        ).join(''));
                    } catch (e) {
                        throw new Error('잘못된 Base64 인코딩입니다.');
                    }
                };

                // 헤더와 페이로드 디코딩
                const header = JSON.parse(base64UrlDecode(parts[0]));
                const payload = JSON.parse(base64UrlDecode(parts[1]));

                // 결과 표시
                resultDiv.innerHTML = `
                    <div class="result-part">
                        <div class="part-header">
                            <i class="fas fa-file-code"></i> HEADER
                        </div>
                        <div class="part-content">${JSON.stringify(header, null, 2)}</div>
                    </div>
                    <div class="result-part">
                        <div class="part-header">
                            <i class="fas fa-file-alt"></i> PAYLOAD
                        </div>
                        <div class="part-content">${JSON.stringify(payload, null, 2)}</div>
                    </div>
                    <div class="result-part">
                        <div class="part-header">
                            <i class="fas fa-signature"></i> SIGNATURE
                        </div>
                        <div class="part-content">${parts[2]}</div>
                    </div>
                `;
            } catch (error) {
                resultDiv.innerHTML = `
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> ${error.message}
                    </div>
                `;
            }
        }

        function clearInput() {
            document.getElementById('input').value = '';
            document.getElementById('result').innerHTML = '';
        }

        // 페이지 로드 시 자동으로 디코딩 실행
        document.addEventListener('DOMContentLoaded', decodeJwt);

        // 텍스트 영역 탭 키 지원
        document.getElementById('input').addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 1;
            }
        });
    </script>
</body>
</html> 