<?php
require(__DIR__ . '/../api/common/route.php');
Route::init($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../common/head.php'; ?>
    <title>Googsu Games - 다양한 온라인 게임 모음</title>
    <meta name="description" content="Googsu에서 제공하는 다양한 온라인 게임 모음. 테트리스, 퍼즐 게임 등 다양한 게임을 즐겨보세요.">
    <meta property="og:title" content="Googsu Games - 다양한 온라인 게임 모음">
    <meta property="og:description" content="Googsu에서 제공하는 다양한 온라인 게임 모음. 테트리스, 퍼즐 게임 등 다양한 게임을 즐겨보세요.">
    <meta property="og:url" content="https://googsu.com/101-game">
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
        
        .home-link i {
            font-size: 1.2em;
        }
        
        .game-menu-title {
            color: white;
            font-size: 1.6em;
            font-weight: bold;
            margin: 0;
        }
        
        .game-menu-right {
            display: flex;
            gap: 12px;
        }
        
        .game-icon {
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
        
        .game-icon:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            color: white;
            text-decoration: none;
        }
        
        .game-icon i {
            font-size: 1.8em;
        }
        
        .game-icon span {
            font-size: 0.75em;
            font-weight: 500;
        }
        
        .game-cards {
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
        
        .game-card {
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
        
        .game-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .game-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border-color: #adb5bd;
        }
        
        .game-card-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .game-icon-large {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5em;
        }
        
        .game-info h3 {
            margin: 0 0 8px 0;
            color: #1971c2;
            font-size: 1.4em;
        }
        
        .game-info p {
            margin: 0;
            color: #666;
            font-size: 0.9em;
            line-height: 1.4;
        }
        
        .game-features {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .feature-tag {
            background: #e7f5ff;
            color: #1971c2;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 500;
        }
        
        .game-stats {
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
        
        .play-button {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .play-button:hover {
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
        

        
        .page-title h1 {
            color: #495057;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .page-title p {
            color: #6c757d;
            font-size: 1.1em;
            margin: 0;
        }
        
        @media (max-width: 768px) {
            .game-menu-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .game-menu-left {
                flex-direction: column;
                gap: 10px;
            }
            
            .game-menu-title {
                font-size: 1.4em;
                display: none;
            }
            
            .game-menu-right {
                gap: 8px;
            }
            
            .game-icon {
                padding: 8px;
                min-width: 60px;
            }
            
            .game-icon i {
                font-size: 1.5em;
            }
            
            .game-icon span {
                font-size: 0.7em;
            }
            
            .game-cards {
                grid-template-columns: 1fr;
                padding: 20px;
                margin-top: 140px;
            }
            
            .game-card {
                padding: 20px;
            }
            
            .page-title h1 {
                font-size: 2em;
            }
        }
        
        @media (max-width: 480px) {
            .game-menu {
                padding: 12px 0;
            }
            
            .game-menu-container {
                gap: 12px;
            }
            
            .game-menu-title {
                font-size: 1.3em;
                display: none;
            }
            
            .game-icon {
                padding: 6px;
                min-width: 55px;
            }
            
            .game-icon i {
                font-size: 1.4em;
            }
            
            .game-icon span {
                font-size: 0.65em;
            }
            
            .game-cards {
                margin-top: 150px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="game-menu">
        <div class="game-menu-container">
            <div class="game-menu-left">
                <a href="/" class="home-link">
                    <i class="fas fa-home"></i>
                    홈으로
                </a>
                <h1 class="game-menu-title">🎮 Googsu Games</h1>
            </div>
            <div class="game-menu-right">
                <a href="/101-game/tetris" class="game-icon">
                    <i class="fas fa-th-large"></i>
                    <span>테트리스</span>
                </a>
                <a href="/101-game/puzzle" class="game-icon">
                    <i class="fas fa-puzzle-piece"></i>
                    <span>숫자 퍼즐</span>
                </a>
                <a href="/101-game/multi-tetris" class="game-icon">
                    <i class="fas fa-users"></i>
                    <span>멀티 테트리스</span>
                </a>
                <a href="/101-game/chess" class="game-icon">
                    <i class="fas fa-chess"></i>
                    <span>체스</span>
                </a>
                <a href="/101-game/dice" class="game-icon">
                    <i class="fas fa-dice"></i>
                    <span>주사위</span>
                </a>
                <a href="/101-game/memory" class="game-icon">
                    <i class="fas fa-memory"></i>
                    <span>메모리</span>
                </a>
                <!-- 추가 게임 아이콘들 -->
            </div>
        </div>
    </div>
    
    <div class="game-cards">
        <!-- 테트리스 게임 카드 -->
        <a href="/101-game/tetris" class="game-card">
            <div class="game-card-header">
                <div class="game-icon-large">
                    <i class="fas fa-th-large"></i>
                </div>
                <div class="game-info">
                    <h3>테트리스</h3>
                    <p>클래식한 테트리스 게임을 즐겨보세요. 블록을 회전하고 이동시켜 라인을 완성하세요!</p>
                </div>
            </div>
            <div class="game-features">
                <span class="feature-tag">퍼즐</span>
                <span class="feature-tag">전략</span>
                <span class="feature-tag">실시간</span>
                <span class="feature-tag">점수 시스템</span>
            </div>
            <div class="game-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="play-button">게임 시작</button>
            </div>
        </a>
        
        <!-- 추가 게임 카드들 (향후 확장용) -->
        <a href="/101-game/puzzle" class="game-card">
            <div class="game-card-header">
                <div class="game-icon-large">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <div class="game-info">
                    <h3>숫자 퍼즐</h3>
                    <p>숫자를 맞추는 재미있는 퍼즐 게임입니다. 논리적 사고를 키워보세요!</p>
                </div>
            </div>
            <div class="game-features">
                <span class="feature-tag">퍼즐</span>
                <span class="feature-tag">논리</span>
                <span class="feature-tag">숫자</span>
                <span class="feature-tag">단계별</span>
            </div>
            <div class="game-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="play-button">게임 시작</button>
            </div>
        </a>
        
        <!-- 멀티플레이어 테트리스 게임 카드 -->
        <a href="/101-game/multi-tetris" class="game-card">
            <div class="game-card-header">
                <div class="game-icon-large">
                    <i class="fas fa-users"></i>
                </div>
                <div class="game-info">
                    <h3>멀티플레이어 테트리스</h3>
                    <p>최대 2명이 함께 플레이하는 경쟁 테트리스! 같은 공간에서 각자 블록을 조작하며 점수를 겨뤄보세요!</p>
                </div>
            </div>
            <div class="game-features">
                <span class="feature-tag">멀티플레이어</span>
                <span class="feature-tag">경쟁</span>
                <span class="feature-tag">실시간</span>
                <span class="feature-tag">협동</span>
            </div>
            <div class="game-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="play-button">게임 시작</button>
            </div>
        </a>
        
        <!-- 체스 게임 카드 -->
        <a href="/101-game/chess" class="game-card">
            <div class="game-card-header">
                <div class="game-icon-large">
                    <i class="fas fa-chess"></i>
                </div>
                <div class="game-info">
                    <h3>체스 게임</h3>
                    <p>전략적 사고가 필요한 체스 게임입니다. 모든 체스 규칙이 구현된 완전한 게임을 즐겨보세요!</p>
                </div>
            </div>
            <div class="game-features">
                <span class="feature-tag">보드게임</span>
                <span class="feature-tag">전략</span>
                <span class="feature-tag">체스 규칙</span>
                <span class="feature-tag">2인 플레이</span>
            </div>
            <div class="game-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="play-button">게임 시작</button>
            </div>
        </a>
        
        <!-- 주사위 게임 카드 -->
        <a href="/101-game/dice" class="game-card">
            <div class="game-card-header">
                <div class="game-icon-large">
                    <i class="fas fa-dice"></i>
                </div>
                <div class="game-info">
                    <h3>주사위 게임</h3>
                    <p>여러 주사위를 굴려 점수를 얻는 재미있는 게임입니다. 통계와 기록도 확인할 수 있어요!</p>
                </div>
            </div>
            <div class="game-features">
                <span class="feature-tag">주사위</span>
                <span class="feature-tag">확률</span>
                <span class="feature-tag">점수</span>
                <span class="feature-tag">통계</span>
            </div>
            <div class="game-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="play-button">게임 시작</button>
            </div>
        </a>
        
        <!-- 메모리 게임 카드 -->
        <a href="/101-game/memory" class="game-card">
            <div class="game-card-header">
                <div class="game-icon-large">
                    <i class="fas fa-memory"></i>
                </div>
                <div class="game-info">
                    <h3>메모리 게임</h3>
                    <p>카드를 뒤집어 같은 그림을 찾는 메모리 게임입니다. 기억력을 테스트하고 빠른 시간에 모든 카드를 매치해보세요!</p>
                </div>
            </div>
            <div class="game-features">
                <span class="feature-tag">메모리</span>
                <span class="feature-tag">카드</span>
                <span class="feature-tag">집중력</span>
                <span class="feature-tag">난이도 선택</span>
            </div>
            <div class="game-stats">
                <div class="difficulty">
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                    <span class="difficulty-star">⭐</span>
                </div>
                <button class="play-button">게임 시작</button>
            </div>
        </a>
        
        <div class="game-card">
            <div class="game-card-header">
                <div class="game-icon-large">
                    <i class="fas fa-rocket"></i>
                </div>
                <div class="game-info">
                    <h3>우주선 게임</h3>
                    <p>우주선을 조종하여 장애물을 피하는 액션 게임입니다!</p>
                </div>
            </div>
            <div class="game-features">
                <span class="feature-tag">액션</span>
                <span class="feature-tag">우주</span>
                <span class="feature-tag">회피</span>
                <span class="feature-tag">속도감</span>
            </div>
            <div class="game-stats">
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
    </div>
    
</body>
</html>
