<?php
$page_title = 'TLS 버전 체크';
$additional_css = ['/css/tls-checker.css'];
$additional_js = ['/js/tls-checker.js'];

require_once 'includes/header.php';
?>

<div class="container">
    <h1>TLS 버전 체크</h1>
    <p class="description">URL에서 지원하는 TLS 버전과 인증서 정보를 확인합니다.</p>

    <div class="tls-checker-form">
        <div class="input-group">
            <label for="url">URL 입력</label>
            <input type="url" id="url" name="url" placeholder="https://example.com" required>
        </div>
        <button type="button" id="check-tls" class="btn-primary">TLS 버전 및 인증서 확인</button>
    </div>

    <div class="result-container">
        <div id="loading" class="loading" style="display: none;">
            <div class="spinner"></div>
            <p>TLS 버전과 인증서를 확인하는 중...</p>
        </div>
        <div id="result" class="result">
            <div class="tls-section">
                <h2>TLS 버전 지원 현황</h2>
                <div class="tls-versions">
                    <div class="tls-version" id="tls1">
                        <span class="version">TLS 1.0</span>
                        <span class="status"></span>
                    </div>
                    <div class="tls-version" id="tls1-1">
                        <span class="version">TLS 1.1</span>
                        <span class="status"></span>
                    </div>
                    <div class="tls-version" id="tls1-2">
                        <span class="version">TLS 1.2</span>
                        <span class="status"></span>
                    </div>
                    <div class="tls-version" id="tls1-3">
                        <span class="version">TLS 1.3</span>
                        <span class="status"></span>
                    </div>
                </div>
            </div>

            <div class="cert-section">
                <h2>인증서 정보</h2>
                <div class="cert-info">
                    <div class="cert-item">
                        <span class="label">주체(Subject):</span>
                        <span class="value" id="cert-subject"></span>
                    </div>
                    <div class="cert-item">
                        <span class="label">발급자(Issuer):</span>
                        <span class="value" id="cert-issuer"></span>
                    </div>
                    <div class="cert-item">
                        <span class="label">유효 기간:</span>
                        <span class="value" id="cert-validity"></span>
                    </div>
                    <div class="cert-item">
                        <span class="label">시리얼 번호:</span>
                        <span class="value" id="cert-serial"></span>
                    </div>
                    <div class="cert-item">
                        <span class="label">버전:</span>
                        <span class="value" id="cert-version"></span>
                    </div>
                    <div class="cert-item">
                        <span class="label">서명 알고리즘:</span>
                        <span class="value" id="cert-algorithm"></span>
                    </div>
                </div>
            </div>
            <div id="error-message" class="error-message"></div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 