<?php
require(__DIR__ . '/../api/common/route.php');
Route::init($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../common/head.php'; ?>
    <title>개인정보 처리방침 - Googsu Games</title>
    <meta name="description" content="Googsu Games 개인정보 처리방침. com.googsu.game 앱은 개인정보를 수집하지 않습니다.">
    <meta property="og:title" content="개인정보 처리방침 - Googsu Games">
    <meta property="og:description" content="Googsu Games 개인정보 처리방침. com.googsu.game 앱은 개인정보를 수집하지 않습니다.">
    <meta property="og:url" content="https://googsu.com/101-game/privacy-policy">
    <meta property="og:image" content="https://googsu.com/images/tools-og-image.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        .game-menu {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .game-menu-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .game-menu-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .home-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-size: 1.1em;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .home-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        
        .policy-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 120px 20px 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-top: 90px;
            margin-bottom: 40px;
        }
        
        .policy-section {
            margin-bottom: 2rem;
        }

        h1 {
            color: #605C5C;
            font-size: 2.5em;
            margin-bottom: 1rem;
        }

        .policy-section h2 {
            color: #605C5C;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: bold;
            margin-top: 2rem;
        }

        .policy-section h2:first-of-type {
            margin-top: 0;
        }

        .policy-section p,
        .policy-section li {
            color: #605C5C;
            margin-bottom: 0.8rem;
            line-height: 1.6;
            font-size: 1rem;
        }

        .policy-section ul {
            list-style-type: disc;
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .policy-section ol {
            list-style-type: decimal;
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .last-updated {
            color: #6c757d;
            font-style: italic;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }
        
        .highlight-box {
            background: #e7f5ff;
            border-left: 4px solid #1971c2;
            padding: 1rem 1.5rem;
            margin: 1.5rem 0;
            border-radius: 4px;
        }
        
        .highlight-box p {
            margin: 0;
            color: #1971c2;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .policy-container {
                margin-top: 100px;
                padding: 100px 15px 30px;
            }
            
            h1 {
                font-size: 2em;
            }
            
            .policy-section h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="game-menu">
        <div class="game-menu-container">
            <div class="game-menu-left">
                <a href="/101-game" class="home-link">
                    <i class="fas fa-arrow-left"></i>
                    게임으로 돌아가기
                </a>
                <h1 class="game-menu-title" style="color: white; font-size: 1.6em; margin: 0;">개인정보 처리방침</h1>
            </div>
        </div>
    </div>
    
    <div class="policy-container">
        <h1>개인정보 처리방침</h1>
        
        <p class="last-updated">최종 수정일: 2024년 12월 20일</p>
        
        <div class="highlight-box">
            <p>📱 com.googsu.game 앱은 개인정보를 수집하지 않습니다.</p>
        </div>
        
        <section class="policy-section">
            <h2>1. 개인정보의 처리 목적</h2>
            <p>googsu.com의 101-game 서비스는 다음의 목적을 위하여 개인정보를 처리하고 있으며, 다음의 목적 이외의 용도로는 이용하지 않습니다.</p>
            <ul>
                <li>웹 게임 서비스 제공</li>
                <li>사용자 경험 개선</li>
                <li>서비스 이용 통계 분석 (익명화된 데이터)</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>2. 수집하는 개인정보 항목</h2>
            <p>googsu.com의 101-game 웹 서비스는 다음과 같은 개인정보 항목을 수집할 수 있습니다:</p>
            <ul>
                <li>자동 수집 항목: IP 주소, 브라우저 유형, 접속 시간</li>
                <li>Google Analytics를 통해 수집되는 웹사이트 사용 정보 (익명화된 데이터)</li>
            </ul>
            
            <div class="highlight-box" style="margin-top: 1.5rem;">
                <p><strong>중요:</strong> com.googsu.game 모바일 앱은 어떠한 개인정보도 수집하지 않습니다. 앱의 모든 기능은 사용자의 기기 내에서만 처리되며, 외부 서버와의 통신이나 데이터 저장을 하지 않습니다.</p>
            </div>
        </section>

        <section class="policy-section">
            <h2>3. com.googsu.game 앱의 개인정보 수집 및 이용</h2>
            <p><strong>com.googsu.game 앱은 개인정보를 수집하거나 이용하지 않습니다.</strong></p>
            <ul>
                <li>앱의 모든 기능은 사용자의 기기 내에서만 처리됩니다.</li>
                <li>외부 서버와의 통신이나 데이터 저장을 하지 않습니다.</li>
                <li>사용자의 이름, 이메일, 전화번호 등 어떠한 개인정보도 수집하지 않습니다.</li>
                <li>게임 점수, 진행 상황 등 게임 데이터도 외부로 전송되지 않습니다.</li>
                <li>앱은 오프라인에서도 완전히 작동합니다.</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>4. 개인정보의 보유 및 이용 기간</h2>
            <p>이용자의 개인정보는 원칙적으로 개인정보의 수집 및 이용목적이 달성되면 지체 없이 파기합니다.</p>
            <p>com.googsu.game 앱의 경우, 개인정보를 수집하지 않으므로 보유 및 이용 기간이 적용되지 않습니다.</p>
        </section>

        <section class="policy-section">
            <h2>5. 개인정보의 파기절차 및 방법</h2>
            <p>개인정보 파기 시에는 다음과 같은 절차와 방법에 따라 진행됩니다:</p>
            <ul>
                <li>파기절차: 이용목적이 달성된 개인정보는 별도의 DB로 옮겨져 내부 방침 및 기타 관련 법령에 따라 일정기간 저장된 후 파기됩니다.</li>
                <li>파기방법: 전자적 파일 형태로 저장된 개인정보는 기록을 재생할 수 없는 기술적 방법을 사용하여 삭제합니다.</li>
            </ul>
            <p>com.googsu.game 앱의 경우, 개인정보를 수집하지 않으므로 파기 절차가 필요하지 않습니다. 앱 삭제 시 기기 내 저장된 게임 데이터도 함께 삭제됩니다.</p>
        </section>

        <section class="policy-section">
            <h2>6. 개인정보 보호를 위한 기술적/관리적 조치</h2>
            <p>com.googsu.game 앱은 개인정보를 수집하지 않지만, 사용자의 데이터 보호를 위해 다음과 같은 조치를 취하고 있습니다:</p>
            <ul>
                <li>모든 데이터 처리는 사용자의 기기 내에서만 이루어집니다.</li>
                <li>외부 서버로의 데이터 전송이 없습니다.</li>
                <li>앱 업데이트 시에도 사용자 데이터는 유지됩니다.</li>
                <li>네트워크 권한은 앱 업데이트 확인을 위해서만 사용됩니다.</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>7. 앱 권한 사용</h2>
            <p>com.googsu.game 앱은 다음과 같은 기기 권한을 사용할 수 있습니다:</p>
            <ul>
                <li>인터넷 접근 권한: 앱 업데이트 확인을 위해서만 사용됩니다. 개인정보 수집 목적으로는 사용되지 않습니다.</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>8. 사용자의 권리</h2>
            <p>com.googsu.game 앱은 개인정보를 수집하지 않으므로, 별도의 열람, 정정, 삭제 요청이 필요하지 않습니다. 앱 제거 시 관련된 모든 데이터가 자동으로 삭제됩니다.</p>
        </section>

        <section class="policy-section">
            <h2>9. 개인정보 보호책임자</h2>
            <p>googsu.com은 개인정보 처리에 관한 업무를 총괄해서 책임지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등을 위하여 아래와 같이 개인정보 보호책임자를 지정하고 있습니다.</p>
            <ul>
                <li>개인정보 보호책임자</li>
                <li>이메일: googsucom@gmail.com</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>10. 개인정보 처리방침의 변경</h2>
            <p>이 개인정보 처리방침은 시행일로부터 적용되며, 법령 및 방침에 따른 변경내용의 추가, 삭제 및 정정이 있는 경우에는 변경사항의 시행 7일 전부터 공지사항을 통하여 고지할 것입니다.</p>
        </section>

        <section class="policy-section">
            <h2>11. 문의하기</h2>
            <p>본 개인정보 처리방침에 대한 문의사항이 있으시면 아래의 연락처로 문의해 주시기 바랍니다.</p>
            <ul>
                <li>이메일: googsucom@gmail.com</li>
            </ul>
        </section>
    </div>
    
</body>
</html>
