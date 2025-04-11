<div class="menu-area">
    <a href="/" class="home-icon">
        <i class="fas fa-home"></i>
    </a>
    <div class="dropdown">
        <a href="#" class="menu-icon">
            <i class="fas fa-code"></i>
        </a>
        <div class="dropdown-content">
            <a href="/002-text-tools/compare">
                <i class="fas fa-code-compare"></i>
                <span>텍스트 비교</span>
            </a>
            <a href="/002-text-tools/counter">
                <i class="fas fa-calculator"></i>
                <span>문자수 세기</span>            
            </a>            
            <a href="/002-text-tools/url">
                <i class="fas fa-link"></i>
                <span>URL 인코더/디코더</span>
            </a>
            <a href="/002-text-tools/jwt">
                <i class="fas fa-key"></i>
                <span>JWT 디코더</span>
            </a>
            <a href="/002-text-tools/base64">
                <i class="fas fa-exchange-alt"></i>
                <span>Base64 인코더/디코더</span>
            </a>
            <a href="/002-text-tools/hash-generator">
                <i class="fas fa-hashtag"></i>
                <span>Hash 생성기</span>
            </a>
            <a href="/002-text-tools/json-formatter">
                <i class="fas fa-code"></i>
                <span>JSON 포맷터/뷰어</span>
            </a>
            <a href="/002-text-tools/xml-validator">
                <i class="fas fa-file-code"></i>
                <span>XML 검증기</span>
            </a>          
        </div>
    </div>
    <div class="dropdown">
        <a href="#" class="menu-icon">
            <i class="fas fa-exchange-alt"></i>
        </a>
        <div class="dropdown-content">
            <a href="/004-converter/hex-image">
                <i class="fas fa-image"></i>
                <span>HEX 이미지 변환기</span>
            </a>
            <a href="/004-converter/curl">
                <i class="fas fa-terminal"></i>
                <span>CURL 변환기</span>
            </a>
            <a href="/004-converter/qr">
                <i class="fas fa-qrcode"></i>
                <span>QR 코드 생성기</span>
            </a>
            <a href="/004-converter/timestamp">
                <i class="fas fa-clock"></i>
                <span>타임스탬프 변환기</span>
            </a>
            <a href="/004-converter/markdown">
                <i class="fas fa-markdown"></i>
                <span>Markdown 변환기</span>
            </a>
            <a href="/004-converter/cron-examples">
                <i class="fas fa-clock"></i>
                <span>Cron 예제</span>
            </a>
            <a href="/004-converter/regex-examples">
                <i class="fas fa-slash"></i>
                <span>정규식 예제</span>
            </a>              
        </div>
    </div>
    <div class="dropdown">
        <a href="#" class="menu-icon">
            <i class="fas fa-shield-alt"></i>
        </a>
        <div class="dropdown-content">
            <a href="/007-security-tools/tls-check">
                <i class="fas fa-lock"></i>
                <span>TLS 버전 체크</span>
            </a>
            <a href="/007-security-tools/ip-info">
                <i class="fas fa-info-circle"></i>
                <span>IP 정보 확인</span>
            </a>
            <a href="/007-security-tools/cidr-calculator">
                <i class="fas fa-network-wired"></i>
                <span>CIDR 계산기</span>
            </a>
            <a href="/007-security-tools/firewall-check">
                <i class="fas fa-shield-virus"></i>
                <span>방화벽 체크</span>
            </a>
        </div>
    </div>
    <div class="dropdown">
        <a href="#" class="menu-icon">
            <i class="fas fa-paint-brush"></i>
        </a>
        <div class="dropdown-content">
            <a href="/005-design-tools/rgb-picker">
                <i class="fas fa-eye-dropper"></i>
                <span>RGB 코드 피커</span>
            </a>
            <a href="/005-design-tools/color-palette">
                <i class="fas fa-palette"></i>
                <span>색상 팔레트 생성기</span>
            </a>
        </div>
    </div>    
    <div class="dropdown">
        <a href="#" class="menu-icon">
            <i class="fas fa-ruler-combined"></i>
        </a>
        <div class="dropdown-content">
            <a href="/001-calculator">
                <i class="fas fa-calculator"></i>
                <span>공학용 계산기</span>
            </a>
            <a href="/008-unit-converter/length">
                <i class="fas fa-ruler"></i>
                <span>길이 변환</span>
            </a>
            <a href="/008-unit-converter/weight">
                <i class="fas fa-weight-hanging"></i>
                <span>무게 변환</span>
            </a>
            <a href="/008-unit-converter/temperature">
                <i class="fas fa-thermometer-half"></i>
                <span>온도 변환</span>
            </a>
            <a href="/008-unit-converter/area">
                <i class="fas fa-drafting-compass"></i>
                <span>면적 변환</span>
            </a>
        </div>
    </div>
    <div class="dropdown">
        <a href="#" class="menu-icon">
            <i class="fas fa-d"></i>
        </a>
        <div class="dropdown-content">
            <a href="https://www.kakao.com" target="_blank">
                <i class="fas fa-comment"></i>
                <span>카카오</span>
            </a>
            <a href="https://www.naver.com" target="_blank">
                <i class="fas fa-search"></i>
                <span>네이버</span>
            </a>
            <a href="https://www.google.com" target="_blank">
                <i class="fas fa-globe"></i>
                <span>구글</span>
            </a>
            <a href="/009-developer/facebook" target="_blank">
                <i class="fas fa-facebook"></i>
                <span>페이스북</span>
            </a>
        </div>
    </div>
</div>
<script>
    // 드롭다운 메뉴 클릭 이벤트 처리
    document.addEventListener('DOMContentLoaded', function() {
        const dropdowns = document.querySelectorAll('.dropdown');
        
        // 각 드롭다운에 클릭 이벤트 추가
        dropdowns.forEach(dropdown => {
            const link = dropdown.querySelector('a');
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // 다른 드롭다운 메뉴 닫기
                dropdowns.forEach(d => {
                    if (d !== dropdown) {
                        d.classList.remove('active');
                    }
                });
                
                // 현재 드롭다운 토글
                dropdown.classList.toggle('active');
            });
        });
        
        // 드롭다운 외부 클릭시 닫기
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });
    });
</script>