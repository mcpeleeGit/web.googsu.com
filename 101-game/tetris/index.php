<?php
session_start();

// 게임 초기화
if (!isset($_SESSION['tetris_game'])) {
    $_SESSION['tetris_game'] = [
        'board' => array_fill(0, 20, array_fill(0, 10, 0)),
        'current_piece' => null,
        'next_piece' => null,
        'score' => 0,
        'level' => 1,
        'lines_cleared' => 0,
        'game_over' => false,
        'paused' => false
    ];
}

// 점수 저장 처리
if (isset($_POST['save_score']) && isset($_POST['player_name'])) {
    $player_name = htmlspecialchars($_POST['player_name']);
    $score = (int)$_POST['score'];
    
    if (!isset($_SESSION['high_scores'])) {
        $_SESSION['high_scores'] = [];
    }
    
    $_SESSION['high_scores'][] = [
        'name' => $player_name,
        'score' => $score,
        'date' => date('Y-m-d H:i:s')
    ];
    
    // 점수 정렬 (높은 순)
    usort($_SESSION['high_scores'], function($a, $b) {
        return $b['score'] - $a['score'];
    });
    
    // 상위 10개만 유지
    $_SESSION['high_scores'] = array_slice($_SESSION['high_scores'], 0, 10);
    
    // 게임 재시작
    unset($_SESSION['tetris_game']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// 게임 재시작
if (isset($_POST['restart'])) {
    unset($_SESSION['tetris_game']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>테트리스 게임</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .game-container {
            display: flex;
            gap: 30px;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .game-board {
            border: 3px solid #333;
            background: #000;
            position: relative;
        }
        
        .game-grid {
            display: grid;
            grid-template-columns: repeat(10, 30px);
            grid-template-rows: repeat(20, 30px);
            gap: 1px;
            background: #333;
            padding: 1px;
        }
        
        .cell {
            width: 30px;
            height: 30px;
            background: #000;
            border: 1px solid #333;
            transition: all 0.1s ease;
        }
        
        .cell.filled {
            border: 1px solid #fff;
            box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.3);
        }
        
        .cell.piece-1 { background: #00f; } /* I */
        .cell.piece-2 { background: #f00; } /* O */
        .cell.piece-3 { background: #0f0; } /* T */
        .cell.piece-4 { background: #ff0; } /* S */
        .cell.piece-5 { background: #f0f; } /* Z */
        .cell.piece-6 { background: #0ff; } /* J */
        .cell.piece-7 { background: #f80; } /* L */
        
        .game-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-width: 200px;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            text-align: center;
        }
        
        .info-box h3 {
            color: #495057;
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        
        .score {
            font-size: 2em;
            font-weight: bold;
            color: #1971c2;
        }
        
        .level {
            font-size: 1.5em;
            color: #28a745;
        }
        
        .lines {
            font-size: 1.3em;
            color: #dc3545;
        }
        
        .next-piece {
            display: grid;
            grid-template-columns: repeat(4, 25px);
            grid-template-rows: repeat(4, 25px);
            gap: 1px;
            margin: 0 auto;
            background: #333;
            padding: 1px;
            border-radius: 5px;
        }
        
        .controls {
            background: #e9ecef;
            padding: 15px;
            border-radius: 10px;
            font-size: 0.9em;
            line-height: 1.6;
        }
        
        .controls h4 {
            color: #495057;
            margin-bottom: 10px;
        }
        
        .controls ul {
            list-style: none;
            text-align: left;
        }
        
        .controls li {
            margin-bottom: 5px;
            color: #6c757d;
        }
        
        .game-over-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        
        .modal-content h2 {
            color: #dc3545;
            margin-bottom: 20px;
            font-size: 2em;
        }
        
        .modal-content p {
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #495057;
        }
        
        .score-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            font-size: 1.1em;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #545b62;
            transform: translateY(-2px);
        }
        
        .high-scores {
            background: #fff3cd;
            border: 2px solid #ffeaa7;
            padding: 20px;
            border-radius: 10px;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .high-scores h3 {
            color: #856404;
            margin-bottom: 15px;
        }
        
        .score-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ffeaa7;
        }
        
        .score-item:last-child {
            border-bottom: none;
        }
        
        .score-name {
            font-weight: bold;
            color: #856404;
        }
        
        .score-value {
            color: #856404;
        }
        
        .score-date {
            font-size: 0.8em;
            color: #a17e02;
        }
        
        @media (max-width: 768px) {
            .game-container {
                flex-direction: column;
                padding: 20px;
            }
            
            .game-grid {
                grid-template-columns: repeat(10, 25px);
                grid-template-rows: repeat(20, 25px);
            }
            
            .cell {
                width: 25px;
                height: 25px;
            }
            
            .next-piece {
                grid-template-columns: repeat(4, 20px);
                grid-template-rows: repeat(4, 20px);
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div class="game-board">
            <div class="game-grid" id="gameGrid"></div>
        </div>
        
        <div class="game-info">
            <div class="info-box">
                <h3>점수</h3>
                <div class="score" id="score">0</div>
            </div>
            
            <div class="info-box">
                <h3>레벨</h3>
                <div class="level" id="level">1</div>
            </div>
            
            <div class="info-box">
                <h3>라인</h3>
                <div class="lines" id="lines">0</div>
            </div>
            
            <div class="info-box">
                <h3>다음 블록</h3>
                <div class="next-piece" id="nextPiece"></div>
            </div>
            
            <div class="controls">
                <h4>조작법</h4>
                <ul>
                    <li>← → : 좌우 이동</li>
                    <li>↓ : 빠른 하강</li>
                    <li>↑ : 블록 회전</li>
                    <li>스페이스 : 즉시 하강</li>
                    <li>P : 일시정지</li>
                </ul>
            </div>
            
            <div class="high-scores">
                <h3>최고 점수</h3>
                <div id="highScoresList">
                    <?php if (isset($_SESSION['high_scores']) && !empty($_SESSION['high_scores'])): ?>
                        <?php foreach (array_slice($_SESSION['high_scores'], 0, 5) as $score): ?>
                            <div class="score-item">
                                <span class="score-name"><?= $score['name'] ?></span>
                                <span class="score-value"><?= number_format($score['score']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>아직 기록이 없습니다</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <form method="post" style="margin-top: 20px;">
                <button type="submit" name="restart" class="btn btn-secondary">게임 재시작</button>
            </form>
        </div>
    </div>
    
    <div class="game-over-modal" id="gameOverModal">
        <div class="modal-content">
            <h2>게임 오버!</h2>
            <p>최종 점수: <span id="finalScore">0</span></p>
            <form method="post" id="scoreForm">
                <input type="text" name="player_name" class="score-input" placeholder="플레이어 이름" maxlength="20" required>
                <input type="hidden" name="score" id="hiddenScore" value="0">
                <input type="hidden" name="save_score" value="1">
                <button type="submit" class="btn btn-primary">점수 저장</button>
            </form>
        </div>
    </div>

    <script>
        class Tetris {
            constructor() {
                this.boardWidth = 10;
                this.boardHeight = 20;
                this.board = Array(this.boardHeight).fill().map(() => Array(this.boardWidth).fill(0));
                this.currentPiece = null;
                this.nextPiece = null;
                this.score = 0;
                this.level = 1;
                this.linesCleared = 0;
                this.gameOver = false;
                this.paused = false;
                this.gameLoop = null;
                this.dropTime = 0;
                this.dropInterval = 1000;
                
                this.pieces = [
                    // I
                    [[1, 1, 1, 1]],
                    // O
                    [[1, 1], [1, 1]],
                    // T
                    [[0, 1, 0], [1, 1, 1]],
                    // S
                    [[0, 1, 1], [1, 1, 0]],
                    // Z
                    [[1, 1, 0], [0, 1, 1]],
                    // J
                    [[1, 0, 0], [1, 1, 1]],
                    // L
                    [[0, 0, 1], [1, 1, 1]]
                ];
                
                this.init();
            }
            
            init() {
                this.createNewPiece();
                this.updateDisplay();
                this.startGameLoop();
                this.setupControls();
            }
            
            createNewPiece() {
                if (!this.nextPiece) {
                    this.nextPiece = this.getRandomPiece();
                }
                
                this.currentPiece = {
                    shape: this.nextPiece,
                    x: Math.floor(this.boardWidth / 2) - Math.floor(this.nextPiece[0].length / 2),
                    y: 0
                };
                
                this.nextPiece = this.getRandomPiece();
                this.updateNextPieceDisplay();
                
                if (this.isCollision()) {
                    this.gameOver = true;
                    this.showGameOver();
                }
            }
            
            getRandomPiece() {
                return this.pieces[Math.floor(Math.random() * this.pieces.length)];
            }
            
            isCollision() {
                for (let y = 0; y < this.currentPiece.shape.length; y++) {
                    for (let x = 0; x < this.currentPiece.shape[y].length; x++) {
                        if (this.currentPiece.shape[y][x]) {
                            const boardX = this.currentPiece.x + x;
                            const boardY = this.currentPiece.y + y;
                            
                            if (boardX < 0 || boardX >= this.boardWidth || 
                                boardY >= this.boardHeight ||
                                (boardY >= 0 && this.board[boardY][boardX])) {
                                return true;
                            }
                        }
                    }
                }
                return false;
            }
            
            placePiece() {
                for (let y = 0; y < this.currentPiece.shape.length; y++) {
                    for (let x = 0; x < this.currentPiece.shape[y].length; x++) {
                        if (this.currentPiece.shape[y][x]) {
                            const boardX = this.currentPiece.x + x;
                            const boardY = this.currentPiece.y + y;
                            if (boardY >= 0) {
                                this.board[boardY][boardX] = this.getPieceType() + 1;
                            }
                        }
                    }
                }
                
                this.clearLines();
                this.createNewPiece();
            }
            
            getPieceType() {
                for (let i = 0; i < this.pieces.length; i++) {
                    if (JSON.stringify(this.pieces[i]) === JSON.stringify(this.currentPiece.shape)) {
                        return i;
                    }
                }
                return 0;
            }
            
            clearLines() {
                let linesCleared = 0;
                
                for (let y = this.boardHeight - 1; y >= 0; y--) {
                    if (this.board[y].every(cell => cell !== 0)) {
                        this.board.splice(y, 1);
                        this.board.unshift(Array(this.boardWidth).fill(0));
                        linesCleared++;
                        y++;
                    }
                }
                
                if (linesCleared > 0) {
                    this.linesCleared += linesCleared;
                    this.score += linesCleared * 100 * this.level;
                    this.level = Math.floor(this.linesCleared / 10) + 1;
                    this.dropInterval = Math.max(100, 1000 - (this.level - 1) * 100);
                    this.updateDisplay();
                }
            }
            
            movePiece(dx, dy) {
                this.currentPiece.x += dx;
                this.currentPiece.y += dy;
                
                if (this.isCollision()) {
                    this.currentPiece.x -= dx;
                    this.currentPiece.y -= dy;
                    
                    if (dy > 0) {
                        this.placePiece();
                    }
                    return false;
                }
                
                this.updateDisplay();
                return true;
            }
            
            rotatePiece() {
                const rotated = this.currentPiece.shape[0].map((_, i) => 
                    this.currentPiece.shape.map(row => row[i]).reverse()
                );
                
                const originalShape = this.currentPiece.shape;
                this.currentPiece.shape = rotated;
                
                if (this.isCollision()) {
                    this.currentPiece.shape = originalShape;
                } else {
                    this.updateDisplay();
                }
            }
            
            dropPiece() {
                while (this.movePiece(0, 1)) {
                    this.score += 2;
                }
                this.updateDisplay();
            }
            
            updateDisplay() {
                // 게임 보드 업데이트
                const gameGrid = document.getElementById('gameGrid');
                gameGrid.innerHTML = '';
                
                // 보드 그리기
                for (let y = 0; y < this.boardHeight; y++) {
                    for (let x = 0; x < this.boardWidth; x++) {
                        const cell = document.createElement('div');
                        cell.className = 'cell';
                        
                        if (this.board[y][x] !== 0) {
                            cell.classList.add('filled', `piece-${this.board[y][x]}`);
                        }
                        
                        gameGrid.appendChild(cell);
                    }
                }
                
                // 현재 조각 그리기
                if (this.currentPiece) {
                    for (let y = 0; y < this.currentPiece.shape.length; y++) {
                        for (let x = 0; x < this.currentPiece.shape[y].length; x++) {
                            if (this.currentPiece.shape[y][x]) {
                                const boardX = this.currentPiece.x + x;
                                const boardY = this.currentPiece.y + y;
                                
                                if (boardY >= 0 && boardY < this.boardHeight && 
                                    boardX >= 0 && boardX < this.boardWidth) {
                                    const cellIndex = boardY * this.boardWidth + boardX;
                                    const cell = gameGrid.children[cellIndex];
                                    cell.classList.add('filled', `piece-${this.getPieceType() + 1}`);
                                }
                            }
                        }
                    }
                }
                
                // 점수 정보 업데이트
                document.getElementById('score').textContent = this.score.toLocaleString();
                document.getElementById('level').textContent = this.level;
                document.getElementById('lines').textContent = this.linesCleared;
            }
            
            updateNextPieceDisplay() {
                const nextPieceDiv = document.getElementById('nextPiece');
                nextPieceDiv.innerHTML = '';
                
                for (let y = 0; y < 4; y++) {
                    for (let x = 0; x < 4; x++) {
                        const cell = document.createElement('div');
                        cell.className = 'cell';
                        
                        if (y < this.nextPiece.length && x < this.nextPiece[y].length && this.nextPiece[y][x]) {
                            cell.classList.add('filled', `piece-${this.pieces.indexOf(this.nextPiece) + 1}`);
                        }
                        
                        nextPieceDiv.appendChild(cell);
                    }
                }
            }
            
            startGameLoop() {
                this.gameLoop = setInterval(() => {
                    if (!this.paused && !this.gameOver) {
                        this.dropTime += 16;
                        
                        if (this.dropTime >= this.dropInterval) {
                            this.movePiece(0, 1);
                            this.dropTime = 0;
                        }
                    }
                }, 16);
            }
            
            setupControls() {
                document.addEventListener('keydown', (e) => {
                    if (this.gameOver) return;
                    
                    switch (e.key) {
                        case 'ArrowLeft':
                            e.preventDefault();
                            this.movePiece(-1, 0);
                            break;
                        case 'ArrowRight':
                            e.preventDefault();
                            this.movePiece(1, 0);
                            break;
                        case 'ArrowDown':
                            e.preventDefault();
                            this.movePiece(0, 1);
                            this.score += 1;
                            break;
                        case 'ArrowUp':
                            e.preventDefault();
                            this.rotatePiece();
                            break;
                        case ' ':
                            e.preventDefault();
                            this.dropPiece();
                            break;
                        case 'p':
                        case 'P':
                            e.preventDefault();
                            this.togglePause();
                            break;
                    }
                });
            }
            
            togglePause() {
                this.paused = !this.paused;
                if (this.paused) {
                    document.title = '테트리스 - 일시정지';
                } else {
                    document.title = '테트리스 게임';
                }
            }
            
            showGameOver() {
                clearInterval(this.gameLoop);
                document.getElementById('finalScore').textContent = this.score.toLocaleString();
                document.getElementById('hiddenScore').value = this.score;
                document.getElementById('gameOverModal').style.display = 'flex';
            }
        }
        
        // 게임 시작
        document.addEventListener('DOMContentLoaded', () => {
            new Tetris();
        });
    </script>
</body>
</html>
