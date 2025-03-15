function switchTab(tabId) {
    // 모든 패널 숨기기
    document.querySelectorAll('.conversion-panel').forEach(panel => {
        panel.classList.remove('active');
    });
    
    // 모든 탭 버튼 비활성화
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // 선택된 패널과 탭 버튼 활성화
    document.getElementById(tabId).classList.add('active');
    event.target.classList.add('active');
}

function hexToImage() {
    const hexInput = document.getElementById('hex-input').value.trim();
    const imageOutput = document.getElementById('hex-image-output');

    // 입력값 검증
    if (!hexInput) {
        showError('Hexadecimal 데이터를 입력해주세요.');
        return;
    }

    try {
        // Hex 문자열을 Uint8Array로 변환
        const bytes = new Uint8Array(hexInput.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));
        
        // 이미지 타입 확인 (PNG, JPEG, GIF 등)
        let imageType = 'image/png';  // 기본값
        if (bytes[0] === 0xFF && bytes[1] === 0xD8) {
            imageType = 'image/jpeg';
        } else if (bytes[0] === 0x47 && bytes[1] === 0x49 && bytes[2] === 0x46) {
            imageType = 'image/gif';
        }
        
        // Blob 생성
        const blob = new Blob([bytes], { type: imageType });
        
        // 이미지 URL 생성
        const imageUrl = URL.createObjectURL(blob);
        
        // 이미지 표시
        imageOutput.src = imageUrl;
        imageOutput.style.display = 'block';
        
        showSuccess('이미지로 변환되었습니다.');
    } catch (error) {
        showError('이미지 변환 중 오류가 발생했습니다. 올바른 이미지 데이터인지 확인해주세요.');
        console.error('이미지 변환 오류:', error);
    }
}

function handleImageUpload(event) {
    const file = event.target.files[0];
    const imagePreview = document.getElementById('image-preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function imageToHex() {
    const imagePreview = document.getElementById('image-preview');
    const hexOutput = document.getElementById('hex-output');

    if (imagePreview.src === '') {
        showError('이미지를 선택해주세요.');
        return;
    }

    try {
        // 이미지를 Canvas에 그리기
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = imagePreview.naturalWidth;
        canvas.height = imagePreview.naturalHeight;
        ctx.drawImage(imagePreview, 0, 0);

        // Canvas 데이터를 Blob으로 변환
        canvas.toBlob(function(blob) {
            const reader = new FileReader();
            reader.onload = function() {
                const arrayBuffer = reader.result;
                const bytes = new Uint8Array(arrayBuffer);
                const hex = Array.from(bytes).map(b => b.toString(16).padStart(2, '0')).join('');
                hexOutput.value = hex;
                showSuccess('Hexadecimal로 변환되었습니다.');
            };
            reader.readAsArrayBuffer(blob);
        }, 'image/png');
    } catch (error) {
        showError('Hexadecimal 변환 중 오류가 발생했습니다.');
        console.error('Hexadecimal 변환 오류:', error);
    }
}

function downloadImage(imageId) {
    const image = document.getElementById(imageId);
    if (image.src === '') {
        showError('다운로드할 이미지가 없습니다.');
        return;
    }

    const link = document.createElement('a');
    link.download = 'converted-image.png';
    link.href = image.src;
    link.click();
}

function copyHexToClipboard() {
    const hexOutput = document.getElementById('hex-output');
    if (!hexOutput.value) {
        showError('복사할 Hexadecimal 데이터가 없습니다.');
        return;
    }

    hexOutput.select();
    try {
        document.execCommand('copy');
        showSuccess('Hexadecimal 데이터가 클립보드에 복사되었습니다.');
    } catch (error) {
        showError('복사 중 오류가 발생했습니다.');
    }
}

function clearHexInput() {
    document.getElementById('hex-input').value = '';
    const imageOutput = document.getElementById('hex-image-output');
    imageOutput.src = '';
    imageOutput.style.display = 'none';
    
    // 메시지 제거
    const messages = document.querySelectorAll('.error, .success');
    messages.forEach(msg => msg.remove());
}

function clearImageInput() {
    document.getElementById('image-input').value = '';
    const imagePreview = document.getElementById('image-preview');
    imagePreview.src = '';
    imagePreview.style.display = 'none';
    document.getElementById('hex-output').value = '';
    
    // 메시지 제거
    const messages = document.querySelectorAll('.error, .success');
    messages.forEach(msg => msg.remove());
}

function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error';
    errorDiv.textContent = message;
    
    const hexImage = document.querySelector('.hex-image');
    hexImage.insertBefore(errorDiv, hexImage.firstChild);
    
    // 3초 후 에러 메시지 제거
    setTimeout(() => {
        errorDiv.remove();
    }, 3000);
}

function showSuccess(message) {
    const successDiv = document.createElement('div');
    successDiv.className = 'success';
    successDiv.textContent = message;
    
    const hexImage = document.querySelector('.hex-image');
    hexImage.insertBefore(successDiv, hexImage.firstChild);
    
    // 3초 후 성공 메시지 제거
    setTimeout(() => {
        successDiv.remove();
    }, 3000);
} 