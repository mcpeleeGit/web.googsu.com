<?php
require_once __DIR__ . '/functions.php';
$page_title = $page_title ?? '유틸리티 모음';
$additional_css = $additional_css ?? [];
$additional_js = $additional_js ?? [];
?>
<!DOCTYPE html>
<html lang="ko">
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
        <nav>
            <div class="hamburger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links">
                <li><a href="/main.php">홈</a></li>
                <li><a href="/calculator.php">공학용 계산기</a></li>
                <li class="has-submenu">
                    <a href="#">인코더/디코더</a>
                    <ul class="submenu">
                        <li><a href="/url-encoder.php">URL 인코더/디코더</a></li>
                        <li><a href="/jwt-decoder.php">JWT 디코더</a></li>
                        <li><a href="/base64-converter.php">Base64 인코더/디코더</a></li>
                        <li><a href="/hash-generator.php">Hash 생성기</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">변환기</a>
                    <ul class="submenu">
                        <li><a href="/hex-image.php">HEX 이미지 변환기</a></li>
                        <li><a href="/curl-converter.php">CURL 변환기</a></li>
                        <li><a href="/qr-generator.php">QR 코드 생성기</a></li>
                        <li><a href="/timestamp-converter.php">타임스탬프 변환기</a></li>
                        <li><a href="/markdown-converter.php">Markdown 뷰어/변환기</a></li>
                        
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">단위 환산</a>
                    <ul class="submenu">
                        <li><a href="/length.php">길이 변환</a></li>
                        <li><a href="/weight.php">무게 변환</a></li>
                        <li><a href="/temperature.php">온도 변환</a></li>
                        <li><a href="/area.php">면적 변환</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">보안 도구</a>
                    <ul class="submenu">
                        <li><a href="/tls-checker.php">TLS 버전 체크</a></li>
                        <li><a href="/ip-info.php">IP 정보 확인</a></li>
                        <li><a href="/cidr-calculator.php">IP 주소 대역 계산기</a></li>
                        <li><a href="/firewall-check.php">방화벽 체크</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">개발자 도구</a>
                    <ul class="submenu">
                        <li><a href="/json-formatter.php">JSON 포맷터/뷰어</a></li>
                        <li><a href="/xml-validator.php">XML 검증기</a></li>
                        <li><a href="/qr-generator.php">QR 코드 생성기</a></li>
                        <li><a href="/cron-examples.php">Cron 예제</a></li>
                        <li><a href="/regex-examples.php">정규식 예제</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">디자인 도구</a>
                    <ul class="submenu">
                        <li><a href="/rgb-picker.php">RGB 코드 피커</a></li>
                        <li><a href="/color-palette.php">웹 색상 팔레트 추천기</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">텍스트 도구</a>
                    <ul class="submenu">
                        <li><a href="/text-compare.php">텍스트 비교</a></li>
                        <li><a href="/char-counter.php">문자 수 세기</a></li>
                        <li><a href="/html-entities.php">HTML 특수문자 변환기</a></li>
                        <li><a href="/markdown-converter.php">Markdown 뷰어/변환기</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
</body>
</html> 