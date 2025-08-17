<?php
require(__DIR__ . '/../../api/common/route.php');
Route::init($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>주사위 게임 - Googsu Games</title>
    <meta name="description" content="Googsu에서 제공하는 재미있는 주사위 게임. 여러 주사위를 굴려 점수를 얻어보세요!">
    <meta property="og:title" content="주사위 게임 - Googsu Games">
    <meta property="og:description" content="Googsu에서 제공하는 재미있는 주사위 게임. 여러 주사위를 굴려 점수를 얻어보세요!">
    <meta property="og:url" content="https://googsu.com/101-game/dice">
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
        
        .game-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .home-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .home-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        
        .game-title {
            color: white;
            font-size: 2em;
            font-weight: bold;
            margin: 0;
        }
        
        .game-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 120px 20px 40px;
            text-align: center;
        }
        
        .dice-area {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .dice-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        
        .dice {
            width: 80px;
            height: 80px;
            background: white;
            border: 3px solid #667eea;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .dice.rolling {
            animation: roll 0.5s ease-in-out;
        }
        
        @keyframes roll {
            0% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(90deg) scale(1.1); }
            50% { transform: rotate(180deg) scale(1.2); }
            75% { transform: rotate(270deg) scale(1.1); }
            100% { transform: rotate(360deg) scale(1); }
        }
        
        .dice-result {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-color: #28a745;
        }
        
        .controls {
            margin: 30px 0;
        }
        
        .dice-count {
            margin-bottom: 20px;
        }
        
        .dice-count label {
            font-size: 1.2em;
            font-weight: 600;
            color: #333;
            margin-right: 15px;
        }
        
        .dice-count select {
            padding: 10px 15px;
            border: 2px solid #667eea;
            border-radius: 10px;
            font-size: 1.1em;
            background: white;
            color: #333;
        }
        
        .roll-button {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1.3em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        
        .roll-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        }
        
        .roll-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .reset-button {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1.3em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        
        .reset-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.3);
        }
        
        .stats-area {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
            border: 2px solid #e9ecef;
        }
        
        .stat-value {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 1em;
            color: #666;
            font-weight: 500;
        }
        
        .history-area {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .history-title {
            font-size: 1.5em;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .history-list {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
        }
        
        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.9em;
        }
        
        .history-item:last-child {
            border-bottom: none;
        }
        
        .history-dice {
            color: #667eea;
            font-weight: 600;
        }
        
        .history-sum {
            color: #28a745;
            font-weight: 600;
        }
        
        .history-time {
            color: #666;
            font-size: 0.8em;
        }
        
        @media (max-width: 768px) {
            .game-container {
                padding: 100px 15px 30px;
            }
            
            .dice-area, .stats-area, .history-area {
                padding: 25px;
            }
            
            .dice {
                width: 60px;
                height: 60px;
                font-size: 1.5em;
            }
            
            .dice-container {
                gap: 15px;
            }
            
            .roll-button, .reset-button {
                padding: 12px 25px;
                font-size: 1.1em;
                margin: 5px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
        
        @media (max-width: 480px) {
            .game-header {
                padding: 15px 0;
            }
            
            .game-title {
                font-size: 1.5em;
            }
            
            .dice {
                width: 50px;
                height: 50px;
                font-size: 1.3em;
            }
            
            .dice-container {
                gap: 10px;
            }
            
            .roll-button, .reset-button {
                padding: 10px 20px;
                font-size: 1em;
                margin: 3px;
            }
        }
    </style>
</head>
<body>
    <div class="game-header">
        <div class="header-container">
            <a href="/101-game" class="home-link">
                <i class="fas fa-arrow-left"></i>
                게임홈으로
            </a>
            <h1 class="game-title">🎲 주사위 게임</h1>
            <div></div>
        </div>
    </div>
    
    <div class="game-container">
        <div class="dice-area">
            <h2>주사위 굴리기</h2>
            <p>원하는 개수의 주사위를 선택하고 굴려보세요!</p>
            
            <div class="dice-count">
                <label for="diceCount">주사위 개수:</label>
                <select id="diceCount">
                    <option value="1">1개</option>
                    <option value="2">2개</option>
                    <option value="3">3개</option>
                    <option value="4">4개</option>
                    <option value="5">5개</option>
                    <option value="6">6개</option>
                </select>
            </div>
            
            <div class="dice-container" id="diceContainer">
                <div class="dice" id="dice1">?</div>
            </div>
            
            <div class="controls">
                <button class="roll-button" id="rollButton">🎲 주사위 굴리기</button>
                <button class="reset-button" id="resetButton">🔄 초기화</button>
            </div>
        </div>
        
        <div class="stats-area">
            <h2>게임 통계</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value" id="totalRolls">0</div>
                    <div class="stat-label">총 굴림 횟수</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="totalScore">0</div>
                    <div class="stat-label">총 점수</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="averageScore">0</div>
                    <div class="stat-label">평균 점수</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="highestScore">0</div>
                    <div class="stat-label">최고 점수</div>
                </div>
            </div>
        </div>
        
        <div class="history-area">
            <h3 class="history-title">주사위 기록</h3>
            <div class="history-list" id="historyList">
                <div class="history-item">
                    <span>게임을 시작해보세요!</span>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        class DiceGame {
            constructor() {
                this.diceCount = 1;
                this.totalRolls = 0;
                this.totalScore = 0;
                this.highestScore = 0;
                this.history = [];
                this.isRolling = false;
                
                this.initializeElements();
                this.setupEventListeners();
                this.updateDisplay();
            }
            
            initializeElements() {
                this.diceCountSelect = document.getElementById('diceCount');
                this.diceContainer = document.getElementById('diceContainer');
                this.rollButton = document.getElementById('rollButton');
                this.resetButton = document.getElementById('resetButton');
                this.historyList = document.getElementById('historyList');
                
                this.statElements = {
                    totalRolls: document.getElementById('totalRolls'),
                    totalScore: document.getElementById('totalScore'),
                    averageScore: document.getElementById('averageScore'),
                    highestScore: document.getElementById('highestScore')
                };
            }
            
            setupEventListeners() {
                this.diceCountSelect.addEventListener('change', (e) => {
                    this.diceCount = parseInt(e.target.value);
                    this.createDice();
                });
                
                this.rollButton.addEventListener('click', () => {
                    if (!this.isRolling) {
                        this.rollDice();
                    }
                });
                
                this.resetButton.addEventListener('click', () => {
                    this.resetGame();
                });
            }
            
            createDice() {
                this.diceContainer.innerHTML = '';
                for (let i = 0; i < this.diceCount; i++) {
                    const dice = document.createElement('div');
                    dice.className = 'dice';
                    dice.id = `dice${i + 1}`;
                    dice.textContent = '?';
                    this.diceContainer.appendChild(dice);
                }
            }
            
            async rollDice() {
                if (this.isRolling) return;
                
                this.isRolling = true;
                this.rollButton.disabled = true;
                
                const diceElements = document.querySelectorAll('.dice');
                const results = [];
                
                // 주사위 애니메이션 시작
                diceElements.forEach(dice => {
                    dice.classList.add('rolling');
                });
                
                // 애니메이션 대기
                await new Promise(resolve => setTimeout(resolve, 500));
                
                // 주사위 결과 생성
                diceElements.forEach((dice, index) => {
                    const result = Math.floor(Math.random() * 6) + 1;
                    results.push(result);
                    
                    dice.textContent = result;
                    dice.classList.remove('rolling');
                    dice.classList.add('dice-result');
                    
                    // 결과 표시 애니메이션
                    setTimeout(() => {
                        dice.classList.remove('dice-result');
                    }, 1000);
                });
                
                // 통계 업데이트
                const sum = results.reduce((a, b) => a + b, 0);
                this.updateStats(sum);
                this.addToHistory(results, sum);
                
                // 버튼 활성화
                this.isRolling = false;
                this.rollButton.disabled = false;
            }
            
            updateStats(sum) {
                this.totalRolls++;
                this.totalScore += sum;
                this.highestScore = Math.max(this.highestScore, sum);
                
                this.updateDisplay();
            }
            
            addToHistory(results, sum) {
                const now = new Date();
                const timeString = now.toLocaleTimeString('ko-KR', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                
                const historyItem = {
                    results: results,
                    sum: sum,
                    time: timeString
                };
                
                this.history.unshift(historyItem);
                
                // 최근 10개만 유지
                if (this.history.length > 10) {
                    this.history = this.history.slice(0, 10);
                }
                
                this.updateHistoryDisplay();
            }
            
            updateHistoryDisplay() {
                this.historyList.innerHTML = '';
                
                if (this.history.length === 0) {
                    this.historyList.innerHTML = '<div class="history-item"><span>게임을 시작해보세요!</span></div>';
                    return;
                }
                
                this.history.forEach(item => {
                    const historyItem = document.createElement('div');
                    historyItem.className = 'history-item';
                    
                    const diceText = item.results.map(r => `🎲${r}`).join(' ');
                    const sumText = `합계: ${item.sum}`;
                    
                    historyItem.innerHTML = `
                        <span class="history-dice">${diceText}</span>
                        <span class="history-sum">${sumText}</span>
                        <span class="history-time">${item.time}</span>
                    `;
                    
                    this.historyList.appendChild(historyItem);
                });
            }
            
            updateDisplay() {
                this.statElements.totalRolls.textContent = this.totalRolls;
                this.statElements.totalScore.textContent = this.totalScore;
                this.statElements.highestScore.textContent = this.highestScore;
                
                const average = this.totalRolls > 0 ? (this.totalScore / this.totalRolls).toFixed(1) : 0;
                this.statElements.averageScore.textContent = average;
            }
            
            resetGame() {
                this.totalRolls = 0;
                this.totalScore = 0;
                this.highestScore = 0;
                this.history = [];
                
                this.createDice();
                this.updateDisplay();
                this.updateHistoryDisplay();
            }
        }
        
        // 게임 시작
        document.addEventListener('DOMContentLoaded', () => {
            new DiceGame();
        });
    </script>
</body>
</html>
