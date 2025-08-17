<?php
require(__DIR__ . '/../../api/common/route.php');
Route::init($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>메모리 게임 - Googsu Games</title>
    <meta name="description" content="Googsu에서 제공하는 재미있는 메모리 게임. 카드를 뒤집어 같은 그림을 찾아보세요!">
    <meta property="og:title" content="메모리 게임 - Googsu Games">
    <meta property="og:description" content="Googsu에서 제공하는 재미있는 메모리 게임. 카드를 뒤집어 같은 그림을 찾아보세요!">
    <meta property="og:url" content="https://googsu.com/101-game/memory">
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
            max-width: 1000px;
            margin: 0 auto;
            padding: 120px 20px 40px;
            text-align: center;
        }
        
        .game-info {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .info-item {
            text-align: center;
        }
        
        .info-value {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-size: 1em;
            color: #666;
            font-weight: 500;
        }
        
        .controls {
            margin: 20px 0;
        }
        
        .control-button {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        
        .control-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }
        
        .control-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .difficulty-select {
            padding: 8px 15px;
            border: 2px solid #667eea;
            border-radius: 10px;
            font-size: 1em;
            background: white;
            color: #333;
            margin: 0 10px;
        }
        
        .memory-board {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .cards-grid {
            display: grid;
            gap: 15px;
            margin: 30px auto;
            justify-content: center;
        }
        
        .cards-grid.easy {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .cards-grid.medium {
            grid-template-columns: repeat(6, 1fr);
        }
        
        .cards-grid.hard {
            grid-template-columns: repeat(8, 1fr);
        }
        
        .card {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            transform-style: preserve-3d;
            position: relative;
        }
        
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .card.flipped {
            transform: rotateY(180deg);
            background: white;
            color: #333;
            border: 3px solid #667eea;
        }
        
        .card.matched {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-color: #28a745;
            cursor: default;
        }
        
        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
        }
        
        .card-front {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .card-back {
            background: white;
            color: #333;
            border: 3px solid #667eea;
            transform: rotateY(180deg);
        }
        
        .game-message {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            font-size: 1.2em;
            font-weight: 600;
            color: #333;
            backdrop-filter: blur(10px);
        }
        
        .success-message {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            animation: pulse 1s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .timer {
            font-size: 1.5em;
            font-weight: bold;
            color: #dc3545;
        }
        
        @media (max-width: 768px) {
            .game-container {
                padding: 100px 15px 30px;
            }
            
            .memory-board {
                padding: 25px;
            }
            
            .card {
                width: 60px;
                height: 60px;
                font-size: 1.5em;
            }
            
            .cards-grid {
                gap: 10px;
            }
            
            .control-button {
                padding: 10px 20px;
                font-size: 1em;
                margin: 5px;
            }
            
            .game-info {
                padding: 20px;
                gap: 15px;
            }
            
            .info-value {
                font-size: 1.5em;
            }
        }
        
        @media (max-width: 480px) {
            .game-header {
                padding: 15px 0;
            }
            
            .game-title {
                font-size: 1.5em;
            }
            
            .card {
                width: 50px;
                height: 50px;
                font-size: 1.3em;
            }
            
            .cards-grid {
                gap: 8px;
            }
            
            .control-button {
                padding: 8px 16px;
                font-size: 0.9em;
                margin: 3px;
            }
            
            .difficulty-select {
                padding: 6px 12px;
                font-size: 0.9em;
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
            <h1 class="game-title">🧠 메모리 게임</h1>
            <div></div>
        </div>
    </div>
    
    <div class="game-container">
        <div class="game-info">
            <div class="info-item">
                <div class="info-value" id="moves">0</div>
                <div class="info-label">이동 횟수</div>
            </div>
            <div class="info-item">
                <div class="info-value" id="pairs">0</div>
                <div class="info-label">찾은 쌍</div>
            </div>
            <div class="info-item">
                <div class="info-value" id="timer">00:00</div>
                <div class="info-label">시간</div>
            </div>
            <div class="info-item">
                <div class="info-value" id="bestTime">--:--</div>
                <div class="info-label">최고 기록</div>
            </div>
        </div>
        
        <div class="controls">
            <select class="difficulty-select" id="difficultySelect">
                <option value="easy">쉬움 (4x4)</option>
                <option value="medium">보통 (6x6)</option>
                <option value="hard">어려움 (8x8)</option>
            </select>
            <button class="control-button" id="startButton">🎮 게임 시작</button>
            <button class="control-button" id="resetButton">🔄 새 게임</button>
        </div>
        
        <div class="memory-board">
            <div class="cards-grid easy" id="cardsGrid">
                <!-- 카드들이 여기에 생성됩니다 -->
            </div>
        </div>
        
        <div class="game-message" id="gameMessage" style="display: none;">
            게임을 시작해보세요!
        </div>
    </div>
    
    <script>
        class MemoryGame {
            constructor() {
                this.difficulty = 'easy';
                this.cards = [];
                this.flippedCards = [];
                this.matchedPairs = 0;
                this.moves = 0;
                this.gameStarted = false;
                this.gameTimer = null;
                this.startTime = null;
                this.bestTime = localStorage.getItem('memoryGameBestTime') || '--:--';
                
                this.initializeElements();
                this.setupEventListeners();
                this.updateDisplay();
            }
            
            initializeElements() {
                this.difficultySelect = document.getElementById('difficultySelect');
                this.cardsGrid = document.getElementById('cardsGrid');
                this.startButton = document.getElementById('startButton');
                this.resetButton = document.getElementById('resetButton');
                this.gameMessage = document.getElementById('gameMessage');
                
                this.statElements = {
                    moves: document.getElementById('moves'),
                    pairs: document.getElementById('pairs'),
                    timer: document.getElementById('timer'),
                    bestTime: document.getElementById('bestTime')
                };
                
                this.statElements.bestTime.textContent = this.bestTime;
            }
            
            setupEventListeners() {
                this.difficultySelect.addEventListener('change', (e) => {
                    this.difficulty = e.target.value;
                    this.resetGame();
                });
                
                this.startButton.addEventListener('click', () => {
                    this.startGame();
                });
                
                this.resetButton.addEventListener('click', () => {
                    this.resetGame();
                });
            }
            
            startGame() {
                this.gameStarted = true;
                this.startTime = Date.now();
                this.startButton.disabled = true;
                this.difficultySelect.disabled = true;
                
                this.startTimer();
                this.showMessage('게임이 시작되었습니다! 카드를 찾아보세요! 🎯');
            }
            
            startTimer() {
                this.gameTimer = setInterval(() => {
                    if (this.startTime) {
                        const elapsed = Math.floor((Date.now() - this.startTime) / 1000);
                        const minutes = Math.floor(elapsed / 60);
                        const seconds = elapsed % 60;
                        this.statElements.timer.textContent = 
                            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }
                }, 1000);
            }
            
            stopTimer() {
                if (this.gameTimer) {
                    clearInterval(this.gameTimer);
                    this.gameTimer = null;
                }
            }
            
            createCards() {
                this.cardsGrid.innerHTML = '';
                this.cards = [];
                
                const difficultySettings = {
                    easy: { rows: 4, cols: 4, pairs: 8 },
                    medium: { rows: 6, cols: 6, pairs: 18 },
                    hard: { rows: 8, cols: 8, pairs: 32 }
                };
                
                const settings = difficultySettings[this.difficulty];
                this.cardsGrid.className = `cards-grid ${this.difficulty}`;
                
                // 이모지 배열 (쌍으로 만들기)
                const emojis = ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐸', '🐵', '🐔'];
                
                // 카드 쌍 생성
                const cardPairs = [];
                for (let i = 0; i < settings.pairs; i++) {
                    const emoji = emojis[i % emojis.length];
                    cardPairs.push(emoji, emoji);
                }
                
                // 카드 섞기
                this.shuffleArray(cardPairs);
                
                // 카드 생성
                cardPairs.forEach((emoji, index) => {
                    const card = document.createElement('div');
                    card.className = 'card';
                    card.dataset.index = index;
                    card.dataset.emoji = emoji;
                    
                    const cardFront = document.createElement('div');
                    cardFront.className = 'card-front';
                    cardFront.innerHTML = '❓';
                    
                    const cardBack = document.createElement('div');
                    cardBack.className = 'card-back';
                    cardBack.textContent = emoji;
                    
                    card.appendChild(cardFront);
                    card.appendChild(cardBack);
                    
                    card.addEventListener('click', () => this.flipCard(card));
                    
                    this.cardsGrid.appendChild(card);
                    this.cards.push(card);
                });
            }
            
            shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
            }
            
            flipCard(card) {
                if (!this.gameStarted || card.classList.contains('flipped') || 
                    card.classList.contains('matched') || this.flippedCards.length >= 2) {
                    return;
                }
                
                card.classList.add('flipped');
                this.flippedCards.push(card);
                
                if (this.flippedCards.length === 2) {
                    this.moves++;
                    this.updateDisplay();
                    this.checkMatch();
                }
            }
            
            checkMatch() {
                const [card1, card2] = this.flippedCards;
                const match = card1.dataset.emoji === card2.dataset.emoji;
                
                if (match) {
                    // 매치 성공
                    setTimeout(() => {
                        card1.classList.add('matched');
                        card2.classList.add('matched');
                        this.flippedCards = [];
                        this.matchedPairs++;
                        this.updateDisplay();
                        
                        if (this.matchedPairs === this.getTotalPairs()) {
                            this.gameWon();
                        }
                    }, 500);
                } else {
                    // 매치 실패
                    setTimeout(() => {
                        card1.classList.remove('flipped');
                        card2.classList.remove('flipped');
                        this.flippedCards = [];
                    }, 1000);
                }
            }
            
            getTotalPairs() {
                const difficultySettings = {
                    easy: 8,
                    medium: 18,
                    hard: 32
                };
                return difficultySettings[this.difficulty];
            }
            
            gameWon() {
                this.stopTimer();
                const elapsed = Math.floor((Date.now() - this.startTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                // 최고 기록 업데이트
                if (this.bestTime === '--:--' || elapsed < this.parseTime(this.bestTime)) {
                    this.bestTime = timeString;
                    localStorage.setItem('memoryGameBestTime', this.bestTime);
                    this.statElements.bestTime.textContent = this.bestTime;
                }
                
                this.showMessage(`🎉 축하합니다! 모든 카드를 찾았습니다!<br>시간: ${timeString} | 이동: ${this.moves}회`, 'success-message');
                this.gameStarted = false;
                this.startButton.disabled = false;
                this.difficultySelect.disabled = false;
            }
            
            parseTime(timeString) {
                if (timeString === '--:--') return Infinity;
                const [minutes, seconds] = timeString.split(':').map(Number);
                return minutes * 60 + seconds;
            }
            
            showMessage(message, className = '') {
                this.gameMessage.innerHTML = message;
                this.gameMessage.className = `game-message ${className}`;
                this.gameMessage.style.display = 'block';
                
                if (className !== 'success-message') {
                    setTimeout(() => {
                        this.gameMessage.style.display = 'none';
                    }, 3000);
                }
            }
            
            updateDisplay() {
                this.statElements.moves.textContent = this.moves;
                this.statElements.pairs.textContent = this.matchedPairs;
            }
            
            resetGame() {
                this.stopTimer();
                this.flippedCards = [];
                this.matchedPairs = 0;
                this.moves = 0;
                this.gameStarted = false;
                this.startTime = null;
                this.startButton.disabled = false;
                this.difficultySelect.disabled = false;
                
                this.statElements.timer.textContent = '00:00';
                this.updateDisplay();
                this.createCards();
                this.gameMessage.style.display = 'none';
            }
        }
        
        // 게임 시작
        document.addEventListener('DOMContentLoaded', () => {
            new MemoryGame();
        });
    </script>
</body>
</html>
