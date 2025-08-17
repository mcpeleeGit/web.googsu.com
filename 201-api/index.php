<?php
require(__DIR__ . '/../api/common/route.php');
Route::init($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../common/head.php'; ?>
    <title>Googsu API - 다양한 공공 API 도구 모음</title>
    <meta name="description" content="Googsu에서 제공하는 다양한 공공 API 도구 모음. 주소 검색, 날씨 정보, 카카오 API 등 다양한 기능을 제공합니다.">
    <meta property="og:title" content="Googsu API - 다양한 공공 API 도구 모음">
    <meta property="og:description" content="Googsu에서 제공하는 다양한 공공 API 도구 모음. 주소 검색, 날씨 정보, 카카오 API 등 다양한 기능을 제공합니다.">
    <meta property="og:url" content="https://googsu.com/201-api">
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
        
        .api-menu {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 15px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .api-menu-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .api-menu-left {
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
        
        .home-link i {
            font-size: 1.2em;
        }
        
        .api-menu-title {
            color: white;
            font-size: 1.6em;
            font-weight: bold;
            margin: 0;
        }
        
        .api-menu-right {
            display: flex;
            gap: 12px;
        }
        
        .api-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            min-width: 70px;
        }
        
        .api-icon:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            color: white;
            text-decoration: none;
        }
        
        .api-icon i {
            font-size: 1.8em;
        }
        
        .api-icon span {
            font-size: 0.75em;
            font-weight: 500;
        }
        
        .api-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 90px;
            width: 100%;
            box-sizing: border-box;
        }
        
        .api-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 15px;
            padding: 25px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .api-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #28a745, #20c997);
        }
        
        .api-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border-color: #adb5bd;
        }
        
        .api-card-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .api-icon-large {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5em;
        }
        
        .api-info h3 {
            margin: 0 0 8px 0;
            color: #28a745;
            font-size: 1.4em;
        }
        
        .api-info p {
            margin: 0;
            color: #666;
            font-size: 0.9em;
            line-height: 1.4;
        }
        
        .api-features {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .feature-tag {
            background: #e8f5e8;
            color: #28a745;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 500;
        }
        
        .api-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }
        
        .difficulty {
            display: flex;
            gap: 5px;
        }
        
        .difficulty-star {
            color: #ffc107;
            font-size: 1.1em;
        }
        
        .use-button {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .use-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .coming-soon {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            cursor: not-allowed;
            opacity: 0.7;
        }
        
        @media (max-width: 768px) {
            .api-menu-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .api-menu-left {
                flex-direction: column;
                gap: 10px;
            }
            
            .api-menu-title {
                font-size: 1.4em;
                display: none;
            }
            
            .api-menu-right {
                gap: 8px;
            }
            
            .api-icon {
                padding: 8px;
                min-width: 60px;
            }
            
            .api-icon i {
                font-size: 1.5em;
            }
            
            .api-icon span {
                font-size: 0.7em;
            }
            
            .api-cards {
                grid-template-columns: 1fr;
                padding: 20px;
                margin-top: 140px;
            }
            
            .api-card {
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .api-menu {
                padding: 12px 0;
            }
            
            .api-menu-container {
                gap: 12px;
            }
            
            .api-menu-title {
                font-size: 1.3em;
                display: none;
            }
            
            .api-icon {
                padding: 6px;
                min-width: 55px;
            }
            
            .api-icon i {
                font-size: 1.4em;
            }
            
            .api-icon span {
                font-size: 0.65em;
            }
            
            .api-cards {
                margin-top: 150px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="api-menu">
        <div class="api-menu-container">
            <div class="api-menu-left">
                <a href="/" class="home-link">
                    <i class="fas fa-home"></i>
                    홈으로
                </a>
                <h1 class="api-menu-title">🔌 Googsu API</h1>
            </div>
            <div class="api-menu-right">
                <a href="/201-api/daum-search" class="api-icon">
                    <i class="fas fa-search"></i>
                    <span>다음검색</span>
                </a>
                <a href="/201-api/data-go-kr" class="api-icon">
                    <i class="fas fa-database"></i>
                    <span>공공데이터</span>
                </a>
                <a href="/api/kakao" class="api-icon">
                    <i class="fas fa-comment"></i>
                    <span>카카오</span>
                </a>
                <!-- 추가 API 아이콘들 -->
            </div>
        </div>
    </div>
    
    <div class="api-cards">
        <!-- 다음 검색 API 카드 -->
        <a href="/201-api/daum-search" class="api-card">
            <div class="api-card-header">
                <div class="api-icon-large">
                    <i class="fas fa-search"></i>
                </div>
                <div class="api-info">
                    <h3>다음 검색 API</h3>
                    <p>카카오 다음 검색 API를 활용한 종합 검색 서비스입니다.</p>
                </div>
            </div>
            <div class="api-features">
                <span class="feature-tag">웹문서</span>
                <span class="feature-tag">동영상</span>
                <span class="feature-tag">이미지</span>
                <span class="feature-tag">블로그</span>
                <span class="feature-tag">책</span>
                <span class="feature-tag">카페</span>
            </div>
            <div class="api-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="use-button">API 사용</button>
            </div>
        </a>
        
        <!-- 고객 관리 API 카드 -->
        <a href="/201-api/data-go-kr" class="api-card">
            <div class="api-card-header">
                <div class="api-icon-large">
                    <i class="fas fa-database"></i>
                </div>
                <div class="api-info">
                    <h3>공공데이터 API</h3>
                    <p>공공데이터 포털에서 제공하는 다양한 공공 데이터 API입니다.</p>
                </div>
            </div>
            <div class="api-features">
                <span class="feature-tag">공공데이터</span>
                <span class="feature-tag">API</span>
                <span class="feature-tag">데이터</span>
                <span class="feature-tag">포털</span>
            </div>
            <div class="api-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="use-button">API 사용</button>
            </div>
        </a>
        
        <!-- 카카오 API 카드 -->
        <a href="/api/kakao" class="api-card">
            <div class="api-card-header">
                <div class="api-icon-large">
                    <i class="fas fa-comment"></i>
                </div>
                <div class="api-info">
                    <h3>카카오 API</h3>
                    <p>카카오 로그인, 주소 검색, 검색 API 등을 제공합니다.</p>
                </div>
            </div>
            <div class="api-features">
                <span class="feature-tag">소셜 로그인</span>
                <span class="feature-tag">주소 검색</span>
                <span class="feature-tag">검색</span>
                <span class="feature-tag">OAuth</span>
            </div>
            <div class="api-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="use-button">API 사용</button>
            </div>
        </a>
        
        <!-- 날씨 API 카드 -->
        <div class="api-card">
            <div class="api-card-header">
                <div class="api-icon-large">
                    <i class="fas fa-cloud-sun"></i>
                </div>
                <div class="api-info">
                    <h3>날씨 API</h3>
                    <p>실시간 날씨 정보와 예보를 제공하는 API입니다.</p>
                </div>
            </div>
            <div class="api-features">
                <span class="feature-tag">날씨</span>
                <span class="feature-tag">실시간</span>
                <span class="feature-tag">예보</span>
                <span class="feature-tag">위치 기반</span>
            </div>
            <div class="api-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="coming-soon">준비 중</button>
            </div>
        </div>
        
        <!-- 지도 API 카드 -->
        <div class="api-card">
            <div class="api-card-header">
                <div class="api-icon-large">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="api-info">
                    <h3>지도 API</h3>
                    <p>지도 표시, 위치 검색, 경로 안내를 위한 API입니다.</p>
                </div>
            </div>
            <div class="api-features">
                <span class="feature-tag">지도</span>
                <span class="feature-tag">위치</span>
                <span class="feature-tag">경로</span>
                <span class="feature-tag">좌표</span>
            </div>
            <div class="api-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="coming-soon">준비 중</button>
            </div>
        </div>
        
        <!-- 결제 API 카드 -->
        <div class="api-card">
            <div class="api-card-header">
                <div class="api-icon-large">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="api-info">
                    <h3>결제 API</h3>
                    <p>안전한 온라인 결제를 위한 API입니다.</p>
                </div>
            </div>
            <div class="api-features">
                <span class="feature-tag">결제</span>
                <span class="feature-tag">보안</span>
                <span class="feature-tag">암호화</span>
                <span class="feature-tag">트랜잭션</span>
            </div>
            <div class="api-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="feature-tag">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="coming-soon">준비 중</button>
            </div>
        </div>
    </div>
</body>
</html>
