<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../common/head.php'; ?>

    <style>
    .terms-section {
        margin-bottom: 1.5rem;
    }

    h1 {
        color: #605C5C; /* 짙은 회색 */
    }

    .terms-section h2 {
        color: #605C5C; /* 짙은 회색 */
        font-size: 1.3rem;
        margin-bottom: 0.8rem;
        font-weight: bold;
    }

    .terms-section p,
    .terms-section li {
        color: #605C5C; /* 짙은 회색 */
        margin-bottom: 0.8rem;
        line-height: 1.5;
        font-size: 0.95rem;
    }

    .terms-section ul {
        list-style-type: disc;
        margin-left: 1.2rem;
        margin-bottom: 0.8rem;
    }

    .last-updated {
        color: var(--mui-text-secondary);
        font-style: italic;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../common/menu.php'; ?>
        <div class="content-area">
            <div class="text-compare-container">
                <h1>서비스 약관</h1>
                
                <div class="mui-card">
                    <div class="mui-card-content">
                        <p class="last-updated">최종 수정일: 2024년 3월 15일</p>
                        
                        <section class="terms-section">
                            <h2>1. 서비스 이용 조건</h2>
                            <p>googsu.com은 다음의 조건에 따라 서비스를 제공합니다.</p>
                            <ul>
                                <li>서비스 사용자는 본 약관에 동의해야 합니다.</li>
                                <li>서비스는 개인적, 비상업적 용도로만 사용 가능합니다.</li>
                            </ul>
                        </section>

                        <section class="terms-section">
                            <h2>2. 사용자 의무</h2>
                            <p>사용자는 다음과 같은 의무를 준수해야 합니다:</p>
                            <ul>
                                <li>서비스를 불법적인 목적으로 사용하지 않습니다.</li>
                                <li>서비스의 보안을 위협하는 행위를 하지 않습니다.</li>
                            </ul>
                        </section>

                        <section class="terms-section">
                            <h2>3. 서비스 제한 및 종료</h2>
                            <p>googsu.com은 다음과 같은 경우 서비스 제공을 제한하거나 종료할 수 있습니다:</p>
                            <ul>
                                <li>약관 위반 시</li>
                                <li>법적 요구에 따라</li>
                            </ul>
                        </section>

                        <section class="terms-section">
                            <h2>4. 책임의 한계</h2>
                            <p>googsu.com은 서비스 사용으로 인한 직접적, 간접적 손해에 대해 책임을 지지 않습니다.</p>
                        </section>

                        <section class="terms-section">
                            <h2>5. 약관의 변경</h2>
                            <p>이 약관은 변경될 수 있으며, 변경 시 사전 공지를 통해 알릴 것입니다.</p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../common/footer.php'; ?>
    </div>

</body>
</html>
