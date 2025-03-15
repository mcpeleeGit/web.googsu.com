document.addEventListener('DOMContentLoaded', function() {
    const contentInput = document.getElementById('content');
    const sizeSelect = document.getElementById('size');
    const marginSelect = document.getElementById('margin');
    const generateButton = document.getElementById('generate-qr');
    const downloadPngButton = document.getElementById('download-png');
    const downloadSvgButton = document.getElementById('download-svg');
    const loadingDiv = document.getElementById('loading');
    const resultDiv = document.getElementById('result');
    const errorDiv = document.getElementById('error-message');
    const qrCodeImg = document.getElementById('qr-code');

    generateButton.addEventListener('click', async function() {
        const content = contentInput.value.trim();
        if (!content) {
            showError('내용을 입력해주세요.');
            return;
        }

        showLoading();
        clearResults();

        try {
            const response = await fetch('/api/generate-qr.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    content: content,
                    size: parseInt(sizeSelect.value),
                    margin: parseInt(marginSelect.value),
                    format: 'png'
                })
            });

            if (!response.ok) {
                throw new Error('QR코드 생성 중 오류가 발생했습니다.');
            }

            const data = await response.json();
            if (data.success) {
                showResults(data);
            } else {
                throw new Error(data.error || 'QR코드 생성 중 오류가 발생했습니다.');
            }
        } catch (error) {
            showError(error.message);
        } finally {
            hideLoading();
        }
    });

    downloadPngButton.addEventListener('click', async function() {
        await generateAndDownload('png');
    });

    downloadSvgButton.addEventListener('click', async function() {
        await generateAndDownload('svg');
    });

    async function generateAndDownload(format) {
        const content = contentInput.value.trim();
        if (!content) {
            showError('내용을 입력해주세요.');
            return;
        }

        try {
            const response = await fetch('/api/generate-qr.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    content: content,
                    size: parseInt(sizeSelect.value),
                    margin: parseInt(marginSelect.value),
                    format: format
                })
            });

            if (!response.ok) {
                throw new Error('QR코드 생성 중 오류가 발생했습니다.');
            }

            const data = await response.json();
            if (data.success) {
                downloadFile(data.data, `qrcode.${format}`, format);
            } else {
                throw new Error(data.error || 'QR코드 생성 중 오류가 발생했습니다.');
            }
        } catch (error) {
            showError(error.message);
        }
    }

    function downloadFile(content, filename, format) {
        const link = document.createElement('a');
        if (format === 'png') {
            link.href = content;
        } else {
            const blob = new Blob([content], { type: 'image/svg+xml' });
            link.href = URL.createObjectURL(blob);
        }
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

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
        qrCodeImg.src = '';
        errorDiv.style.display = 'none';
    }

    function showResults(data) {
        qrCodeImg.src = data.data;
        resultDiv.style.display = 'block';
    }

    function showError(message) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        resultDiv.style.display = 'none';
    }
}); 