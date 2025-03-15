document.addEventListener('DOMContentLoaded', function() {
    const regexInput = document.getElementById('regex-input');
    const testInput = document.getElementById('test-input');
    const parseBtn = document.getElementById('parse-btn');
    const testBtn = document.getElementById('test-btn');
    const resultSection = document.querySelector('.regex-result-section');
    const regexMeaning = document.getElementById('regex-meaning');
    const testResult = document.getElementById('test-result');
    const exampleCards = document.querySelectorAll('.example-card code');

    // 예제 카드 클릭 이벤트
    exampleCards.forEach(card => {
        card.addEventListener('click', function() {
            regexInput.value = this.textContent;
            parseBtn.click(); // 자동으로 분석 실행
        });
    });

    // 정규식 분석
    parseBtn.addEventListener('click', function() {
        try {
            const regexStr = regexInput.value.trim();
            if (!regexStr) {
                throw new Error('정규식을 입력해주세요.');
            }

            // 정규식 문자열 파싱
            let pattern, flags;
            const match = regexStr.match(/^\/(.+)\/([gimuy]*)$/);
            
            if (match) {
                pattern = match[1];
                flags = match[2];
            } else {
                pattern = regexStr;
                flags = '';
            }

            // 정규식 객체 생성
            const regex = new RegExp(pattern, flags);
            const patternStr = pattern;
            
            // 정규식 의미 분석
            let meaning = '이 정규식은:\n';

            // 기본 패턴 분석
            if (patternStr.startsWith('^')) meaning += '- 문자열의 시작에서 매칭\n';
            if (patternStr.endsWith('$')) meaning += '- 문자열의 끝에서 매칭\n';

            // 문자 클래스 분석
            if (patternStr.includes('[a-z]')) meaning += '- 소문자 영문자 매칭\n';
            if (patternStr.includes('[A-Z]')) meaning += '- 대문자 영문자 매칭\n';
            if (patternStr.includes('[0-9]') || patternStr.includes('\\d')) meaning += '- 숫자 매칭\n';
            if (patternStr.includes('[가-힣]')) meaning += '- 한글 매칭\n';
            if (patternStr.includes('\\w')) meaning += '- 단어 문자(영문자, 숫자, 밑줄) 매칭\n';
            if (patternStr.includes('\\s')) meaning += '- 공백 문자 매칭\n';

            // 수량자 분석
            if (patternStr.includes('+')) meaning += '- 1회 이상 반복\n';
            if (patternStr.includes('*')) meaning += '- 0회 이상 반복\n';
            if (patternStr.includes('?')) meaning += '- 0회 또는 1회 매칭\n';
            if (patternStr.includes('{')) {
                const quantifier = patternStr.match(/\{(\d+)(,\d*)?\}/);
                if (quantifier) {
                    if (!quantifier[2]) {
                        meaning += `- 정확히 ${quantifier[1]}회 반복\n`;
                    } else if (quantifier[2] === ',') {
                        meaning += `- ${quantifier[1]}회 이상 반복\n`;
                    } else {
                        meaning += `- ${quantifier[1]}회부터 ${quantifier[2].slice(1)}회까지 반복\n`;
                    }
                }
            }

            // 특수 패턴 분석
            if (patternStr.includes('(?=')) meaning += '- 긍정적 전방 탐색 사용\n';
            if (patternStr.includes('(?!')) meaning += '- 부정적 전방 탐색 사용\n';
            if (patternStr.includes('[^')) meaning += '- 부정 문자 집합 사용\n';
            if (patternStr.includes('|')) meaning += '- OR 조건 사용\n';

            // 플래그 분석
            if (flags.includes('g')) meaning += '- 전역 검색 수행 (모든 일치 찾기)\n';
            if (flags.includes('i')) meaning += '- 대소문자 구분 없이 검색\n';
            if (flags.includes('m')) meaning += '- 여러 줄 모드로 검색\n';
            if (flags.includes('s')) meaning += '- .이 개행 문자도 매칭\n';
            if (flags.includes('u')) meaning += '- 유니코드 패턴 사용\n';
            if (flags.includes('y')) meaning += '- sticky 모드로 검색\n';

            // 특별한 패턴 분석
            if (patternStr.includes('@')) meaning += '- 이메일 주소 관련 패턴\n';
            if (patternStr.includes('https?')) meaning += '- URL 관련 패턴\n';
            if (patternStr.match(/\d{4}-\d{2}-\d{2}/)) meaning += '- 날짜 형식 패턴\n';

            regexMeaning.textContent = meaning;
            resultSection.style.display = 'block';

            // 테스트 입력값이 있으면 자동으로 테스트 실행
            if (testInput.value) {
                testRegex();
            }
        } catch (error) {
            alert('올바르지 않은 정규식입니다: ' + error.message);
        }
    });

    // 정규식 테스트
    testBtn.addEventListener('click', testRegex);

    function testRegex() {
        try {
            const regexStr = regexInput.value.trim();
            const testStr = testInput.value;

            if (!regexStr) {
                throw new Error('정규식을 입력해주세요.');
            }
            if (!testStr) {
                throw new Error('테스트할 문자열을 입력해주세요.');
            }

            // 정규식 객체 생성
            let pattern, flags;
            const match = regexStr.match(/^\/(.+)\/([gimuy]*)$/);
            
            if (match) {
                pattern = match[1];
                flags = match[2];
            } else {
                pattern = regexStr;
                flags = '';
            }

            const regex = new RegExp(pattern, flags);
            
            // 테스트 실행
            const matches = testStr.match(regex);
            if (matches) {
                testResult.innerHTML = `매칭됨:<br>${matches.map(m => `"${m}"`).join(', ')}`;
                testResult.style.color = '#28a745';
            } else {
                testResult.textContent = '매칭되지 않음';
                testResult.style.color = '#dc3545';
            }
            
            resultSection.style.display = 'block';
        } catch (error) {
            alert('테스트 실행 중 오류 발생: ' + error.message);
        }
    }
}); 