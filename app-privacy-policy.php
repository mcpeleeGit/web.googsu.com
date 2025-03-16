<?php
$page_title = '앱 개인정보 처리방침';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>앱 개인정보 처리방침</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <p class="last-updated">최종 수정일: 2024년 3월 15일</p>
                
                <section class="policy-section">
                    <h2>1. 개인정보 수집 및 이용 목적</h2>
                    <p>본 앱은 별도의 개인정보를 수집하거나 이용하지 않습니다. 앱의 기능은 모두 사용자의 기기 내에서 처리되며, 외부 서버와의 통신이나 데이터 저장을 하지 않습니다.</p>
                </section>

                <section class="policy-section">
                    <h2>2. 수집하는 개인정보 항목</h2>
                    <p>본 앱은 어떠한 개인정보도 수집하지 않습니다. 앱에서 생성되는 모든 데이터는 사용자의 기기 내에서만 처리되며, 외부로 전송되지 않습니다.</p>
                </section>

                <section class="policy-section">
                    <h2>3. 앱 권한 사용</h2>
                    <p>본 앱은 다음과 같은 기기 권한을 사용할 수 있습니다:</p>
                    <ul>
                        <li>인터넷 접근 권한: 앱 업데이트 확인을 위해서만 사용됩니다.</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>4. 개인정보 보호를 위한 기술적/관리적 조치</h2>
                    <p>본 앱은 개인정보를 수집하지 않지만, 사용자의 데이터 보호를 위해 다음과 같은 조치를 취하고 있습니다:</p>
                    <ul>
                        <li>모든 데이터 처리는 사용자의 기기 내에서만 이루어집니다.</li>
                        <li>외부 서버로의 데이터 전송이 없습니다.</li>
                        <li>앱 업데이트 시에도 사용자 데이터는 유지됩니다.</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>5. 사용자의 권리</h2>
                    <p>본 앱은 개인정보를 수집하지 않으므로, 별도의 열람, 정정, 삭제 요청이 필요하지 않습니다. 앱 제거 시 관련된 모든 데이터가 자동으로 삭제됩니다.</p>
                </section>

                <section class="policy-section">
                    <h2>6. 개인정보 처리방침 변경</h2>
                    <p>본 개인정보 처리방침은 법령, 정책 또는 보안 기술의 변경에 따라 내용의 추가, 삭제 및 수정이 있을 시에는 변경되는 개인정보 처리방침을 시행하기 최소 7일전에 앱을 통해 공지하겠습니다.</p>
                </section>

                <section class="policy-section">
                    <h2>7. 문의하기</h2>
                    <p>본 개인정보 처리방침에 대한 문의사항이 있으시면 아래의 연락처로 문의해 주시기 바랍니다.</p>
                    <ul>
                        <li>이메일: privacy@googsu.com</li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</div>

<style>
.policy-section {
    margin-bottom: 2rem;
}

.policy-section h2 {
    color: var(--mui-primary);
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.policy-section p {
    margin-bottom: 1rem;
    line-height: 1.6;
}

.policy-section ul {
    list-style-type: disc;
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.policy-section li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.last-updated {
    color: var(--mui-text-secondary);
    font-style: italic;
    margin-bottom: 2rem;
}
</style>

<?php
include_once 'includes/footer.php';
?> 