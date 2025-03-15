<?php
require_once 'includes/functions.php';

$page_title = '유틸리티 모음';
$current_page = 'home';

include 'includes/header.php';
?>

        <main>
            <section class="hero-section">
                <h2>웹 개발자를 위한 유용한 도구 모음</h2>
                <p>일상적인 개발 작업에 필요한 다양한 유틸리티를 한 곳에서 사용하세요.</p>
            </section>

            <section class="tools-grid">
                <div class="tool-card">
                    <div class="tool-icon">🔢</div>
                    <h3>공학용 계산기</h3>
                    <p>복잡한 수학 계산을 쉽고 빠르게 수행할 수 있는 공학용 계산기입니다.</p>
                    <a href="calculator.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">🔗</div>
                    <h3>URL 인코더/디코더</h3>
                    <p>URL 문자열을 인코딩하고 디코딩하는 도구입니다.</p>
                    <a href="url-encoder.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">🔑</div>
                    <h3>JWT 디코더</h3>
                    <p>JWT 토큰을 디코딩하고 검증하는 도구입니다.</p>
                    <a href="jwt-decoder.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">🖼️</div>
                    <h3>HEX 이미지 변환기</h3>
                    <p>16진수 문자열을 이미지로 변환하는 도구입니다.</p>
                    <a href="hex-image.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">🔄</div>
                    <h3>CURL 변환기</h3>
                    <p>CURL 명령어를 다양한 프로그래밍 언어로 변환하는 도구입니다.</p>
                    <a href="curl-converter.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">🔒</div>
                    <h3>TLS 버전 체크</h3>
                    <p>웹사이트의 TLS 버전과 보안 설정을 확인하는 도구입니다.</p>
                    <a href="tls-checker.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">🌐</div>
                    <h3>IP 정보 확인</h3>
                    <p>IP 주소와 위치 정보를 확인하는 도구입니다.</p>
                    <a href="ip-info.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">📝</div>
                    <h3>XML 검증기</h3>
                    <p>XML 문서의 유효성을 검사하고 포맷팅하는 도구입니다.</p>
                    <a href="xml-validator.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">📊</div>
                    <h3>텍스트 비교</h3>
                    <p>두 텍스트의 차이점을 비교하고 분석하는 도구입니다.</p>
                    <a href="text-compare.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">⏰</div>
                    <h3>Cron 예제</h3>
                    <p>Cron 표현식의 예제와 입력한 값의 의미를 확인할 수 있는 도구입니다.</p>
                    <a href="cron-examples.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">🔍</div>
                    <h3>정규식 예제</h3>
                    <p>정규식 패턴의 예제와 입력한 값의 의미를 확인할 수 있는 도구입니다.</p>
                    <a href="regex-examples.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">📏</div>
                    <h3>길이 변환</h3>
                    <p>밀리미터, 센티미터, 미터, 킬로미터, 인치, 피트 등 다양한 길이 단위를 변환합니다.</p>
                    <a href="unit/length.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">⚖️</div>
                    <h3>무게 변환</h3>
                    <p>밀리그램, 그램, 킬로그램, 톤, 온스, 파운드 등 다양한 무게 단위를 변환합니다.</p>
                    <a href="unit/weight.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">🌡️</div>
                    <h3>온도 변환</h3>
                    <p>섭씨, 화씨, 켈빈 등 다양한 온도 단위를 변환합니다.</p>
                    <a href="unit/temperature.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">📐</div>
                    <h3>면적 변환</h3>
                    <p>제곱미터, 평, 에이커, 헥타르 등 다양한 면적 단위를 변환합니다.</p>
                    <a href="unit/area.php" class="tool-link">사용하기 →</a>
                </div>

                <div class="tool-card">
                    <div class="tool-icon">🎨</div>
                    <h3>RGB 코드 피커</h3>
                    <p>색상을 선택하고 RGB, HEX, HSL 등 다양한 형식의 색상 코드를 확인할 수 있습니다.</p>
                    <a href="design/rgb-picker.php" class="tool-link">사용하기 →</a>
                </div>
            </section>

            <section class="features-section">
                <h2>주요 특징</h2>
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">⚡</div>
                        <h3>빠른 처리</h3>
                        <p>모든 도구는 최적화되어 있어 빠른 응답 시간을 제공합니다.</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🛡️</div>
                        <h3>안전한 처리</h3>
                        <p>모든 입력은 안전하게 처리되며, XSS 공격으로부터 보호됩니다.</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📱</div>
                        <h3>반응형 디자인</h3>
                        <p>모든 디바이스에서 최적화된 사용자 경험을 제공합니다.</p>
                    </div>
                </div>
            </section>
        </main>

<?php include 'includes/footer.php'; ?> 