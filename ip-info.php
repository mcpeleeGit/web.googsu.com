<?php
require_once 'includes/functions.php';

$page_title = 'IP 정보 확인';
$current_page = 'ip-info';
$additional_css = ['css/ip-info.css'];
$additional_js = ['js/ip-info.js'];

include 'includes/header.php';
?>

        <main>
            <section class="tool-section">
                <h2>IP 정보 확인</h2>
                <div class="ip-info-container">
                    <div class="current-ip-section">
                        <h3>내 IP 정보</h3>
                        <div class="ip-info-card">
                            <div class="info-item">
                                <span class="label">IP 주소:</span>
                                <span id="ip-address" class="value">확인 중...</span>
                            </div>
                            <div class="info-item">
                                <span class="label">국가:</span>
                                <span id="country" class="value">확인 중...</span>
                            </div>
                            <div class="info-item">
                                <span class="label">도시:</span>
                                <span id="city" class="value">확인 중...</span>
                            </div>
                            <div class="info-item">
                                <span class="label">ISP:</span>
                                <span id="isp" class="value">확인 중...</span>
                            </div>
                        </div>
                    </div>

                    <div class="ip-lookup-section">
                        <h3>IP 주소 조회</h3>
                        <div class="form-group">
                            <label for="ip-input">IP 주소 입력:</label>
                            <div class="input-group">
                                <input type="text" id="ip-input" placeholder="IP 주소를 입력하세요">
                                <button id="lookup-btn">조회</button>
                            </div>
                        </div>
                        <div id="lookup-result" class="ip-info-card" style="display: none;">
                            <div class="info-item">
                                <span class="label">IP 주소:</span>
                                <span id="lookup-ip" class="value"></span>
                            </div>
                            <div class="info-item">
                                <span class="label">국가:</span>
                                <span id="lookup-country" class="value"></span>
                            </div>
                            <div class="info-item">
                                <span class="label">도시:</span>
                                <span id="lookup-city" class="value"></span>
                            </div>
                            <div class="info-item">
                                <span class="label">ISP:</span>
                                <span id="lookup-isp" class="value"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

<?php include 'includes/footer.php'; ?> 