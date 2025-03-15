function encodeURL() {
    const inputText = document.getElementById('input-text').value;
    try {
        const encodedText = encodeURIComponent(inputText);
        document.getElementById('output-text').value = encodedText;
    } catch (error) {
        document.getElementById('output-text').value = '인코딩 중 오류가 발생했습니다.';
    }
}

function decodeURL() {
    const inputText = document.getElementById('input-text').value;
    try {
        const decodedText = decodeURIComponent(inputText);
        document.getElementById('output-text').value = decodedText;
    } catch (error) {
        document.getElementById('output-text').value = '디코딩 중 오류가 발생했습니다.';
    }
}

function clearText() {
    document.getElementById('input-text').value = '';
    document.getElementById('output-text').value = '';
}

function copyToClipboard() {
    const outputText = document.getElementById('output-text');
    outputText.select();
    try {
        document.execCommand('copy');
        alert('결과가 클립보드에 복사되었습니다.');
    } catch (error) {
        alert('복사 중 오류가 발생했습니다.');
    }
} 