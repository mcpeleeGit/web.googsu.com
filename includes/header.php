<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/language.php';
$page_title = $page_title ?? '유틸리티 모음';
$additional_css = $additional_css ?? [];
$additional_js = $additional_js ?? [];
$current_lang = $current_lang ?? 'ko';
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0QSQ2VE1QR"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-0QSQ2VE1QR');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PXJ4JK7W');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" type="image/png" href="/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <?php foreach ($additional_css as $css): ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($css); ?>">
    <?php endforeach; ?>
    <script src="/js/main.js" defer></script>
    <?php if (isset($additional_js)): ?>
        <?php foreach ($additional_js as $js): ?>
            <script src="<?php echo h($js); ?>" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PXJ4JK7W"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header>
        <div class="header-right">

            <nav>
                <ul class="nav-links">
                    <li><a href="/main.php"><?php echo __('menu.home'); ?></a></li>
                    <li><a href="/calculator.php"><?php echo __('menu.calculator'); ?></a></li>
                    <li class="has-submenu">
                        <a href="#"><?php echo __('menu.encoder_decoder'); ?></a>
                        <ul class="submenu">
                            <li><a href="/url-encoder.php"><?php echo __('menu.url_encoder'); ?></a></li>
                            <li><a href="/jwt-decoder.php"><?php echo __('menu.jwt_decoder'); ?></a></li>
                            <li><a href="/base64-converter.php"><?php echo __('menu.base64_converter'); ?></a></li>
                            <li><a href="/hash-generator.php"><?php echo __('menu.hash_generator'); ?></a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><?php echo __('menu.converters'); ?></a>
                        <ul class="submenu">
                            <li><a href="/hex-image.php"><?php echo __('menu.hex_image'); ?></a></li>
                            <li><a href="/curl-converter.php"><?php echo __('menu.curl_converter'); ?></a></li>
                            <li><a href="/qr-generator.php"><?php echo __('menu.qr_generator'); ?></a></li>
                            <li><a href="/timestamp-converter.php"><?php echo __('menu.timestamp_converter'); ?></a></li>
                            <li><a href="/markdown-converter.php"><?php echo __('menu.markdown_converter'); ?></a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><?php echo __('menu.unit_converter'); ?></a>
                        <ul class="submenu">
                            <li><a href="/unit/length.php"><?php echo __('menu.length'); ?></a></li>
                            <li><a href="/unit/weight.php"><?php echo __('menu.weight'); ?></a></li>
                            <li><a href="/unit/temperature.php"><?php echo __('menu.temperature'); ?></a></li>
                            <li><a href="/unit/area.php"><?php echo __('menu.area'); ?></a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><?php echo __('menu.security_tools'); ?></a>
                        <ul class="submenu">
                            <li><a href="/tls-checker.php"><?php echo __('menu.tls_checker'); ?></a></li>
                            <li><a href="/ip-info.php"><?php echo __('menu.ip_info'); ?></a></li>
                            <li><a href="/cidr-calculator.php"><?php echo __('menu.cidr_calculator'); ?></a></li>
                            <li><a href="/firewall-check.php"><?php echo __('menu.firewall_check'); ?></a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><?php echo __('menu.dev_tools'); ?></a>
                        <ul class="submenu">
                            <li><a href="/json-formatter.php"><?php echo __('menu.json_formatter'); ?></a></li>
                            <li><a href="/xml-validator.php"><?php echo __('menu.xml_validator'); ?></a></li>
                            <li><a href="/qr-generator.php"><?php echo __('menu.qr_generator'); ?></a></li>
                            <li><a href="/cron-examples.php"><?php echo __('menu.cron_examples'); ?></a></li>
                            <li><a href="/regex-examples.php"><?php echo __('menu.regex_examples'); ?></a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><?php echo __('menu.design_tools'); ?></a>
                        <ul class="submenu">
                            <li><a href="/design/rgb-picker.php"><?php echo __('menu.rgb_picker'); ?></a></li>
                            <li><a href="/design/color-palette.php"><?php echo __('menu.color_palette'); ?></a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><?php echo __('menu.text_tools'); ?></a>
                        <ul class="submenu">
                            <li><a href="/text-compare.php"><?php echo __('menu.text_compare'); ?></a></li>
                            <li><a href="/char-counter.php"><?php echo __('menu.char_counter'); ?></a></li>
                            <li><a href="/html-entities.php"><?php echo __('menu.html_entities'); ?></a></li>
                            <li><a href="/markdown-converter.php"><?php echo __('menu.markdown_converter'); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="lang-toggle">
                <a href="?lang=ko" class="lang-btn <?php echo $current_lang === 'ko' ? 'active' : ''; ?>" title="한국어">
                    <span class="flag-icon">🇰🇷</span>
                </a>
                <a href="?lang=en" class="lang-btn <?php echo $current_lang === 'en' ? 'active' : ''; ?>" title="English">
                    <span class="flag-icon">🇺🇸</span>
                </a>
            </div>
        </div>
    </header>
</body>
</html> 