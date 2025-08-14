<?php
session_start();

// 게임 초기화
if (!isset($_SESSION['multi_tetris_game'])) {
    $_SESSION['multi_tetris_game'] = [
        'players' => [],
        'board' => array_fill(0, 20, array_fill(0, 10, 0)),
        'game_over' => false,
        'start_time' => time(),
        'max_players' => 2
    ];
}

// 새 플레이어 추가
if (isset($_POST['join_game'])) {
    $player_name = htmlspecialchars($_POST['player_name']);
    $player_id = uniqid();
    
    if (count($_SESSION['multi_tetris_game']['players']) < $_SESSION['multi_tetris_game']['max_players']) {
        $_SESSION['multi_tetris_game']['players'][$player_id] = [
            'name' => $player_name,
            'score' => 0,
            'lines_cleared' => 0,
            'current_piece' => null,
            'next_piece' => null,
            'last_activity' => time(),
            'color' => count($_SESSION['multi_tetris_game']['players']) == 0 ? 1 : 2
        ];
        
        // 첫 번째 플레이어가 조인하면 게임 시작
        if (count($_SESSION['multi_tetris_game']['players']) == 1) {
            $_SESSION['multi_tetris_game']['start_time'] = time();
        }
    }
}

// 게임 재시작
if (isset($_POST['restart'])) {
    unset($_SESSION['multi_tetris_game']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// 점수 저장 처리
if (isset($_POST['save_score'])) {
    if (!isset($_SESSION['multi_tetris_high_scores'])) {
        $_SESSION['multi_tetris_high_scores'] = [];
    }
    
    foreach ($_SESSION['multi_tetris_game']['players'] as $player) {
        $_SESSION['multi_tetris_high_scores'][] = [
            'name' => $player['name'],
            'score' => $player['score'],
            'lines_cleared' => $player['lines_cleared'],
            'date' => date('Y-m-d H:i:s')
        ];
    }
    
    // 점수 정렬 (높은 순)
    usort($_SESSION['multi_tetris_high_scores'], function($a, $b) {
        return $b['score'] - $a['score'];
    });
    
    // 상위 10개만 유지
    $_SESSION['multi_tetris_high_scores'] = array_slice($_SESSION['multi_tetris_high_scores'], 0, 10);
    
    // 게임 재시작
    unset($_SESSION['multi_tetris_game']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$game = $_SESSION['multi_tetris_game'];
$player_count = count($game['players']);
$can_join = $player_count < $game['max_players'];
$game_started = $player_count > 0;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>멀티플레이어 테트리스</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .game-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }
        
        .game-header {
            background: linear-gradient(135deg, #1971c2 0%, #1864ab 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .game-title {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .game-subtitle {
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .join-section {
            padding: 40px;
            text-align: center;
            background: #f8f9fa;
        }
        
        .join-form {
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .player-input {
            padding: 15px 20px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            font-size: 1.1em;
            width: 250px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        
        .player-input:focus {
            border-color: #1971c2;
        }
        
        .join-button {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .join-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .join-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .game-area {
            display: flex;
            gap: 30px;
            padding: 40px;
        }
        
        .game-board-section {
            flex: 1;
            text-align: center;
        }
        
        .game-board {
            border: 3px solid #333;
            background: #000;
            margin: 0 auto;
            position: relative;
        }
        
        .next-pieces-section {
            width: 200px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .next-piece-container {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }
        
        .next-piece-container h4 {
            color: #495057;
            margin-bottom: 15px;
            font-size: 1.1em;
        }
        
        .game-grid {
            display: grid;
            grid-template-columns: repeat(20, 25px); /* 15px에서 25px로 변경 */
            grid-template-rows: repeat(30, 25px); /* 15px에서 25px로 변경 */
            gap: 1px;
            background: #333;
            border: 3px solid #333;
            margin: 0 auto;
        }
        
        .cell {
            width: 25px; /* 15px에서 25px로 변경 */
            height: 25px; /* 15px에서 25px로 변경 */
            background: #000;
            border: 1px solid #333;
            transition: all 0.1s ease;
        }
        
        .cell.filled {
            border: 1px solid #fff;
            box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.3);
        }
        
        /* 플레이어별 색상 - 매우 강력한 우선순위 */
        .game-grid .cell.filled.player-1 { 
            background-color: #1971c2 !important; 
            border-color: #1864ab !important;
            background: #1971c2 !important;
        }
        .game-grid .cell.filled.player-2 { 
            background-color: #dc3545 !important; 
            border-color: #c82333 !important;
            background: #dc3545 !important;
        }
        
        .game-grid .cell.current-piece.player-1 {
            background-color: #1971c2 !important;
            border-color: #1864ab !important;
            background: #1971c2 !important;
        }
        
        .game-grid .cell.current-piece.player-2 {
            background-color: #dc3545 !important;
            border-color: #c82333 !important;
            background: #dc3545 !important;
        }
        
        /* 추가 강력한 선택자 */
        .game-grid .cell[class*="player-1"] {
            background-color: #1971c2 !important;
        }
        
        .game-grid .cell[class*="player-2"] {
            background-color: #dc3545 !important;
        }
        
        .cell.current-piece {
            opacity: 0.8;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        
        .players-info {
            width: 300px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .player-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }
        
        .player-card.active {
            border-color: #28a745;
            background: #d4edda;
        }
        
        .player-name {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #495057;
        }
        
        .player-score {
            font-size: 1.8em;
            color: #1971c2;
            margin-bottom: 5px;
        }
        
        .player-lines {
            color: #6c757d;
            font-size: 0.9em;
        }
        
        .next-piece {
            display: grid;
            grid-template-columns: repeat(4, 15px);
            grid-template-rows: repeat(4, 15px);
            gap: 1px;
            margin: 15px auto;
            background: #333;
            padding: 10px;
            border-radius: 8px;
            border: 2px solid #666;
        }
        
        .next-piece .cell {
            width: 15px;
            height: 15px;
            background: #000;
            border: 1px solid #333;
        }
        
        .next-piece .cell.filled.player-1 {
            background-color: #1971c2 !important;
            border-color: #1864ab !important;
        }
        
        .next-piece .cell.filled.player-2 {
            background-color: #dc3545 !important;
            border-color: #c82333 !important;
        }
        
        .controls {
            background: #e9ecef;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
        }
        
        .controls h4 {
            color: #495057;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .control-group {
            margin-bottom: 15px;
        }
        
        .control-group h5 {
            color: #6c757d;
            margin-bottom: 8px;
            font-size: 0.9em;
        }
        
        .control-list {
            list-style: none;
            font-size: 0.8em;
            color: #6c757d;
            line-height: 1.4;
        }
        
        .game-status {
            background: #fff3cd;
            border: 2px solid #ffeaa7;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
            text-align: center;
        }
        
        .game-status h3 {
            color: #856404;
            margin-bottom: 10px;
        }
        
        .status-text {
            color: #856404;
            font-size: 1.1em;
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
            max-width: 500px;
            width: 90%;
        }
        
        .modal-content h2 {
            color: #1971c2;
            margin-bottom: 20px;
            font-size: 2em;
        }
        
        .final-scores {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .final-score-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .final-score-item:last-child {
            border-bottom: none;
        }
        
        .winner {
            background: #d4edda;
            border-radius: 5px;
            padding: 5px 10px;
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
            border-radius: 15px;
            margin-top: 20px;
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
        
        .score-lines {
            color: #a17e02;
            font-size: 0.9em;
        }
        
        @media (max-width: 768px) {
            .game-area {
                flex-direction: column;
                padding: 20px;
            }
            
            .players-info {
                width: 100%;
            }
            
            .game-grid {
                grid-template-columns: repeat(10, 25px);
                grid-template-rows: repeat(20, 25px);
            }
            
            .cell {
                width: 25px;
                height: 25px;
            }
            
            .join-form {
                flex-direction: column;
            }
            
            .player-input {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div class="game-header">
            <h1 class="game-title">🎮 멀티플레이어 테트리스</h1>
            <p class="game-subtitle">최대 2명이 함께 플레이하는 경쟁 테트리스!</p>
        </div>
        
        <?php if (!$game_started): ?>
            <div class="join-section">
                <h2>게임 참가하기</h2>
                <p>플레이어 이름을 입력하고 게임에 참가하세요!</p>
                
                <form method="post" class="join-form">
                    <input type="text" name="player_name" class="player-input" placeholder="플레이어 이름" maxlength="20" required>
                    <button type="submit" name="join_game" class="join-button">게임 참가</button>
                </form>
                
                <p style="color: #6c757d; margin-top: 20px;">
                    현재 플레이어: <?= $player_count ?>/<?= $game['max_players'] ?>
                </p>
            </div>
        <?php else: ?>
            <div class="game-area">
                <div class="game-board-section">
                    <div class="game-board">
                        <div class="game-grid" id="gameGrid"></div>
                    </div>
                    
                    <div class="controls">
                        <h4>🎮 조작법</h4>
                        <div class="control-group">
                            <h5>플레이어 1 (파란색)</h5>
                            <ul class="control-list">
                                <li>WASD: 이동 및 회전</li>
                                <li>Q: 즉시 하강</li>
                            </ul>
                        </div>
                        <div class="control-group">
                            <h5>플레이어 2 (빨간색)</h5>
                            <ul class="control-list">
                                <li>방향키: 이동 및 회전</li>
                                <li>스페이스: 즉시 하강</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="next-pieces-section">
                    <div class="next-piece-container">
                        <h4>플레이어 1</h4>
                        <div class="next-piece" id="next-1"></div>
                    </div>
                    <div class="next-piece-container">
                        <h4>플레이어 2</h4>
                        <div class="next-piece" id="next-2"></div>
                    </div>
                </div>
                
                <div class="players-info">
                    <?php foreach ($game['players'] as $player_id => $player): ?>
                        <div class="player-card" id="player-<?= $player_id ?>">
                            <div class="player-name"><?= $player['name'] ?></div>
                            <div class="player-score" id="score-<?= $player_id ?>"><?= number_format($player['score']) ?></div>
                            <div class="player-lines">라인: <?= $player['lines_cleared'] ?></div>
                            
                            <?php if (isset($player['next_piece'])): ?>
                                <div class="next-piece" id="next-<?= $player_id ?>"></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="game-status">
                        <h3>게임 상태</h3>
                        <div class="status-text" id="gameStatus">
                            <?php if ($player_count < $game['max_players']): ?>
                                다른 플레이어를 기다리는 중... (<?= $player_count ?>/<?= $game['max_players'] ?>)
                            <?php else: ?>
                                게임 진행 중! 🚀
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <form method="post" style="margin-top: 20px;">
                        <button type="submit" name="restart" class="btn btn-secondary">게임 재시작</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['multi_tetris_high_scores']) && !empty($_SESSION['multi_tetris_high_scores'])): ?>
            <div class="high-scores" style="margin: 40px; padding: 20px;">
                <h3>🏆 최고 점수</h3>
                <?php foreach (array_slice($_SESSION['multi_tetris_high_scores'], 0, 5) as $score): ?>
                    <div class="score-item">
                        <span class="score-name"><?= $score['name'] ?></span>
                        <span class="score-value"><?= number_format($score['score']) ?></span>
                        <span class="score-lines">(<?= $score['lines_cleared'] ?>라인)</span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="game-over-modal" id="gameOverModal">
        <div class="modal-content">
            <h2>🎉 게임 종료!</h2>
            <div class="final-scores" id="finalScores"></div>
            <form method="post" id="scoreForm">
                <button type="submit" name="save_score" class="btn btn-primary">점수 저장</button>
                <button type="submit" name="restart" class="btn btn-secondary">새 게임 시작</button>
            </form>
        </div>
    </div>

    <script>
        class MultiTetris {
            constructor() {
                this.boardWidth = 20; // 10에서 20으로 변경
                this.boardHeight = 30; // 40에서 30으로 변경
                this.board = Array(this.boardHeight).fill().map(() => Array(this.boardWidth).fill(0));
                this.players = <?= json_encode($game['players']) ?>;
                this.gameOver = false;
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
                console.log('게임 초기화 시작...');
                console.log('플레이어 데이터:', this.players);
                
                this.initializePlayers();
                this.setupControls(); // 플레이어 초기화 직후에 컨트롤 설정
                this.updateDisplay();
                this.startGameLoop();
                
                console.log('게임 초기화 완료');
            }
            
            initializePlayers() {
                console.log('플레이어 초기화 시작...');
                
                Object.keys(this.players).forEach(playerId => {
                    console.log(`플레이어 ${playerId} 초기화 중...`);
                    this.players[playerId].currentPiece = this.createNewPiece(playerId);
                    this.players[playerId].nextPiece = this.getRandomPiece();
                    console.log(`플레이어 ${playerId} 초기화 완료:`, this.players[playerId]);
                });
                
                console.log('모든 플레이어 초기화 완료');
            }
            
            createNewPiece(playerId) {
                console.log(`플레이어 ${playerId}를 위한 새 조각 생성`);
                
                if (!this.players[playerId].nextPiece) {
                    this.players[playerId].nextPiece = this.getRandomPiece();
                }
                
                const piece = {
                    shape: this.players[playerId].nextPiece,
                    x: Math.floor(this.boardWidth / 2) - Math.floor(this.players[playerId].nextPiece[0].length / 2),
                    y: 0,
                    playerId: playerId
                };
                
                console.log('생성된 조각:', piece);
                console.log('조각의 플레이어 ID:', piece.playerId);
                
                this.players[playerId].nextPiece = this.getRandomPiece();
                this.updateNextPieceDisplay(playerId);
                
                if (this.isCollision(piece)) {
                    this.gameOver = true;
                    this.showGameOver();
                }
                
                return piece;
            }
            
            getRandomPiece() {
                return this.pieces[Math.floor(Math.random() * this.pieces.length)];
            }
            
            isCollision(piece) {
                for (let y = 0; y < piece.shape.length; y++) {
                    for (let x = 0; x < piece.shape[y].length; x++) {
                        if (piece.shape[y][x]) {
                            const boardX = piece.x + x;
                            const boardY = piece.y + y;
                            
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
            
            placePiece(piece) {
                console.log('조각 배치 중:', piece);
                console.log('플레이어 ID:', piece.playerId);
                
                for (let y = 0; y < piece.shape.length; y++) {
                    for (let x = 0; x < piece.shape[y].length; x++) {
                        if (piece.shape[y][x]) {
                            const boardX = piece.x + x;
                            const boardY = piece.y + y;
                            if (boardY >= 0) {
                                this.board[boardY][boardX] = piece.playerId;
                                console.log(`보드 [${boardY}][${boardX}]에 플레이어 ${piece.playerId} 저장`);
                            }
                        }
                    }
                }
                
                this.clearLines();
                this.players[piece.playerId].currentPiece = this.createNewPiece(piece.playerId);
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
                    // 라인을 없앤 플레이어에게 점수 부여
                    const activePlayer = this.getActivePlayer();
                    if (activePlayer) {
                        this.players[activePlayer].lines_cleared += linesCleared;
                        this.players[activePlayer].score += linesCleared * 100;
                        this.updatePlayerDisplay(activePlayer);
                    }
                }
            }
            
            getActivePlayer() {
                // 현재 활성 플레이어 (가장 최근에 조작한 플레이어)
                let activePlayer = null;
                let lastActivity = 0;
                
                Object.keys(this.players).forEach(playerId => {
                    if (this.players[playerId].last_activity > lastActivity) {
                        lastActivity = this.players[playerId].last_activity;
                        activePlayer = playerId;
                    }
                });
                
                return activePlayer;
            }
            
            movePiece(playerId, dx, dy) {
                const player = this.players[playerId];
                if (!player.currentPiece) return false;
                
                player.currentPiece.x += dx;
                player.currentPiece.y += dy;
                
                if (this.isCollision(player.currentPiece)) {
                    player.currentPiece.x -= dx;
                    player.currentPiece.y -= dy;
                    
                    if (dy > 0) {
                        this.placePiece(player.currentPiece);
                    }
                    return false;
                }
                
                player.last_activity = Date.now();
                this.updateDisplay();
                return true;
            }
            
            rotatePiece(playerId) {
                const player = this.players[playerId];
                if (!player.currentPiece) return;
                
                const rotated = player.currentPiece.shape[0].map((_, i) => 
                    player.currentPiece.shape.map(row => row[i]).reverse()
                );
                
                const originalShape = player.currentPiece.shape;
                player.currentPiece.shape = rotated;
                
                if (this.isCollision(player.currentPiece)) {
                    player.currentPiece.shape = originalShape;
                } else {
                    player.last_activity = Date.now();
                    this.updateDisplay();
                }
            }
            
            dropPiece(playerId) {
                const player = this.players[playerId];
                if (!player.currentPiece) return;
                
                while (this.movePiece(playerId, 0, 1)) {
                    // 빠른 하강 시 추가 점수
                    player.score += 2;
                }
                this.updatePlayerDisplay(playerId);
                this.updateDisplay();
            }
            
            updateDisplay() {
                const gameGrid = document.getElementById('gameGrid');
                if (!gameGrid) return;
                
                gameGrid.innerHTML = '';
                
                // 보드 그리기
                for (let y = 0; y < this.boardHeight; y++) {
                    for (let x = 0; x < this.boardWidth; x++) {
                        const cell = document.createElement('div');
                        cell.className = 'cell';
                        
                        if (this.board[y][x] !== 0) {
                            const playerId = this.board[y][x];
                            cell.classList.add('filled', `player-${playerId}`);
                            
                            // 인라인 스타일로 색상 직접 적용
                            if (playerId === this.player1Id) {
                                cell.style.backgroundColor = '#1971c2';
                                cell.style.borderColor = '#1864ab';
                            } else if (playerId === this.player2Id) {
                                cell.style.backgroundColor = '#dc3545';
                                cell.style.borderColor = '#c82333';
                            }
                            
                            console.log(`보드 [${y}][${x}]에 플레이어 ${playerId} 블럭 그리기`);
                            console.log('적용된 클래스:', cell.className);
                            console.log('보드 값:', this.board[y][x]);
                        }
                        
                        gameGrid.appendChild(cell);
                    }
                }
                
                // 현재 떨어지는 조각 그리기
                Object.keys(this.players).forEach(playerId => {
                    const player = this.players[playerId];
                    if (player.currentPiece) {
                        for (let y = 0; y < player.currentPiece.shape.length; y++) {
                            for (let x = 0; x < player.currentPiece.shape[y].length; x++) {
                                if (player.currentPiece.shape[y][x]) {
                                    const boardX = player.currentPiece.x + x;
                                    const boardY = player.currentPiece.y + y;
                                    
                                    if (boardY >= 0 && boardY < this.boardHeight && 
                                        boardX >= 0 && boardX < this.boardWidth) {
                                        const cellIndex = boardY * this.boardWidth + boardX;
                                        const cell = gameGrid.children[cellIndex];
                                        if (cell) {
                                            cell.classList.add('current-piece', `player-${playerId}`);
                                            
                                            // 인라인 스타일로 색상 직접 적용
                                            if (playerId === this.player1Id) {
                                                cell.style.backgroundColor = '#1971c2';
                                                cell.style.borderColor = '#1864ab';
                                            } else if (playerId === this.player2Id) {
                                                cell.style.backgroundColor = '#dc3545';
                                                cell.style.borderColor = '#c82333';
                                            }
                                            
                                            console.log(`현재 조각 [${boardY}][${boardX}]에 플레이어 ${playerId} 클래스 추가`);
                                            console.log('현재 조각 클래스:', cell.className);
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
                
                // 디버깅: 실제 DOM에 적용된 스타일 확인
                setTimeout(() => {
                    const filledCells = gameGrid.querySelectorAll('.cell.filled');
                    console.log('채워진 셀 개수:', filledCells.length);
                    filledCells.forEach((cell, index) => {
                        if (index < 5) { // 처음 5개만 로그
                            console.log(`셀 ${index} 클래스:`, cell.className);
                            console.log(`셀 ${index} 스타일:`, window.getComputedStyle(cell).backgroundColor);
                        }
                    });
                }, 100);
            }
            
            updateNextPieceDisplay(playerId) {
                // 플레이어 색상에 따라 적절한 ID 찾기
                let nextPieceId = null;
                if (this.players[playerId].color === 1) {
                    nextPieceId = 'next-1';
                } else if (this.players[playerId].color === 2) {
                    nextPieceId = 'next-2';
                }
                
                const nextPieceDiv = document.getElementById(nextPieceId);
                if (!nextPieceDiv) {
                    console.log(`다음 블럭 div를 찾을 수 없음: ${nextPieceId}`);
                    return;
                }
                
                nextPieceDiv.innerHTML = '';
                
                // 다음 블럭 제목 추가
                const title = document.createElement('div');
                title.className = 'next-piece-title';
                title.textContent = this.players[playerId].color === 1 ? '플레이어 1 (파란색)' : '플레이어 2 (빨간색)';
                title.style.cssText = 'text-align: center; margin-bottom: 10px; font-weight: bold; color: #495057;';
                nextPieceDiv.appendChild(title);
                
                // 4x4 그리드 생성
                for (let y = 0; y < 4; y++) {
                    for (let x = 0; x < 4; x++) {
                        const cell = document.createElement('div');
                        cell.className = 'cell';
                        cell.style.cssText = 'width: 15px; height: 15px; background: #000; border: 1px solid #333;';
                        
                        if (y < this.players[playerId].nextPiece.length && 
                            x < this.players[playerId].nextPiece[y].length && 
                            this.players[playerId].nextPiece[y][x]) {
                            cell.classList.add('filled', `player-${playerId}`);
                            
                            // 플레이어별 색상 적용
                            if (this.players[playerId].color === 1) {
                                cell.style.backgroundColor = '#1971c2';
                                cell.style.borderColor = '#1864ab';
                            } else if (this.players[playerId].color === 2) {
                                cell.style.backgroundColor = '#dc3545';
                                cell.style.borderColor = '#c82333';
                            }
                        }
                        
                        nextPieceDiv.appendChild(cell);
                    }
                }
                
                console.log(`플레이어 ${playerId} (색상: ${this.players[playerId].color}) 다음 블럭 업데이트 완료`);
            }
            
            updatePlayerDisplay(playerId) {
                const scoreElement = document.getElementById(`score-${playerId}`);
                if (scoreElement) {
                    scoreElement.textContent = this.players[playerId].score.toLocaleString();
                }
                
                // 활성 플레이어 표시
                Object.keys(this.players).forEach(id => {
                    const playerCard = document.getElementById(`player-${id}`);
                    if (playerCard) {
                        playerCard.classList.toggle('active', id === this.getActivePlayer());
                    }
                });
            }
            
            startGameLoop() {
                this.gameLoop = setInterval(() => {
                    if (!this.gameOver) {
                        this.dropTime += 16;
                        
                        if (this.dropTime >= this.dropInterval) {
                            // 모든 플레이어의 조각을 아래로 이동
                            if (this.player1Id && this.players[this.player1Id].currentPiece) {
                                this.movePiece(this.player1Id, 0, 1);
                            }
                            if (this.player2Id && this.players[this.player2Id].currentPiece) {
                                this.movePiece(this.player2Id, 0, 1);
                            }
                            this.dropTime = 0;
                        }
                    }
                }, 16);
            }
            
            setupControls() {
                console.log('키보드 컨트롤 설정 중...');
                console.log('플레이어 수:', Object.keys(this.players).length);
                console.log('플레이어 데이터:', this.players);
                
                // 플레이어 ID를 색상으로 구분하여 저장
                this.player1Id = null;
                this.player2Id = null;
                
                // 플레이어 ID 설정을 기다림
                const setupPlayerIds = () => {
                    Object.keys(this.players).forEach((playerId, index) => {
                        const player = this.players[playerId];
                        console.log(`플레이어 ${playerId} 정보:`, player);
                        console.log(`플레이어 ${playerId} 색상:`, player.color);
                        
                        if (player.color === 1) {
                            this.player1Id = playerId;
                            console.log('✅ 플레이어 1 (파란색) ID 설정:', playerId);
                        } else if (player.color === 2) {
                            this.player2Id = playerId;
                            console.log('✅ 플레이어 2 (빨간색) ID 설정:', playerId);
                        } else {
                            console.log('❌ 알 수 없는 색상:', player.color);
                        }
                    });
                    
                    console.log('최종 플레이어 ID 설정:');
                    console.log('- 플레이어 1 (파란색):', this.player1Id);
                    console.log('- 플레이어 2 (빨간색):', this.player2Id);
                    
                    if (!this.player1Id) {
                        console.error('❌ 플레이어 1 ID가 설정되지 않음!');
                        return false;
                    }
                    return true;
                };
                
                // 플레이어 ID 설정 시도
                if (!setupPlayerIds()) {
                    console.log('플레이어 ID 설정 실패, 100ms 후 재시도...');
                    setTimeout(() => {
                        if (setupPlayerIds()) {
                            this.setupKeyboardEvents();
                        }
                    }, 100);
                    return;
                }
                
                this.setupKeyboardEvents();
            }
            
            setupKeyboardEvents() {
                console.log('키보드 이벤트 설정 중...');
                
                document.addEventListener('keydown', (e) => {
                    console.log('키 입력 감지:', e.key, '코드:', e.code);
                    
                    if (this.gameOver) {
                        console.log('게임 오버 상태 - 키 입력 무시');
                        return;
                    }
                    
                    // 플레이어 1 (WASD) - 파란색
                    if (e.key === 'w' || e.key === 'W') {
                        e.preventDefault();
                        console.log('🎮 플레이어 1 회전 (W) - ID:', this.player1Id);
                        this.rotatePiece(this.player1Id);
                    } else if (e.key === 'a' || e.key === 'A') {
                        e.preventDefault();
                        console.log('🎮 플레이어 1 왼쪽 이동 (A) - ID:', this.player1Id);
                        this.movePiece(this.player1Id, -1, 0);
                    } else if (e.key === 's' || e.key === 'S') {
                        e.preventDefault();
                        console.log('🎮 플레이어 1 아래 이동 (S) - ID:', this.player1Id);
                        this.movePiece(this.player1Id, 0, 1);
                    } else if (e.key === 'd' || e.key === 'D') {
                        e.preventDefault();
                        console.log('🎮 플레이어 1 오른쪽 이동 (D) - ID:', this.player1Id);
                        this.movePiece(this.player1Id, 1, 0);
                    } else if (e.key === 'q' || e.key === 'Q') {
                        e.preventDefault();
                        console.log('🎮 플레이어 1 즉시 하강 (Q) - ID:', this.player1Id);
                        this.dropPiece(this.player1Id);
                    }
                    
                    // 플레이어 2 (방향키) - 빨간색
                    if (this.player2Id) {
                        if (e.key === 'ArrowUp') {
                            e.preventDefault();
                            console.log('🎮 플레이어 2 회전 (↑) - ID:', this.player2Id);
                            this.rotatePiece(this.player2Id);
                        } else if (e.key === 'ArrowLeft') {
                            e.preventDefault();
                            console.log('🎮 플레이어 2 왼쪽 이동 (←) - ID:', this.player2Id);
                            this.movePiece(this.player2Id, -1, 0);
                        } else if (e.key === 'ArrowDown') {
                            e.preventDefault();
                            console.log('🎮 플레이어 2 아래 이동 (↓) - ID:', this.player2Id);
                            this.movePiece(this.player2Id, 0, 1);
                        } else if (e.key === 'ArrowRight') {
                            e.preventDefault();
                            console.log('🎮 플레이어 2 오른쪽 이동 (→) - ID:', this.player2Id);
                            this.movePiece(this.player2Id, 1, 0);
                        } else if (e.key === ' ') {
                            e.preventDefault();
                            console.log('🎮 플레이어 2 즉시 하강 (스페이스) - ID:', this.player2Id);
                            this.dropPiece(this.player2Id);
                        }
                    }
                });
                
                // 키보드 이벤트가 제대로 등록되었는지 확인
                console.log('✅ 키보드 이벤트 등록 완료');
                console.log('🎯 플레이어 1 ID:', this.player1Id);
                console.log('🎯 플레이어 2 ID:', this.player2Id);
            }
            
            showGameOver() {
                clearInterval(this.gameLoop);
                
                const finalScores = document.getElementById('finalScores');
                if (finalScores) {
                    finalScores.innerHTML = '<h3>최종 점수</h3>';
                    
                    const sortedPlayers = Object.entries(this.players).sort((a, b) => b[1].score - a[1].score);
                    
                    sortedPlayers.forEach(([playerId, player], index) => {
                        const scoreItem = document.createElement('div');
                        scoreItem.className = 'final-score-item';
                        if (index === 0) scoreItem.classList.add('winner');
                        
                        scoreItem.innerHTML = `
                            <span>${index === 0 ? '🥇' : '🥈'} ${player.name}</span>
                            <span>${player.score.toLocaleString()}점 (${player.lines_cleared}라인)</span>
                        `;
                        
                        finalScores.appendChild(scoreItem);
                    });
                }
                
                document.getElementById('gameOverModal').style.display = 'flex';
            }
        }
        
        // 게임 시작
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM 로드 완료');
            console.log('게임 시작 상태:', <?= $game_started ? 'true' : 'false' ?>);
            
            if (<?= $game_started ? 'true' : 'false' ?>) {
                console.log('멀티 테트리스 게임 시작!');
                new MultiTetris();
            } else {
                console.log('게임이 시작되지 않음 - 플레이어 참가 대기 중');
            }
        });
    </script>
</body>
</html>
