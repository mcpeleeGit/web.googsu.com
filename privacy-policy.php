<?php
$page_title = '개인정보 처리방침';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>개인정보 처리방침</h1>
        
        <div class="mui-card">
            <div class="mui-card-content">
                <p class="last-updated">최종 수정일: 2024년 3월 15일</p>
                
                <section class="policy-section">
                    <h2>1. 개인정보의 처리 목적</h2>
                    <p>googsu.com은 다음의 목적을 위하여 개인정보를 처리하고 있으며, 다음의 목적 이외의 용도로는 이용하지 않습니다.</p>
                    <ul>
                        <li>웹 서비스 제공</li>
                        <li>사용자 경험 개선</li>
                        <li>서비스 이용 통계 분석</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>2. 수집하는 개인정보 항목</h2>
                    <p>googsu.com은 다음과 같은 개인정보 항목을 수집할 수 있습니다:</p>
                    <ul>
                        <li>자동 수집 항목: IP 주소, 브라우저 유형, 접속 시간</li>
                        <li>Google Analytics를 통해 수집되는 웹사이트 사용 정보</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>3. 개인정보의 보유 및 이용 기간</h2>
                    <p>이용자의 개인정보는 원칙적으로 개인정보의 수집 및 이용목적이 달성되면 지체 없이 파기합니다.</p>
                </section>

                <section class="policy-section">
                    <h2>4. 개인정보의 파기절차 및 방법</h2>
                    <p>개인정보 파기 시에는 다음과 같은 절차와 방법에 따라 진행됩니다:</p>
                    <ul>
                        <li>파기절차: 이용목적이 달성된 개인정보는 별도의 DB로 옮겨져 내부 방침 및 기타 관련 법령에 따라 일정기간 저장된 후 파기됩니다.</li>
                        <li>파기방법: 전자적 파일 형태로 저장된 개인정보는 기록을 재생할 수 없는 기술적 방법을 사용하여 삭제합니다.</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>5. 개인정보 보호책임자</h2>
                    <p>googsu.com은 개인정보 처리에 관한 업무를 총괄해서 책임지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등을 위하여 아래와 같이 개인정보 보호책임자를 지정하고 있습니다.</p>
                    <ul>
                        <li>개인정보 보호책임자</li>
                        <li>이메일: privacy@googsu.com</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>6. 개인정보 처리방침의 변경</h2>
                    <p>이 개인정보 처리방침은 시행일로부터 적용되며, 법령 및 방침에 따른 변경내용의 추가, 삭제 및 정정이 있는 경우에는 변경사항의 시행 7일 전부터 공지사항을 통하여 고지할 것입니다.</p>
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