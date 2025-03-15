document.addEventListener('DOMContentLoaded', function() {
    // XML 검증 폼 처리
    const xmlForm = document.querySelector('#xml-validator form');
    const xmlResult = document.getElementById('xml-result');
    
    if (xmlForm) {
        xmlForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('includes/validate_xml.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    let message = `<div class="alert ${data.result.valid ? 'success' : 'error'}">`;
                    message += `<p>${data.message}</p>`;
                    
                    if (!data.result.valid && data.result.errors.length > 0) {
                        message += '<ul class="error-list">';
                        data.result.errors.forEach(error => {
                            message += `<li>Line ${error.line}: ${error.message}</li>`;
                        });
                        message += '</ul>';
                    }
                    
                    message += '</div>';
                    xmlResult.innerHTML = message;
                } else {
                    xmlResult.innerHTML = `<div class="alert error">${data.message}</div>`;
                }
            } catch (error) {
                xmlResult.innerHTML = `<div class="alert error">오류가 발생했습니다: ${error.message}</div>`;
            }
        });
    }
    
    // 16진수-이미지 변환 폼 처리
    const hexForm = document.querySelector('#hex-to-image form');
    const imagePreview = document.getElementById('image-preview');
    
    if (hexForm) {
        hexForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('includes/convert_hex.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    let message = `<div class="alert success">`;
                    message += `<p>${data.message}</p>`;
                    message += `<img src="${data.result.url}" alt="변환된 이미지" style="max-width: 100%;">`;
                    message += `<p><a href="${data.result.url}" download>이미지 다운로드</a></p>`;
                    message += '</div>';
                    imagePreview.innerHTML = message;
                } else {
                    imagePreview.innerHTML = `<div class="alert error">${data.message}</div>`;
                }
            } catch (error) {
                imagePreview.innerHTML = `<div class="alert error">오류가 발생했습니다: ${error.message}</div>`;
            }
        });
    }
}); 