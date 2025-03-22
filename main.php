<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/language.php';

$current_lang = getCurrentLang();
$current_page = 'main';

$page_title = __('hero.title');

include 'includes/header.php';
?>

        <main>
            <section class="hero-section">
                <h2><?php echo __('hero.title'); ?></h2>
                <p><?php echo __('hero.description'); ?></p>
            </section>

            <section class="search-section">
                <div class="search-container">
                    <input type="text" id="toolSearch" class="search-input" placeholder="<?php echo __('search.placeholder'); ?>" aria-label="<?php echo __('search.label'); ?>">
                    <button type="button" id="searchButton" class="search-button">
                        <span class="search-icon">🔍</span>
                    </button>
                </div>
            </section>

            <section class="popular-tools-section">
                <h2><?php echo __('sections.popular_tools'); ?></h2>
                <div class="tools-grid">
                    <!-- URL 인코더/디코더 -->
                    <div class="tool-card popular" data-tool-id="url-encoder">
                        <div class="tool-icon">🔗</div>
                        <h3><?php echo __('tools.url_encoder.title'); ?></h3>
                        <p><?php echo __('tools.url_encoder.description'); ?></p>
                        <div class="tool-actions">
                            <a href="/url-encoder.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                            <button class="favorite-btn" data-tool-id="url-encoder">☆</button>
                        </div>
                        <span class="popular-badge"><?php echo __('common.popular'); ?></span>
                    </div>

                    <!-- JSON 포맷터/뷰어 -->
                    <div class="tool-card popular" data-tool-id="json-formatter">
                        <div class="tool-icon">📋</div>
                        <h3><?php echo __('tools.json_formatter.title'); ?></h3>
                        <p><?php echo __('tools.json_formatter.description'); ?></p>
                        <div class="tool-actions">
                            <a href="/json-formatter.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                            <button class="favorite-btn" data-tool-id="json-formatter">☆</button>
                        </div>
                        <span class="popular-badge"><?php echo __('common.popular'); ?></span>
                    </div>

                    <!-- Base64 인코더/디코더 -->
                    <div class="tool-card popular" data-tool-id="base64-converter">
                        <div class="tool-icon">🔒</div>
                        <h3><?php echo __('tools.base64.title'); ?></h3>
                        <p><?php echo __('tools.base64.description'); ?></p>
                        <div class="tool-actions">
                            <a href="/base64-converter.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                            <button class="favorite-btn" data-tool-id="base64-converter">☆</button>
                        </div>
                        <span class="popular-badge"><?php echo __('common.popular'); ?></span>
                    </div>

                    <!-- 타임스탬프 변환기 -->
                    <div class="tool-card popular" data-tool-id="timestamp-converter">
                        <div class="tool-icon">⏰</div>
                        <h3><?php echo __('tools.timestamp.title'); ?></h3>
                        <p><?php echo __('tools.timestamp.description'); ?></p>
                        <div class="tool-actions">
                            <a href="/timestamp-converter.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                            <button class="favorite-btn" data-tool-id="timestamp-converter">☆</button>
                        </div>
                        <span class="popular-badge"><?php echo __('common.popular'); ?></span>
                    </div>
                </div>
            </section>

            <section id="favorites-section" class="favorites-section">
                <h2><?php echo __('sections.favorites'); ?></h2>
                <div class="tools-grid">
                    <!-- 즐겨찾기된 도구들이 여기에 표시됩니다 -->
                </div>
            </section>

            <section class="tools-grid">
                <!-- 개발 유틸리티 -->
                <div class="tool-card" data-tool-id="json-formatter">
                    <div class="tool-icon">📋</div>
                    <h3><?php echo __('tools.json_formatter.title'); ?></h3>
                    <p><?php echo __('tools.json_formatter.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/json-formatter.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="json-formatter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="xml-validator">
                    <div class="tool-icon">📝</div>
                    <h3><?php echo __('tools.xml_validator.title'); ?></h3>
                    <p><?php echo __('tools.xml_validator.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/xml-validator.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="xml-validator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="hex-image">
                    <div class="tool-icon">🖼️</div>
                    <h3><?php echo __('tools.hex_image.title'); ?></h3>
                    <p><?php echo __('tools.hex_image.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/hex-image.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="hex-image">☆</button>
                    </div>
                </div>

                <!-- 계산/변환 도구 -->
                <div class="tool-card" data-tool-id="calculator">
                    <div class="tool-icon">🔢</div>
                    <h3><?php echo __('tools.calculator.title'); ?></h3>
                    <p><?php echo __('tools.calculator.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/calculator.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="calculator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="curl-converter">
                    <div class="tool-icon">🔄</div>
                    <h3><?php echo __('tools.curl_converter.title'); ?></h3>
                    <p><?php echo __('tools.curl_converter.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/curl-converter.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="curl-converter">☆</button>
                    </div>
                </div>

                <!-- 인코딩/디코딩 도구 -->
                <div class="tool-card" data-tool-id="url-encoder">
                    <div class="tool-icon">🔗</div>
                    <h3><?php echo __('tools.url_encoder.title'); ?></h3>
                    <p><?php echo __('tools.url_encoder.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/url-encoder.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="url-encoder">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="base64-converter">
                    <div class="tool-icon">🔒</div>
                    <h3><?php echo __('tools.base64.title'); ?></h3>
                    <p><?php echo __('tools.base64.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/base64-converter.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="base64-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="hash-generator">
                    <div class="tool-icon">🔑</div>
                    <h3><?php echo __('tools.hash_generator.title'); ?></h3>
                    <p><?php echo __('tools.hash_generator.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/hash-generator.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="hash-generator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="jwt-decoder">
                    <div class="tool-icon">🔑</div>
                    <h3><?php echo __('tools.jwt_decoder.title'); ?></h3>
                    <p><?php echo __('tools.jwt_decoder.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/jwt-decoder.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="jwt-decoder">☆</button>
                    </div>
                </div>

                <!-- 텍스트 도구 -->
                <div class="tool-card" data-tool-id="text-compare">
                    <div class="tool-icon">📊</div>
                    <h3><?php echo __('tools.text_compare.title'); ?></h3>
                    <p><?php echo __('tools.text_compare.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/text-compare.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="text-compare">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="char-counter">
                    <div class="tool-icon">📋</div>
                    <h3><?php echo __('tools.char_counter.title'); ?></h3>
                    <p><?php echo __('tools.char_counter.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/char-counter.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="char-counter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="html-entities">
                    <div class="tool-icon">🔍</div>
                    <h3><?php echo __('tools.html_entities.title'); ?></h3>
                    <p><?php echo __('tools.html_entities.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/html-entities.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="html-entities">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="markdown-converter">
                    <div class="tool-icon">📝</div>
                    <h3><?php echo __('tools.markdown.title'); ?></h3>
                    <p><?php echo __('tools.markdown.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/markdown-converter.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="markdown-converter">☆</button>
                    </div>
                </div>

                <!-- 개발 유틸리티 -->
                <div class="tool-card" data-tool-id="qr-generator">
                    <div class="tool-icon">📱</div>
                    <h3><?php echo __('tools.qr_generator.title'); ?></h3>
                    <p><?php echo __('tools.qr_generator.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/qr-generator.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="qr-generator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="timestamp-converter">
                    <div class="tool-icon">⏰</div>
                    <h3><?php echo __('tools.timestamp.title'); ?></h3>
                    <p><?php echo __('tools.timestamp.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/timestamp-converter.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="timestamp-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="cron-examples">
                    <div class="tool-icon">⏰</div>
                    <h3><?php echo __('tools.cron.title'); ?></h3>
                    <p><?php echo __('tools.cron.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/cron-examples.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="cron-examples">☆</button>
                    </div>
                </div>

                <!-- 정규식 예제 -->
                <div class="tool-card" data-tool-id="regex-examples">
                    <div class="tool-icon">🔍</div>
                    <h3><?php echo __('tools.regex.title'); ?></h3>
                    <p><?php echo __('tools.regex.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/regex-examples.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="regex-examples">☆</button>
                    </div>
                </div>

                <!-- 단위 환산 도구 -->
                <div class="tool-card" data-tool-id="length-converter">
                    <div class="tool-icon">📏</div>
                    <h3><?php echo __('tools.length.title'); ?></h3>
                    <p><?php echo __('tools.length.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/unit/length.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="length-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="weight-converter">
                    <div class="tool-icon">⚖️</div>
                    <h3><?php echo __('tools.weight.title'); ?></h3>
                    <p><?php echo __('tools.weight.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/unit/weight.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="weight-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="temperature-converter">
                    <div class="tool-icon">🌡️</div>
                    <h3><?php echo __('tools.temperature.title'); ?></h3>
                    <p><?php echo __('tools.temperature.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/unit/temperature.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="temperature-converter">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="area-converter">
                    <div class="tool-icon">📐</div>
                    <h3><?php echo __('tools.area.title'); ?></h3>
                    <p><?php echo __('tools.area.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/unit/area.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="area-converter">☆</button>
                    </div>
                </div>

                <!-- 디자인 도구 -->
                <div class="tool-card" data-tool-id="rgb-picker">
                    <div class="tool-icon">🎨</div>
                    <h3><?php echo __('tools.rgb_picker.title'); ?></h3>
                    <p><?php echo __('tools.rgb_picker.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/design/rgb-picker.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="rgb-picker">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="color-palette">
                    <div class="tool-icon">🎨</div>
                    <h3><?php echo __('tools.color_palette.title'); ?></h3>
                    <p><?php echo __('tools.color_palette.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/design/color-palette.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="color-palette">☆</button>
                    </div>
                </div>

                <!-- 보안 도구 -->
                <div class="tool-card" data-tool-id="tls-checker">
                    <div class="tool-icon">🔒</div>
                    <h3><?php echo __('tools.tls_checker.title'); ?></h3>
                    <p><?php echo __('tools.tls_checker.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/tls-checker.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="tls-checker">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="ip-info">
                    <div class="tool-icon">🌐</div>
                    <h3><?php echo __('tools.ip_info.title'); ?></h3>
                    <p><?php echo __('tools.ip_info.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/ip-info.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="ip-info">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="cidr-calculator">
                    <div class="tool-icon">🔍</div>
                    <h3><?php echo __('tools.cidr.title'); ?></h3>
                    <p><?php echo __('tools.cidr.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/cidr-calculator.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="cidr-calculator">☆</button>
                    </div>
                </div>

                <div class="tool-card" data-tool-id="firewall-check">
                    <div class="tool-icon">🛡️</div>
                    <h3><?php echo __('tools.firewall.title'); ?></h3>
                    <p><?php echo __('tools.firewall.description'); ?></p>
                    <div class="tool-actions">
                        <a href="/firewall-check.php" class="tool-link"><?php echo __('common.use_tool'); ?> →</a>
                        <button class="favorite-btn" data-tool-id="firewall-check">☆</button>
                    </div>
                </div>
            </section>

            <section class="features-section">
                <h2><?php echo __('sections.key_features'); ?></h2>
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">⚡</div>
                        <h3><?php echo __('features.fast_processing.title'); ?></h3>
                        <p><?php echo __('features.fast_processing.description'); ?></p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🛡️</div>
                        <h3><?php echo __('features.secure_processing.title'); ?></h3>
                        <p><?php echo __('features.secure_processing.description'); ?></p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📱</div>
                        <h3><?php echo __('features.responsive_design.title'); ?></h3>
                        <p><?php echo __('features.responsive_design.description'); ?></p>
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