document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('url');
    const checkButton = document.getElementById('check-tls');
    const loadingDiv = document.getElementById('loading');
    const resultDiv = document.getElementById('result');
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
}); 