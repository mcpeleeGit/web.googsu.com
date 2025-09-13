<?php
require(__DIR__ . '/../../api/common/route.php');
Route::init($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>노노그램 게임 - Googsu Games</title>
    <meta name="description" content="Googsu에서 제공하는 재미있는 노노그램 퍼즐 게임. 숫자 힌트를 보고 패턴을 찾아보세요!">
    <meta property="og:title" content="노노그램 게임 - Googsu Games">
    <meta property="og:description" content="Googsu에서 제공하는 재미있는 노노그램 퍼즐 게임. 숫자 힌트를 보고 패턴을 찾아보세요!">
    <meta property="og:url" content="https://googsu.com/101-game/nonograms">
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
        
        .difficulty-selector {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
        }

        .difficulty-btn {
            padding: 8px 16px;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .difficulty-btn.active {
            background: #667eea;
            color: white;
        }

        .difficulty-btn:hover {
            background: #5a6fd8;
            color: white;
        }

        .game-controls {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        .control-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 5px;
        }

        .control-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }

        .control-btn.primary {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .control-btn.primary:hover {
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        .nonogram-board {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-x: auto;
        }

        .board-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* 큰 크기 게임을 위한 스타일 */
        .board-container.large {
            transform: scale(0.8);
            transform-origin: top center;
        }

        .board-container.extra-large {
            transform: scale(0.6);
            transform-origin: top center;
        }

        .row-hints {
            display: flex;
            margin-bottom: 5px;
            min-width: 200px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .hint-cell {
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            color: #333;
            background: #f8f9fa;
            border: 1px solid #ddd;
            margin-right: 2px;
            margin-bottom: 2px;
            flex-shrink: 0;
        }

        .hint-cell:last-child {
            margin-right: 0;
        }

        .game-row {
            display: flex;
            margin-bottom: 5px;
        }

        .game-row:last-child {
            margin-bottom: 0;
        }

        .col-hints {
            display: flex;
            flex-direction: column;
            margin-right: 5px;
            min-height: 200px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .col-hint-cell {
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            color: #333;
            background: #f8f9fa;
            border: 1px solid #ddd;
            margin-bottom: 2px;
            margin-right: 2px;
            flex-shrink: 0;
        }

        .col-hint-cell:last-child {
            margin-bottom: 0;
        }

        .game-cell {
            width: 25px;
            height: 25px;
            border: 1px solid #333;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.2s;
            background: white;
            margin-right: 2px;
            margin-bottom: 2px;
            flex-shrink: 0;
        }

        .game-cell:last-child {
            margin-right: 0;
        }

        .game-cell.filled {
            background: #333;
            color: white;
        }

        .game-cell.marked {
            background: #ffc107;
            color: #333;
        }

        .game-cell:hover {
            background: #e9ecef;
        }

        .game-cell.filled:hover {
            background: #555;
        }

        .game-cell.marked:hover {
            background: #ffca2c;
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
        
        .error-message {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }
        
        .instructions {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        .instructions h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .instructions ul {
            margin: 0;
            padding-left: 20px;
        }

        .instructions li {
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .timer {
            font-family: 'Courier New', monospace;
            font-size: 1.5em;
            font-weight: bold;
            color: #dc3545;
        }

        .progress-bar {
            width: 100%;
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #20c997);
            transition: width 0.3s ease;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .game-container {
                padding: 100px 15px 30px;
            }
            
            .nonogram-board {
                padding: 25px;
            }
            
            .hint-cell, .col-hint-cell, .game-cell {
                width: 20px;
                height: 20px;
                font-size: 8px;
            }
            
            .row-hints {
                min-width: 150px;
            }
            
            .col-hints {
                min-height: 150px;
            }
            
            .difficulty-selector {
                flex-wrap: wrap;
                gap: 5px;
            }
            
            .difficulty-btn {
                font-size: 0.8em;
                padding: 6px 12px;
            }
            
            .board-container.large {
                transform: scale(0.6);
            }
            
            .board-container.extra-large {
                transform: scale(0.4);
            }
            
            .control-btn {
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
            
            .instructions {
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .game-header {
                padding: 15px 0;
            }
            
            .game-title {
                font-size: 1.5em;
            }
            
            .hint-cell, .col-hint-cell, .game-cell {
                width: 18px;
                height: 18px;
                font-size: 7px;
            }
            
            .row-hints {
                min-width: 120px;
            }
            
            .col-hints {
                min-height: 120px;
            }
            
            .control-btn {
                padding: 8px 16px;
                font-size: 0.9em;
                margin: 3px;
            }
            
            .difficulty-btn {
                padding: 6px 12px;
                font-size: 0.9em;
                margin: 3px;
            }
            
            .board-container.large {
                transform: scale(0.5);
            }
            
            .board-container.extra-large {
                transform: scale(0.3);
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
            <h1 class="game-title">🧩 노노그램 게임</h1>
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
                <div class="info-value" id="progress">0%</div>
                <div class="info-label">진행률</div>
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
        
        <div class="instructions">
            <h3><i class="fas fa-info-circle"></i> 게임 방법</h3>
            <ul>
                <li><strong>목표:</strong> 숫자 힌트를 보고 올바른 패턴을 찾아 칸을 채우세요</li>
                <li><strong>왼쪽 숫자:</strong> 각 행에서 연속으로 채워야 할 칸의 개수</li>
                <li><strong>위쪽 숫자:</strong> 각 열에서 연속으로 채워야 할 칸의 개수</li>
                <li><strong>클릭:</strong> 왼쪽 클릭으로 칸 채우기, 오른쪽 클릭으로 표시하기</li>
                <li><strong>힌트:</strong> 숫자 힌트는 순서대로 나타나며, 빈 칸으로 구분됩니다</li>
            </ul>
        </div>

        <div class="controls">
            <div class="difficulty-selector">
                <button class="difficulty-btn active" data-difficulty="easy">쉬움 (5x5)</button>
                <button class="difficulty-btn" data-difficulty="medium">보통 (8x8)</button>
                <button class="difficulty-btn" data-difficulty="hard">어려움 (10x10)</button>
                <button class="difficulty-btn" data-difficulty="expert">전문가 (12x12)</button>
                <button class="difficulty-btn" data-difficulty="master">마스터 (20x20)</button>
                <button class="difficulty-btn" data-difficulty="legend">전설 (25x25)</button>
            </div>
            
            <div class="game-controls">
                <button class="control-btn" id="newGameBtn">
                    <i class="fas fa-refresh"></i> 새 게임
                </button>
                <button class="control-btn" id="hintBtn">
                    <i class="fas fa-lightbulb"></i> 힌트
                </button>
                <button class="control-btn" id="checkBtn">
                    <i class="fas fa-check"></i> 확인
                </button>
                <button class="control-btn primary" id="solveBtn">
                    <i class="fas fa-magic"></i> 해답 보기
                </button>
            </div>
        </div>

        <div class="nonogram-board" id="gameBoard">
            <!-- 게임 보드가 여기에 동적으로 생성됩니다 -->
        </div>
        
        <div class="game-message" id="gameMessage" style="display: none;">
            게임을 시작해보세요!
        </div>
    </div>

    <script>
        class NonogramGame {
            constructor() {
                this.currentDifficulty = 'easy';
                this.gameBoard = null;
                this.solution = null;
                this.playerBoard = null;
                this.hints = { rows: [], cols: [] };
                this.size = 5;
                this.startTime = null;
                this.timerInterval = null;
                this.moves = 0;
                this.isGameComplete = false;
                this.bestTime = localStorage.getItem('nonogramGameBestTime') || '--:--';
                
                this.difficulties = {
                    easy: { size: 5, name: '쉬움' },
                    medium: { size: 8, name: '보통' },
                    hard: { size: 10, name: '어려움' },
                    expert: { size: 12, name: '전문가' },
                    master: { size: 20, name: '마스터' },
                    legend: { size: 25, name: '전설' }
                };

                this.init();
            }

            init() {
                this.bindEvents();
                this.updateDisplay();
                this.generateNewGame();
            }

            bindEvents() {
                // 난이도 선택
                document.querySelectorAll('.difficulty-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        this.selectDifficulty(e.target.dataset.difficulty);
                    });
                });

                // 게임 컨트롤
                document.getElementById('newGameBtn').addEventListener('click', () => {
                    this.generateNewGame();
                });

                document.getElementById('hintBtn').addEventListener('click', () => {
                    this.showHint();
                });

                document.getElementById('checkBtn').addEventListener('click', () => {
                    this.checkSolution();
                });

                document.getElementById('solveBtn').addEventListener('click', () => {
                    this.showSolution();
                });
            }

            selectDifficulty(difficulty) {
                this.currentDifficulty = difficulty;
                this.size = this.difficulties[difficulty].size;
                
                // UI 업데이트
                document.querySelectorAll('.difficulty-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                document.querySelector(`[data-difficulty="${difficulty}"]`).classList.add('active');
                
                this.generateNewGame();
            }

            generateNewGame() {
                this.isGameComplete = false;
                this.moves = 0;
                this.startTime = Date.now();
                
                // 기존 타이머 정리
                if (this.timerInterval) {
                    clearInterval(this.timerInterval);
                }
                
                // 새 타이머 시작
                this.timerInterval = setInterval(() => this.updateTimer(), 1000);
                
                this.updateDisplay();
                this.updateStatus('새 게임을 시작합니다!');
                
                this.generatePuzzle();
                this.renderBoard();
            }

            generatePuzzle() {
                this.size = this.difficulties[this.currentDifficulty].size;
                this.solution = this.generateSolution();
                this.hints = this.generateHints(this.solution);
                this.playerBoard = Array(this.size).fill().map(() => Array(this.size).fill(0));
            }

            generateSolution() {
                // 간단한 패턴 생성 (실제로는 더 복잡한 알고리즘 사용 가능)
                const solution = Array(this.size).fill().map(() => Array(this.size).fill(0));
                
                // 다양한 패턴 생성
                const patterns = this.getPatterns();
                const pattern = patterns[Math.floor(Math.random() * patterns.length)];
                
                for (let i = 0; i < this.size; i++) {
                    for (let j = 0; j < this.size; j++) {
                        if (pattern[i] && pattern[i][j]) {
                            solution[i][j] = 1;
                        }
                    }
                }
                
                return solution;
            }

            getPatterns() {
                const patterns = {
                    5: [
                        [[1,1,0,1,1], [1,0,0,0,1], [1,1,1,1,1], [1,0,0,0,1], [1,0,0,0,1]],
                        [[0,1,1,1,0], [1,0,0,0,1], [1,0,0,0,1], [1,0,0,0,1], [0,1,1,1,0]],
                        [[1,1,1,0,0], [1,0,0,1,0], [1,1,1,0,0], [1,0,0,1,0], [1,1,1,0,0]]
                    ],
                    8: [
                        [[1,1,1,0,0,1,1,1], [1,0,0,1,1,0,0,1], [1,1,1,0,0,1,1,1], [0,0,0,1,1,0,0,0], 
                         [0,0,0,1,1,0,0,0], [1,1,1,0,0,1,1,1], [1,0,0,1,1,0,0,1], [1,1,1,0,0,1,1,1]]
                    ],
                    10: [
                        [[1,1,1,0,0,0,1,1,1,0], [1,0,0,1,0,1,0,0,1,0], [1,1,1,0,0,0,1,1,1,0], [0,0,0,1,0,1,0,0,0,0],
                         [0,0,0,0,0,0,0,0,0,0], [0,0,0,0,0,0,0,0,0,0], [1,1,1,0,0,0,1,1,1,0], [1,0,0,1,0,1,0,0,1,0],
                         [1,1,1,0,0,0,1,1,1,0], [0,0,0,0,0,0,0,0,0,0]]
                    ],
                    12: [
                        [[1,1,1,0,0,0,0,1,1,1,0,0], [1,0,0,1,0,0,1,0,0,1,0,0], [1,1,1,0,0,0,0,1,1,1,0,0], [0,0,0,1,0,0,1,0,0,0,0,0],
                         [0,0,0,0,0,0,0,0,0,0,0,0], [0,0,0,0,0,0,0,0,0,0,0,0], [0,0,0,0,0,0,0,0,0,0,0,0], [0,0,0,0,0,0,0,0,0,0,0,0],
                         [1,1,1,0,0,0,0,1,1,1,0,0], [1,0,0,1,0,0,1,0,0,1,0,0], [1,1,1,0,0,0,0,1,1,1,0,0], [0,0,0,0,0,0,0,0,0,0,0,0]]
                    ],
                    20: [
                        this.generateComplexPattern(20)
                    ],
                    25: [
                        this.generateComplexPattern(25)
                    ]
                };
                
                return patterns[this.size] || patterns[5];
            }

            generateComplexPattern(size) {
                const pattern = Array(size).fill().map(() => Array(size).fill(0));
                
                // 여러 가지 복잡한 패턴 생성
                const patternType = Math.floor(Math.random() * 4);
                
                switch (patternType) {
                    case 0: // 대각선 패턴
                        for (let i = 0; i < size; i++) {
                            for (let j = 0; j < size; j++) {
                                if ((i + j) % 3 === 0 || (i - j + size) % 4 === 0) {
                                    pattern[i][j] = 1;
                                }
                            }
                        }
                        break;
                        
                    case 1: // 체크보드 패턴
                        for (let i = 0; i < size; i++) {
                            for (let j = 0; j < size; j++) {
                                if ((i + j) % 2 === 0 && Math.random() < 0.6) {
                                    pattern[i][j] = 1;
                                }
                            }
                        }
                        break;
                        
                    case 2: // 원형 패턴
                        const center = Math.floor(size / 2);
                        for (let i = 0; i < size; i++) {
                            for (let j = 0; j < size; j++) {
                                const distance = Math.sqrt((i - center) ** 2 + (j - center) ** 2);
                                if (distance < size * 0.4 && Math.random() < 0.7) {
                                    pattern[i][j] = 1;
                                }
                            }
                        }
                        break;
                        
                    case 3: // 랜덤 블록 패턴
                        for (let i = 0; i < size; i += 3) {
                            for (let j = 0; j < size; j += 3) {
                                if (Math.random() < 0.4) {
                                    const blockSize = Math.min(3, size - i, size - j);
                                    for (let bi = 0; bi < blockSize; bi++) {
                                        for (let bj = 0; bj < blockSize; bj++) {
                                            if (Math.random() < 0.8) {
                                                pattern[i + bi][j + bj] = 1;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        break;
                }
                
                return pattern;
            }

            generateHints(solution) {
                const hints = { rows: [], cols: [] };
                
                // 행 힌트 생성
                for (let i = 0; i < this.size; i++) {
                    hints.rows[i] = this.getRowHint(solution[i]);
                }
                
                // 열 힌트 생성
                for (let j = 0; j < this.size; j++) {
                    const col = solution.map(row => row[j]);
                    hints.cols[j] = this.getRowHint(col);
                }
                
                return hints;
            }

            getRowHint(row) {
                const hint = [];
                let count = 0;
                
                for (let i = 0; i < row.length; i++) {
                    if (row[i] === 1) {
                        count++;
                    } else if (count > 0) {
                        hint.push(count);
                        count = 0;
                    }
                }
                
                if (count > 0) {
                    hint.push(count);
                }
                
                return hint.length > 0 ? hint : [0];
            }

            renderBoard() {
                const board = document.getElementById('gameBoard');
                board.innerHTML = '';
                
                // 보드 컨테이너 생성
                const boardContainer = document.createElement('div');
                boardContainer.className = 'board-container';
                
                // 크기에 따른 클래스 적용
                if (this.size >= 20) {
                    boardContainer.classList.add('extra-large');
                } else if (this.size >= 15) {
                    boardContainer.classList.add('large');
                }
                
                // 열 힌트
                const colHintsRow = document.createElement('div');
                colHintsRow.className = 'row-hints';
                
                // 빈 공간 (행 힌트와 정렬)
                const emptySpace = document.createElement('div');
                const isMobile = window.innerWidth <= 768;
                const isSmallMobile = window.innerWidth <= 480;
                
                if (isSmallMobile) {
                    emptySpace.style.width = '120px';
                    emptySpace.style.height = '18px';
                } else if (isMobile) {
                    emptySpace.style.width = '150px';
                    emptySpace.style.height = '20px';
                } else {
                    emptySpace.style.width = '200px';
                    emptySpace.style.height = '25px';
                }
                
                emptySpace.style.marginRight = '2px';
                colHintsRow.appendChild(emptySpace);
                
                // 열 힌트들
                for (let j = 0; j < this.size; j++) {
                    const colHints = document.createElement('div');
                    colHints.className = 'col-hints';
                    
                    this.hints.cols[j].forEach(hint => {
                        const hintCell = document.createElement('div');
                        hintCell.className = 'col-hint-cell';
                        hintCell.textContent = hint;
                        colHints.appendChild(hintCell);
                    });
                    
                    colHintsRow.appendChild(colHints);
                }
                
                boardContainer.appendChild(colHintsRow);
                
                // 게임 보드
                for (let i = 0; i < this.size; i++) {
                    const gameRow = document.createElement('div');
                    gameRow.className = 'game-row';
                    
                    // 행 힌트
                    const rowHints = document.createElement('div');
                    rowHints.className = 'row-hints';
                    
                    this.hints.rows[i].forEach(hint => {
                        const hintCell = document.createElement('div');
                        hintCell.className = 'hint-cell';
                        hintCell.textContent = hint;
                        rowHints.appendChild(hintCell);
                    });
                    
                    gameRow.appendChild(rowHints);
                    
                    // 게임 셀들
                    for (let j = 0; j < this.size; j++) {
                        const cell = document.createElement('div');
                        cell.className = 'game-cell';
                        cell.dataset.row = i;
                        cell.dataset.col = j;
                        
                        // 클릭 이벤트
                        cell.addEventListener('click', (e) => {
                            this.handleCellClick(i, j, 'left');
                        });
                        
                        cell.addEventListener('contextmenu', (e) => {
                            e.preventDefault();
                            this.handleCellClick(i, j, 'right');
                        });
                        
                        gameRow.appendChild(cell);
                    }
                    
                    boardContainer.appendChild(gameRow);
                }
                
                board.appendChild(boardContainer);
                this.updateProgress();
            }

            handleCellClick(row, col, button) {
                if (this.isGameComplete) return;
                
                const cell = document.querySelector(`[data-row="${row}"][data-col="${col}"]`);
                
                if (button === 'left') {
                    // 왼쪽 클릭: 칸 채우기/비우기
                    if (this.playerBoard[row][col] === 1) {
                        this.playerBoard[row][col] = 0;
                        cell.classList.remove('filled');
                    } else {
                        this.playerBoard[row][col] = 1;
                        cell.classList.add('filled');
                        cell.classList.remove('marked');
                    }
                } else if (button === 'right') {
                    // 오른쪽 클릭: 표시/해제
                    if (this.playerBoard[row][col] === 2) {
                        this.playerBoard[row][col] = 0;
                        cell.classList.remove('marked');
                    } else {
                        this.playerBoard[row][col] = 2;
                        cell.classList.add('marked');
                        cell.classList.remove('filled');
                    }
                }
                
                this.moves++;
                this.updateMoves();
                this.updateProgress();
                this.checkWin();
            }

            updateProgress() {
                let correctCells = 0;
                let totalCells = 0;
                
                for (let i = 0; i < this.size; i++) {
                    for (let j = 0; j < this.size; j++) {
                        if (this.solution[i][j] === 1) {
                            totalCells++;
                            if (this.playerBoard[i][j] === 1) {
                                correctCells++;
                            }
                        }
                    }
                }
                
                const progress = totalCells > 0 ? Math.round((correctCells / totalCells) * 100) : 0;
                document.getElementById('progress').textContent = progress + '%';
            }

            checkWin() {
                for (let i = 0; i < this.size; i++) {
                    for (let j = 0; j < this.size; j++) {
                        if (this.solution[i][j] === 1 && this.playerBoard[i][j] !== 1) {
                            return false;
                        }
                        if (this.solution[i][j] === 0 && this.playerBoard[i][j] === 1) {
                            return false;
                        }
                    }
                }
                
                this.isGameComplete = true;
                
                // 최고 기록 업데이트
                const elapsed = Math.floor((Date.now() - this.startTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (this.bestTime === '--:--' || elapsed < this.parseTime(this.bestTime)) {
                    this.bestTime = timeString;
                    localStorage.setItem('nonogramGameBestTime', this.bestTime);
                    document.getElementById('bestTime').textContent = this.bestTime;
                }
                
                this.updateStatus(`🎉 축하합니다! 퍼즐을 완성했습니다!<br>시간: ${timeString} | 이동: ${this.moves}회`, 'success-message');
                
                if (this.timerInterval) {
                    clearInterval(this.timerInterval);
                }
                
                return true;
            }

            parseTime(timeString) {
                if (timeString === '--:--') return Infinity;
                const [minutes, seconds] = timeString.split(':').map(Number);
                return minutes * 60 + seconds;
            }

            showHint() {
                if (this.isGameComplete) return;
                
                // 빈 칸 중에서 해답이 1인 칸을 찾아서 힌트 제공
                const emptyCells = [];
                for (let i = 0; i < this.size; i++) {
                    for (let j = 0; j < this.size; j++) {
                        if (this.playerBoard[i][j] === 0 && this.solution[i][j] === 1) {
                            emptyCells.push([i, j]);
                        }
                    }
                }
                
                if (emptyCells.length > 0) {
                    const randomCell = emptyCells[Math.floor(Math.random() * emptyCells.length)];
                    const [row, col] = randomCell;
                    
                    // 셀을 잠깐 하이라이트
                    const cell = document.querySelector(`[data-row="${row}"][data-col="${col}"]`);
                    cell.style.backgroundColor = '#ffeb3b';
                    cell.style.animation = 'pulse 1s';
                    
                    setTimeout(() => {
                        cell.style.backgroundColor = '';
                        cell.style.animation = '';
                    }, 1000);
                    
                    this.updateStatus(`힌트: (${row + 1}, ${col + 1}) 위치를 확인해보세요!`);
                } else {
                    this.updateStatus('더 이상 힌트를 제공할 수 없습니다.');
                }
            }

            checkSolution() {
                if (this.isGameComplete) return;
                
                let correct = 0;
                let incorrect = 0;
                
                for (let i = 0; i < this.size; i++) {
                    for (let j = 0; j < this.size; j++) {
                        const cell = document.querySelector(`[data-row="${i}"][data-col="${j}"]`);
                        
                        if (this.playerBoard[i][j] === 1) {
                            if (this.solution[i][j] === 1) {
                                correct++;
                                cell.style.borderColor = '#28a745';
                            } else {
                                incorrect++;
                                cell.style.borderColor = '#dc3545';
                            }
                        }
                    }
                }
                
                if (incorrect > 0) {
                    this.updateStatus(`틀린 칸이 ${incorrect}개 있습니다.`, 'error-message');
                } else if (correct > 0) {
                    this.updateStatus(`맞는 칸이 ${correct}개 있습니다!`, 'success-message');
                } else {
                    this.updateStatus('아직 채워진 칸이 없습니다.');
                }
                
                // 3초 후 테두리 색상 초기화
                setTimeout(() => {
                    document.querySelectorAll('.game-cell').forEach(cell => {
                        cell.style.borderColor = '';
                    });
                }, 3000);
            }

            showSolution() {
                if (this.isGameComplete) return;
                
                for (let i = 0; i < this.size; i++) {
                    for (let j = 0; j < this.size; j++) {
                        const cell = document.querySelector(`[data-row="${i}"][data-col="${j}"]`);
                        
                        if (this.solution[i][j] === 1) {
                            this.playerBoard[i][j] = 1;
                            cell.classList.add('filled');
                            cell.classList.remove('marked');
                        } else {
                            this.playerBoard[i][j] = 0;
                            cell.classList.remove('filled', 'marked');
                        }
                    }
                }
                
                this.isGameComplete = true;
                this.updateStatus('해답을 표시했습니다.', 'success-message');
                this.updateProgress();
                
                if (this.timerInterval) {
                    clearInterval(this.timerInterval);
                }
            }

            updateTimer() {
                if (!this.startTime) return;
                
                const elapsed = Math.floor((Date.now() - this.startTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                
                document.getElementById('timer').textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            updateMoves() {
                document.getElementById('moves').textContent = this.moves;
            }

            updateDisplay() {
                document.getElementById('moves').textContent = this.moves;
                document.getElementById('progress').textContent = '0%';
                document.getElementById('timer').textContent = '00:00';
                document.getElementById('bestTime').textContent = this.bestTime;
            }

            updateStatus(message, type = '') {
                const status = document.getElementById('gameMessage');
                status.innerHTML = message;
                status.className = `game-message ${type}`;
                status.style.display = 'block';
                
                if (type !== 'success-message' && type !== 'error-message') {
                    setTimeout(() => {
                        status.style.display = 'none';
                    }, 3000);
                }
            }
        }

        // CSS 애니메이션 추가
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
            }
        `;
        document.head.appendChild(style);

        // 게임 시작
        document.addEventListener('DOMContentLoaded', () => {
            new NonogramGame();
        });

        // 드롭다운 메뉴 토글
        document.addEventListener('DOMContentLoaded', () => {
            const dropdown = document.querySelector('.dropdown');
            const dropdownContent = document.querySelector('.dropdown-content');
            
            dropdown.addEventListener('click', (e) => {
                e.preventDefault();
                dropdown.classList.toggle('active');
            });
            
            // 외부 클릭 시 드롭다운 닫기
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
