<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>TLS 버전 체크</title>
    <meta name="description" content="웹사이트의 TLS 버전을 확인하고 보안 상태를 점검합니다.">
    <meta property="og:title" content="TLS 버전 체크">
    <meta property="og:description" content="웹사이트의 TLS 버전을 확인하고 보안 상태를 점검합니다.">
    <meta property="og:url" content="https://googsu.com/007-security-tools/tls-check">
    <meta property="og:image" content="https://googsu.com/images/tls-check-og-image.png">
    <style>
        .tls-check-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .input-group input {
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
        }

        .btn {
            padding: 10px 20px;
            background-color: #1971c2;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn:hover {
            background-color: #1864ab;
        }

        .result {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="tls-check-container">
                <div class="input-group">
                    <label for="urlInput">웹사이트 URL 입력:</label>
                    <input type="text" id="urlInput" placeholder="예: https://example.com">
                    <button class="btn">TLS 버전 확인</button>
                </div>
                <div class="result" id="tlsResult">
                    <h3>결과</h3>
                    <pre id="resultText">웹사이트 URL을 입력하고 'TLS 버전 확인' 버튼을 클릭하세요.</pre>
                </div>
                <div id="cert-subject" class="status"></div>
                <div id="cert-issuer" class="status"></div>
                <div id="cert-validity" class="status"></div>
                <div id="cert-serial" class="status"></div>
                <div id="cert-version" class="status"></div>
                <div id="cert-algorithm" class="status"></div>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>

    <div id="loading" style="display: none;">로딩 중...</div>
    <div id="error-message" style="display: none; color: red;"></div>

    <script>
        const urlInput = document.getElementById('urlInput');
        const checkButton = document.querySelector('.btn');
        const loadingDiv = document.getElementById('loading');
        const resultDiv = document.getElementById('tlsResult');
        const errorDiv = document.getElementById('error-message');

        checkButton.addEventListener('click', async function() {
            const url = urlInput.value.trim();
            if (!url) {
                showError('URL을 입력해주세요.');
                return;
            }

            if (!url.startsWith('https://')) {
                showError('HTTPS URL을 입력해주세요.');
                return;
            }

            showLoading();
            clearResults();

            try {
                const response = await fetch('/api/check-tls.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ url: url })
                });

                if (!response.ok) {
                    throw new Error('서버 오류가 발생했습니다.');
                }

                const data = await response.json();
                showResults(data);
            } catch (error) {
                showError(error.message);
            } finally {
                hideLoading();
            }
        });

        function showLoading() {
            loadingDiv.style.display = 'block';
            resultDiv.style.display = 'none';
            errorDiv.style.display = 'none';
        }

        function hideLoading() {
            loadingDiv.style.display = 'none';
            resultDiv.style.display = 'block';
        }

        function clearResults() {
            const statuses = document.querySelectorAll('.status');
            statuses.forEach(status => {
                status.textContent = '';
                status.className = 'status';
            });

            // 인증서 정보 초기화
            document.getElementById('cert-subject').textContent = '';
            document.getElementById('cert-issuer').textContent = '';
            document.getElementById('cert-validity').textContent = '';
            document.getElementById('cert-serial').textContent = '';
            document.getElementById('cert-version').textContent = '';
            document.getElementById('cert-algorithm').textContent = '';

            errorDiv.style.display = 'none';
        }

        function showResults(data) {
            // TLS 버전 결과 표시
            Object.entries(data.tls_versions).forEach(([version, supported]) => {
                const element = document.getElementById(version);
                if (element) {
                    const statusSpan = element.querySelector('.status');
                    statusSpan.textContent = supported ? '지원됨' : '지원되지 않음';
                    statusSpan.className = `status ${supported ? 'supported' : 'not-supported'}`;
                }
            });

            // 인증서 정보 표시
            if (data.certificate) {
                const cert = data.certificate;
                document.getElementById('cert-subject').textContent = cert.subject;
                document.getElementById('cert-issuer').textContent = cert.issuer;
                document.getElementById('cert-validity').textContent = 
                    `${formatDate(cert.validFrom)} ~ ${formatDate(cert.validTo)}`;
                document.getElementById('cert-serial').textContent = cert.serialNumber;
                document.getElementById('cert-version').textContent = cert.version;
                document.getElementById('cert-algorithm').textContent = cert.signatureAlgorithm;
            }
        }

        function formatDate(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleString('ko-KR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
        }

        function showError(message) {
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            resultDiv.style.display = 'none';
        }
    </script>
</body>
</html> 