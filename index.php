<?php
require(__DIR__ . '/api/common/route.php');
Route::init($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include 'common/head.php'; ?>
    <title>Googsu Tools - 다양한 온라인 도구 모음</title>
    <meta name="description" content="Googsu에서 제공하는 다양한 온라인 도구 모음. 계산기, 텍스트 도구, 인코더/디코더, 변환기 등 다양한 기능을 제공합니다.">
    <meta property="og:title" content="Googsu Tools - 다양한 온라인 도구 모음">
    <meta property="og:description" content="Googsu에서 제공하는 다양한 온라인 도구 모음. 계산기, 텍스트 도구, 인코더/디코더, 변환기 등 다양한 기능을 제공합니다.">
    <meta property="og:url" content="https://googsu.com">
    <meta property="og:image" content="https://googsu.com/images/tools-og-image.png">
    <style>
        .menu-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .menu-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 15px;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-color: #adb5bd;
        }

        .menu-card .icon {
            font-size: 2em;
            color: #1971c2;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e7f5ff;
            border-radius: 10px;
        }

        .menu-card .text {
            flex: 1;
        }

        .menu-card h3 {
            margin: 0 0 8px 0;
            color: #1971c2;
            font-size: 1.1em;
        }

        .menu-card p {
            margin: 0;
            color: #666;
            font-size: 0.85em;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* 반응형 디자인 */
        @media (max-width: 1200px) {
            .menu-cards {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .menu-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .menu-cards {
                grid-template-columns: 1fr;
            }
        }

        .base64-encoder-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            padding: 20px;
        }

        .input-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .input-group label {
            font-weight: bold;
            color: #495057;
        }

        textarea {
            width: 100%;
            height: 120px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            resize: vertical;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .action-button {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .encode-button {
            background-color: #1971c2;
            color: white;
        }

        .encode-button:hover {
            background-color: #1864ab;
        }

        .decode-button {
            background-color: #e9ecef;
            color: #495057;
        }

        .decode-button:hover {
            background-color: #dee2e6;
        }

        .result-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .result-title {
            font-size: 1.1em;
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .result-box {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .result-box:last-child {
            margin-bottom: 0;
        }

        .part-header {
            font-size: 0.9em;
            color: #1971c2;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .part-content {
            font-family: monospace;
            font-size: 0.9em;
            color: #495057;
            white-space: pre-wrap;
            word-break: break-all;
        }

        .error-message {
            color: #e03131;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'common/menu.php'; ?>
        <div class="content-area">
            <div class="menu-cards">
                <a href="/002-text-tools/compare" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-code-compare"></i>
                    </div>
                    <div class="text">
                        <h3>텍스트 비교</h3>
                        <p>두 텍스트의 차이점을 비교하고 분석할 수 있는 도구입니다.</p>
                    </div>
                </a>
                <a href="/002-text-tools/counter" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="text">
                        <h3>문자수 세기</h3>
                        <p>텍스트의 글자 수, 단어 수, 줄 수를 계산하는 도구입니다.</p>
                    </div>
                </a>
                <a href="/002-text-tools/url" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <div class="text">
                        <h3>URL 인코더/디코더</h3>
                        <p>URL 문자열을 인코딩하거나 디코딩하는 도구입니다.</p>
                    </div>
                </a>
                <a href="/002-text-tools/jwt" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="text">
                        <h3>JWT 디코더</h3>
                        <p>JWT 토큰을 디코딩하여 헤더, 페이로드, 서명을 확인할 수 있습니다.</p>
                    </div>
                </a>
                <a href="/002-text-tools/base64" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="text">
                        <h3>Base64 인코더/디코더</h3>
                        <p>텍스트를 Base64로 인코딩하거나 디코딩하는 도구입니다.</p>
                    </div>
                </a>
                <a href="/002-text-tools/hash-generator" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <div class="text">
                        <h3>Hash 생성기</h3>
                        <p>다양한 해시 알고리즘을 사용하여 문자열의 해시를 생성합니다.</p>
                    </div>
                </a>
                <a href="/002-text-tools/json-formatter" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="text">
                        <h3>JSON 포맷터/뷰어</h3>
                        <p>JSON 데이터를 포맷하고 쉽게 읽을 수 있도록 도와주는 도구입니다.</p>
                    </div>
                </a>
                <a href="/002-text-tools/xml-validator" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-file-code"></i>
                    </div>
                    <div class="text">
                        <h3>XML 검증기</h3>
                        <p>XML 데이터를 검증하고 구조를 확인할 수 있는 도구입니다.</p>
                    </div>
                </a>
                <a href="/004-converter/hex-image" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="text">
                        <h3>HEX 이미지 변환기</h3>
                        <p>HEX 문자열을 이미지로 변환하거나 이미지를 HEX로 변환합니다.</p>
                    </div>
                </a>
                <a href="/004-converter/curl" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-terminal"></i>
                    </div>
                    <div class="text">
                        <h3>CURL 변환기</h3>
                        <p>CURL 명령어를 다양한 프로그래밍 언어 코드로 변환합니다.</p>
                    </div>
                </a>
                <a href="/004-converter/qr" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="text">
                        <h3>QR 코드 생성기</h3>
                        <p>텍스트나 URL을 QR 코드로 변환하여 생성합니다.</p>
                    </div>
                </a>
                <a href="/004-converter/timestamp" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="text">
                        <h3>타임스탬프 변환기</h3>
                        <p>Unix 타임스탬프와 일반 날짜 형식을 상호 변환합니다.</p>
                    </div>
                </a>
                <a href="/004-converter/markdown" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-markdown"></i>
                    </div>
                    <div class="text">
                        <h3>Markdown 변환기</h3>
                        <p>Markdown 문법을 HTML로 변환하거나 미리보기를 제공합니다.</p>
                    </div>
                </a>
                <a href="/004-converter/cron-examples" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="text">
                        <h3>Cron 예제</h3>
                        <p>Cron 작업을 설정하고 관리하는 예제를 제공합니다.</p>
                    </div>
                </a>
                <a href="/004-converter/regex-examples" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-slash"></i>
                    </div>
                    <div class="text">
                        <h3>정규식 예제</h3>
                        <p>정규 표현식을 작성하고 테스트할 수 있는 예제를 제공합니다.</p>
                    </div>
                </a>
                <a href="/007-security-tools/tls-check" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="text">
                        <h3>TLS 버전 체크</h3>
                        <p>웹사이트의 TLS 버전을 확인하고 보안 상태를 점검합니다.</p>
                    </div>
                </a>
                <a href="/007-security-tools/ip-info" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="text">
                        <h3>IP 정보 확인</h3>
                        <p>IP 주소의 위치 및 기타 정보를 확인할 수 있는 도구입니다.</p>
                    </div>
                </a>
                <a href="/007-security-tools/cidr-calculator" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <div class="text">
                        <h3>CIDR 계산기</h3>
                        <p>CIDR 표기법을 사용하여 네트워크 범위를 계산합니다.</p>
                    </div>
                </a>
                <a href="/007-security-tools/firewall-check" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-shield-virus"></i>
                    </div>
                    <div class="text">
                        <h3>방화벽 체크</h3>
                        <p>네트워크 방화벽 설정을 점검하고 보안 상태를 확인합니다.</p>
                    </div>
                </a>
                <a href="/007-security-tools/dns-lookup" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="text">
                        <h3>DNS Lookup</h3>
                        <p>도메인의 DNS 정보를 조회하여 IP 주소, MX 레코드, NS 레코드 등을 확인합니다.</p>
                    </div>
                </a>
                <a href="/005-design-tools/rgb-picker" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-eye-dropper"></i>
                    </div>
                    <div class="text">
                        <h3>RGB 코드 피커</h3>
                        <p>RGB 색상 코드를 선택하고 미리볼 수 있는 도구입니다.</p>
                    </div>
                </a>
                <a href="/005-design-tools/color-palette" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="text">
                        <h3>색상 팔레트 생성기</h3>
                        <p>다양한 색상 팔레트를 생성하고 관리할 수 있는 도구입니다.</p>
                    </div>
                </a>
                <a href="/001-calculator" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="text">
                        <h3>공학용 계산기</h3>
                        <p>삼각함수, 지수, 로그 등 다양한 수학 계산을 할 수 있는 공학용 계산기입니다.</p>
                    </div>
                </a>
                <a href="/008-unit-converter/length" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-ruler"></i>
                    </div>
                    <div class="text">
                        <h3>길이 변환</h3>
                        <p>다양한 단위의 길이를 상호 변환할 수 있는 도구입니다.</p>
                    </div>
                </a>
                <a href="/008-unit-converter/weight" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-weight-hanging"></i>
                    </div>
                    <div class="text">
                        <h3>무게 변환</h3>
                        <p>다양한 단위의 무게를 상호 변환할 수 있는 도구입니다.</p>
                    </div>
                </a>
                <a href="/008-unit-converter/temperature" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-thermometer-half"></i>
                    </div>
                    <div class="text">
                        <h3>온도 변환</h3>
                        <p>섭씨, 화씨, 켈빈 등 다양한 온도 단위를 변환합니다.</p>
                    </div>
                </a>
                <a href="/008-unit-converter/area" class="menu-card">
                    <div class="icon">
                        <i class="fas fa-drafting-compass"></i>
                    </div>
                    <div class="text">
                        <h3>면적 변환</h3>
                        <p>다양한 단위의 면적을 상호 변환할 수 있는 도구입니다.</p>
                    </div>
                </a>
            </div>
        </div>
        <?php include 'common/footer.php'; ?>
    </div>

</body>
</html> 