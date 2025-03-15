function decodeJWT() {
    const jwtInput = document.getElementById('jwt-input').value.trim();
    const headerOutput = document.getElementById('header-output');
    const payloadOutput = document.getElementById('payload-output');
    const signatureOutput = document.getElementById('signature-output');

    // 입력값 검증
    if (!jwtInput) {
        showError('JWT 토큰을 입력해주세요.');
        return;
    }

    // JWT 형식 검증 (header.payload.signature)
    const parts = jwtInput.split('.');
    if (parts.length !== 3) {
        showError('올바른 JWT 형식이 아닙니다.');
        return;
    }

    try {
        // 헤더 디코딩
        const header = JSON.parse(atob(parts[0]));
        headerOutput.textContent = JSON.stringify(header, null, 2);

        // 페이로드 디코딩
        const payload = JSON.parse(atob(parts[1]));
        payloadOutput.textContent = JSON.stringify(payload, null, 2);

        // 서명 표시
        signatureOutput.textContent = parts[2];

        // 만료 시간이 있는 경우 표시
        if (payload.exp) {
            const expDate = new Date(payload.exp * 1000);
            const now = new Date();
            const isExpired = expDate < now;
            
            const expInfo = document.createElement('div');
            expInfo.className = isExpired ? 'error' : 'info';
            expInfo.textContent = `만료 시간: ${expDate.toLocaleString()} (${isExpired ? '만료됨' : '유효함'})`;
            payloadOutput.parentNode.insertBefore(expInfo, payloadOutput.nextSibling);
        }
    } catch (error) {
        showError('JWT 디코딩 중 오류가 발생했습니다.');
        console.error('JWT 디코딩 오류:', error);
    }
}

function clearText() {
    document.getElementById('jwt-input').value = '';
    document.getElementById('header-output').textContent = '';
    document.getElementById('payload-output').textContent = '';
    document.getElementById('signature-output').textContent = '';
    
    // 이전 에러 메시지 제거
    const errorMessages = document.querySelectorAll('.error, .info');
    errorMessages.forEach(msg => msg.remove());
}

function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error';
    errorDiv.textContent = message;
    
    const jwtDecoder = document.querySelector('.jwt-decoder');
    jwtDecoder.insertBefore(errorDiv, jwtDecoder.firstChild);
    
    // 3초 후 에러 메시지 제거
    setTimeout(() => {
        errorDiv.remove();
    }, 3000);
} 