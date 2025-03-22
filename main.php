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

            <section class="search-section">
                <div class="search-container">
                    <input type="text" id="toolSearch" class="search-input" placeholder="도구 검색..." aria-label="도구 검색">
                    <button type="button" id="searchButton" class="search-button">
                        <span class="search-icon">🔍</span>
                    </button>
                </div>
            </section>

            <section class="popular-tools-section">
                <h2>인기 도구</h2>
                <div class="tools-grid">
                    <!-- URL 인코더/디코더 -->
                    <div class="tool-card popular" data-tool-id="url-encoder">
                        <div class="tool-icon">🔗</div>
                        <h3>URL 인코더/디코더</h3>
                        <p>URL 문자열을 인코딩하고 디코딩하는 도구입니다.</p>
                        <div class="tool-actions">
                            <a href="/url-encoder.php" class="tool-link">사용하기 →</a>
                            <button class="favorite-btn" data-tool-id="url-encoder">☆</button>
                        </div>
                        <span class="popular-badge">인기</span>
                    </div>

                    <!-- JSON 포맷터/뷰어 -->
                    <div class="tool-card popular" data-tool-id="json-formatter">
                        <div class="tool-icon">📋</div>
                        <h3>JSON 포맷터/뷰어</h3>
                        <p>JSON 데이터를 보기 좋게 포맷팅하고 검증하는 도구입니다.</p>
                        <div class="tool-actions">
                            <a href="/json-formatter.php" class="tool-link">사용하기 →</a>
                            <button class="favorite-btn" data-tool-id="json-formatter">☆</button>
                        </div>
                        <span class="popular-badge">인기</span>
                    </div>

                    <!-- Base64 인코더/디코더 -->
                    <div class="tool-card popular" data-tool-id="base64-converter">
                        <div class="tool-icon">🔒</div>
                        <h3>Base64 인코더/디코더</h3>
                        <p>텍스트를 Base64로 인코딩하거나 Base64를 디코딩하여 원래 텍스트로 변환할 수 있습니다.</p>
                        <div class="tool-actions">
                            <a href="/base64-converter.php" class="tool-link">사용하기 →</a>
                            <button class="favorite-btn" data-tool-id="base64-converter">☆</button>
                        </div>
                        <span class="popular-badge">인기</span>
                    </div>

                    <!-- 타임스탬프 변환기 -->
                    <div class="tool-card popular" data-tool-id="timestamp-converter">
                        <div class="tool-icon">⏰</div>
                        <h3>타임스탬프 변환기</h3>
                        <p>Unix 타임스탬프와 날짜 형식을 서로 변환할 수 있습니다.</p>
                        <div class="tool-actions">
                            <a href="/timestamp-converter.php" class="tool-link">사용하기 →</a>
                            <button class="favorite-btn" data-tool-id="timestamp-converter">☆</button>
                        </div>
                        <span class="popular-badge">인기</span>
                    </div>
                </div>
            </section>

            <section id="favorites-section" class="favorites-section">
                <h2>즐겨찾기한 도구</h2>
                <div class="tools-grid">
                    <!-- 즐겨찾기된 도구들이 여기에 표시됩니다 -->
                </div>
            </section>

            <section class="tools-grid">
                <!-- 개발 유틸리티 -->
                <div class="tool-card" data-tool-id="json-formatter">
                    <div class="tool-icon">📋</div>
                    <h3>JSON 포맷터/뷰어</h3>
                    <p>JSON 데이터를 보기 좋게 포맷팅하고 검증하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/json-formatter.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="json-formatter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="xml-validator">
                    <div class="tool-icon">📝</div>
                    <h3>XML 검증기</h3>
                    <p>XML 문서의 유효성을 검사하고 포맷팅하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/xml-validator.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="xml-validator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="hex-image">
                    <div class="tool-icon">🖼️</div>
                    <h3>HEX 이미지 변환기</h3>
                    <p>16진수 문자열을 이미지로 변환하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/hex-image.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="hex-image">☆</button>
                    </div>
                </div>

                <!-- 계산/변환 도구 -->
                <div class="tool-card" data-tool-id="calculator">
                    <div class="tool-icon">🔢</div>
                    <h3>공학용 계산기</h3>
                    <p>복잡한 수학 계산을 쉽고 빠르게 수행할 수 있는 공학용 계산기입니다.</p>
                    <div class="tool-actions">
                        <a href="/calculator.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="calculator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="curl-converter">
                    <div class="tool-icon">🔄</div>
                    <h3>CURL 변환기</h3>
                    <p>CURL 명령어를 다양한 프로그래밍 언어로 변환하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/curl-converter.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="curl-converter">☆</button>
                    </div>
                </div>

                <!-- 인코딩/디코딩 도구 -->
                <div class="tool-card" data-tool-id="url-encoder">
                    <div class="tool-icon">🔗</div>
                    <h3>URL 인코더/디코더</h3>
                    <p>URL 문자열을 인코딩하고 디코딩하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/url-encoder.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="url-encoder">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="base64-converter">
                    <div class="tool-icon">🔒</div>
                    <h3>Base64 인코더/디코더</h3>
                    <p>텍스트를 Base64로 인코딩하거나 Base64를 디코딩하여 원래 텍스트로 변환할 수 있습니다.</p>
                    <div class="tool-actions">
                        <a href="/base64-converter.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="base64-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="hash-generator">
                    <div class="tool-icon">🔑</div>
                    <h3>Hash 생성기</h3>
                    <p>텍스트를 MD5, SHA256 등 다양한 해시 알고리즘으로 변환할 수 있습니다.</p>
                    <div class="tool-actions">
                        <a href="/hash-generator.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="hash-generator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="jwt-decoder">
                    <div class="tool-icon">🔑</div>
                    <h3>JWT 디코더</h3>
                    <p>JWT 토큰을 디코딩하고 검증하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/jwt-decoder.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="jwt-decoder">☆</button>
                    </div>
                </div>

                <!-- 텍스트 도구 -->
                <div class="tool-card" data-tool-id="text-compare">
                    <div class="tool-icon">📊</div>
                    <h3>텍스트 비교</h3>
                    <p>두 텍스트의 차이점을 비교하고 분석하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/text-compare.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="text-compare">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="char-counter">
                    <div class="tool-icon">📋</div>
                    <h3>문자 수 세기</h3>
                    <p>텍스트의 문자 수, 단어 수, 줄 수를 세는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/char-counter.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="char-counter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="html-entities">
                    <div class="tool-icon">🔍</div>
                    <h3>HTML 특수문자 변환기</h3>
                    <p>HTML 특수문자와 일반 텍스트를 서로 변환할 수 있습니다.</p>
                    <div class="tool-actions">
                        <a href="/html-entities.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="html-entities">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="markdown-converter">
                    <div class="tool-icon">📝</div>
                    <h3>Markdown 뷰어/변환기</h3>
                    <p>Markdown 텍스트를 HTML로 변환하고 미리보기를 확인할 수 있습니다.</p>
                    <div class="tool-actions">
                        <a href="/markdown-converter.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="markdown-converter">☆</button>
                    </div>
                </div>

                <!-- 개발 유틸리티 -->
                <div class="tool-card" data-tool-id="qr-generator">
                    <div class="tool-icon">📱</div>
                    <h3>QR 코드 생성기</h3>
                    <p>텍스트, URL, 전화번호 등을 QR 코드로 생성할 수 있습니다.</p>
                    <div class="tool-actions">
                        <a href="/qr-generator.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="qr-generator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="timestamp-converter">
                    <div class="tool-icon">⏰</div>
                    <h3>타임스탬프 변환기</h3>
                    <p>Unix 타임스탬프와 날짜 형식을 서로 변환할 수 있습니다.</p>
                    <div class="tool-actions">
                        <a href="/timestamp-converter.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="timestamp-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="cron-examples">
                    <div class="tool-icon">⏰</div>
                    <h3>Cron 예제</h3>
                    <p>Cron 표현식의 예제와 입력한 값의 의미를 확인할 수 있는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/cron-examples.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="cron-examples">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="regex-examples">
                    <div class="tool-icon">🔍</div>
                    <h3>정규식 예제</h3>
                    <p>정규식 패턴의 예제와 입력한 값의 의미를 확인할 수 있는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/regex-examples.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="regex-examples">☆</button>
                    </div>
                </div>

                <!-- 단위 환산 도구 -->
                <div class="tool-card" data-tool-id="length-converter">
                    <div class="tool-icon">📏</div>
                    <h3>길이 변환</h3>
                    <p>밀리미터, 센티미터, 미터, 킬로미터, 인치, 피트 등 다양한 길이 단위를 변환합니다.</p>
                    <div class="tool-actions">
                        <a href="/unit/length.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="length-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="weight-converter">
                    <div class="tool-icon">⚖️</div>
                    <h3>무게 변환</h3>
                    <p>밀리그램, 그램, 킬로그램, 톤, 온스, 파운드 등 다양한 무게 단위를 변환합니다.</p>
                    <div class="tool-actions">
                        <a href="/unit/weight.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="weight-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="temperature-converter">
                    <div class="tool-icon">🌡️</div>
                    <h3>온도 변환</h3>
                    <p>섭씨, 화씨, 켈빈 등 다양한 온도 단위를 변환합니다.</p>
                    <div class="tool-actions">
                        <a href="/unit/temperature.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="temperature-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="area-converter">
                    <div class="tool-icon">📐</div>
                    <h3>면적 변환</h3>
                    <p>제곱미터, 평, 에이커, 헥타르 등 다양한 면적 단위를 변환합니다.</p>
                    <div class="tool-actions">
                        <a href="/unit/area.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="area-converter">☆</button>
                    </div>
                </div>

                <!-- 디자인 도구 -->
                <div class="tool-card" data-tool-id="rgb-picker">
                    <div class="tool-icon">🎨</div>
                    <h3>RGB 코드 피커</h3>
                    <p>색상을 선택하고 RGB, HEX, HSL 등 다양한 형식의 색상 코드를 확인할 수 있습니다.</p>
                    <div class="tool-actions">
                        <a href="/design/rgb-picker.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="rgb-picker">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="color-palette">
                    <div class="tool-icon">🎨</div>
                    <h3>웹 색상 팔레트 추천기</h3>
                    <p>기본 색상을 선택하여 조화로운 색상 팔레트를 생성할 수 있습니다.</p>
                    <div class="tool-actions">
                        <a href="/design/color-palette.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="color-palette">☆</button>
                    </div>
                </div>

                <!-- 보안 도구 -->
                <div class="tool-card" data-tool-id="tls-checker">
                    <div class="tool-icon">🔒</div>
                    <h3>TLS 버전 체크</h3>
                    <p>웹사이트의 TLS 버전과 보안 설정을 확인하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/tls-checker.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="tls-checker">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="ip-info">
                    <div class="tool-icon">🌐</div>
                    <h3>IP 정보 확인</h3>
                    <p>IP 주소와 위치 정보를 확인하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/ip-info.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="ip-info">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="cidr-calculator">
                    <div class="tool-icon">🔍</div>
                    <h3>IP 주소 대역 계산기</h3>
                    <p>IP 주소와 CIDR 표기법을 사용하여 네트워크 주소, 브로드캐스트 주소, 사용 가능한 IP 범위를 계산합니다.</p>
                    <div class="tool-actions">
                        <a href="/cidr-calculator.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="cidr-calculator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="firewall-check">
                    <div class="tool-icon">🛡️</div>
                    <h3>방화벽 체크</h3>
                    <p>웹사이트의 방화벽 설정을 확인하고 분석하는 도구입니다.</p>
                    <div class="tool-actions">
                        <a href="/firewall-check.php" class="tool-link">사용하기 →</a>
                        <button class="favorite-btn" data-tool-id="firewall-check">☆</button>
                    </div>
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
    <script src="/js/main.js" defer></script>
    <script src="/js/favorites.js" defer></script>
    <script src="/js/search.js" defer></script>
    <?php if (isset($additional_js)): ?>

    <?php endif; ?> 