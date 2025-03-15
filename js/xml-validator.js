function validateXML() {
    const xmlInput = document.getElementById('xml-input').value.trim();
    const validationResult = document.getElementById('validation-result');

    // 입력값 검증
    if (!xmlInput) {
        showError('XML 문서를 입력해주세요.');
        return;
    }

    try {
        // XML 파싱
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(xmlInput, 'text/xml');
        
        // 파싱 에러 확인
        const parserError = xmlDoc.getElementsByTagName('parsererror');
        if (parserError.length > 0) {
            showError(parserError[0].textContent);
            return;
        }

        // XML 유효성 검사
        const isValid = xmlDoc.documentElement !== null;
        if (isValid) {
            showSuccess('XML 문서가 유효합니다.');
        } else {
            showError('XML 문서가 유효하지 않습니다.');
        }
    } catch (error) {
        showError('XML 검증 중 오류가 발생했습니다: ' + error.message);
    }
}

function formatXML() {
    const xmlInput = document.getElementById('xml-input').value.trim();
    const formattedOutput = document.getElementById('formatted-output');

    // 입력값 검증
    if (!xmlInput) {
        showError('XML 문서를 입력해주세요.');
        return;
    }

    try {
        // XML 파싱
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(xmlInput, 'text/xml');
        
        // 파싱 에러 확인
        const parserError = xmlDoc.getElementsByTagName('parsererror');
        if (parserError.length > 0) {
            showError(parserError[0].textContent);
            return;
        }

        // XML 포맷팅
        const serializer = new XMLSerializer();
        const formattedXML = formatXMLString(serializer.serializeToString(xmlDoc));
        
        // 구문 강조 적용
        formattedOutput.innerHTML = highlightXML(formattedXML);
    } catch (error) {
        showError('XML 포맷팅 중 오류가 발생했습니다: ' + error.message);
    }
}

function formatXMLString(xml) {
    let formatted = '';
    let indent = 0;
    const tab = '    ';

    xml.split(/>\s*</).forEach(function(node) {
        if (node.match(/^\/\w/)) indent--;
        formatted += tab.repeat(indent) + '<' + node + '>\n';
        if (node.match(/^<?\w[^>]*[^\/]$/)) indent++;
    });

    return formatted.substring(1, formatted.length - 2);
}

function highlightXML(xml) {
    return xml
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/(".*?")/g, '<span class="xml-attribute">$1</span>')
        .replace(/&lt;(\/)?([^!][^&]*?)&gt;/g, '<span class="xml-tag">&lt;$1$2&gt;</span>')
        .replace(/&lt;!--(.*?)--&gt;/g, '<span class="xml-comment">&lt;!--$1--&gt;</span>');
}

function clearText() {
    document.getElementById('xml-input').value = '';
    document.getElementById('validation-result').textContent = '';
    document.getElementById('formatted-output').textContent = '';
    
    // 이전 메시지 제거
    const messages = document.querySelectorAll('.error, .success');
    messages.forEach(msg => msg.remove());
}

function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error';
    errorDiv.textContent = message;
    
    const xmlValidator = document.querySelector('.xml-validator');
    xmlValidator.insertBefore(errorDiv, xmlValidator.firstChild);
    
    // 3초 후 에러 메시지 제거
    setTimeout(() => {
        errorDiv.remove();
    }, 3000);
}

function showSuccess(message) {
    const successDiv = document.createElement('div');
    successDiv.className = 'success';
    successDiv.textContent = message;
    
    const xmlValidator = document.querySelector('.xml-validator');
    xmlValidator.insertBefore(successDiv, xmlValidator.firstChild);
    
    // 3초 후 성공 메시지 제거
    setTimeout(() => {
        successDiv.remove();
    }, 3000);
} 