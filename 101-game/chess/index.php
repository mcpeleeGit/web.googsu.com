<?php
session_start();

// 체스 게임 초기화
if (!isset($_SESSION['chess_game'])) {
    $_SESSION['chess_game'] = [
        'board' => [
            // 8행 8열 체스보드 초기화
            ['r', 'n', 'b', 'q', 'k', 'b', 'n', 'r'], // 1행 (흑)
            ['p', 'p', 'p', 'p', 'p', 'p', 'p', 'p'], // 2행 (흑)
            ['', '', '', '', '', '', '', ''],           // 3행
            ['', '', '', '', '', '', '', ''],           // 4행
            ['', '', '', '', '', '', '', ''],           // 5행
            ['', '', '', '', '', '', '', ''],           // 6행
            ['P', 'P', 'P', 'P', 'P', 'P', 'P', 'P'], // 7행 (백)
            ['R', 'N', 'B', 'Q', 'K', 'B', 'N', 'R']  // 8행 (백)
        ],
        'current_player' => 'white', // 백이 먼저 시작
        'game_over' => false,
        'check' => false,
        'checkmate' => false,
        'move_history' => [],
        'captured_pieces' => ['white' => [], 'black' => []]
    ];
}

// 게임 재시작
if (isset($_POST['restart'])) {
    unset($_SESSION['chess_game']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$game = $_SESSION['chess_game'];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>체스 게임</title>
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
        
        .game-area {
            display: flex;
            gap: 30px;
            padding: 40px;
        }
        
        .chess-board-section {
            flex: 1;
            text-align: center;
        }
        
        .chess-board {
            border: 3px solid #333;
            background: #000;
            margin: 0 auto;
            position: relative;
            width: fit-content;
        }
        
        .chess-grid {
            display: grid;
            grid-template-columns: repeat(8, 60px);
            grid-template-rows: repeat(8, 60px);
            gap: 0;
            background: #333;
        }
        
        .chess-cell {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .chess-cell.light {
            background: #f0d9b5;
        }
        
        .chess-cell.dark {
            background: #b58863;
        }
        
        .chess-cell.selected {
            background: #7b61ff !important;
            box-shadow: inset 0 0 20px rgba(123, 97, 255, 0.5);
        }
        
        .chess-cell.valid-move {
            background: #90EE90 !important;
            box-shadow: inset 0 0 20px rgba(144, 238, 144, 0.5);
        }
        
        .chess-cell:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }
        
        .game-info-section {
            width: 300px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .current-player {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }
        
        .current-player h3 {
            color: #495057;
            margin-bottom: 15px;
        }
        
        .player-indicator {
            font-size: 2em;
            padding: 15px;
            border-radius: 10px;
            font-weight: bold;
        }
        
        .player-indicator.white {
            background: #fff;
            color: #333;
            border: 3px solid #333;
        }
        
        .player-indicator.black {
            background: #333;
            color: #fff;
            border: 3px solid #fff;
        }
        
        .restart-button {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }
        
        .restart-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        @media (max-width: 768px) {
            .game-area {
                flex-direction: column;
                padding: 20px;
            }
            
            .chess-grid {
                grid-template-columns: repeat(8, 40px);
                grid-template-rows: repeat(8, 40px);
            }
            
            .chess-cell {
                width: 40px;
                height: 40px;
                font-size: 25px;
            }
            
            .game-info-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div class="game-header">
            <h1 class="game-title">♔ 체스 게임</h1>
            <p class="game-subtitle">전략적 사고로 승리를 쟁취하세요!</p>
        </div>
        
        <div class="game-area">
            <div class="chess-board-section">
                <div class="chess-board">
                    <div class="chess-grid" id="chessGrid"></div>
                </div>
            </div>
            
            <div class="game-info-section">
                <div class="current-player">
                    <h3>현재 플레이어</h3>
                    <div class="player-indicator <?= $game['current_player'] ?>" id="currentPlayerIndicator">
                        <?= $game['current_player'] === 'white' ? '♔' : '♚' ?>
                    </div>
                </div>
                
                <form method="post">
                    <button type="submit" name="restart" class="restart-button">🔄 게임 재시작</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        class ChessGame {
            constructor() {
                this.board = <?= json_encode($game['board']) ?>;
                this.currentPlayer = '<?= $game['current_player'] ?>';
                this.selectedPiece = null;
                this.validMoves = [];
                this.gameOver = <?= $game['game_over'] ? 'true' : 'false' ?>;
                this.check = <?= $game['check'] ? 'true' : 'false' ?>;
                this.checkmate = <?= $game['checkmate'] ? 'true' : 'false' ?>;
                
                this.pieceSymbols = {
                    'K': '♔', 'Q': '♕', 'R': '♖', 'B': '♗', 'N': '♘', 'P': '♙', // 백
                    'k': '♚', 'q': '♛', 'r': '♜', 'b': '♝', 'n': '♞', 'p': '♟'  // 흑
                };
                
                this.init();
            }
            
            init() {
                this.renderBoard();
                this.setupEventListeners();
            }
            
            renderBoard() {
                const grid = document.getElementById('chessGrid');
                grid.innerHTML = '';
                
                for (let row = 0; row < 8; row++) {
                    for (let col = 0; col < 8; col++) {
                        const cell = document.createElement('div');
                        cell.className = `chess-cell ${(row + col) % 2 === 0 ? 'light' : 'dark'}`;
                        cell.dataset.row = row;
                        cell.dataset.col = col;
                        
                        const piece = this.board[row][col];
                        if (piece) {
                            cell.textContent = this.pieceSymbols[piece];
                            cell.dataset.piece = piece;
                        }
                        
                        grid.appendChild(cell);
                    }
                }
            }
            
            setupEventListeners() {
                const grid = document.getElementById('chessGrid');
                grid.addEventListener('click', (e) => {
                    if (e.target.classList.contains('chess-cell')) {
                        this.handleCellClick(e.target);
                    }
                });
            }
            
            handleCellClick(cell) {
                const row = parseInt(cell.dataset.row);
                const col = parseInt(cell.dataset.col);
                const piece = this.board[row][col];
                
                // 이미 선택된 기물이 있는 경우
                if (this.selectedPiece) {
                    // 이동하려는 경우
                    if (this.isValidMove(this.selectedPiece.row, this.selectedPiece.col, row, col)) {
                        this.makeMove(this.selectedPiece.row, this.selectedPiece.col, row, col);
                        this.clearSelection();
                    } else if (piece && this.isPieceOfCurrentPlayer(piece)) {
                        // 다른 기물을 선택한 경우
                        this.selectPiece(row, col);
                    } else {
                        // 선택 해제
                        this.clearSelection();
                    }
                } else {
                    // 기물 선택
                    if (piece && this.isPieceOfCurrentPlayer(piece)) {
                        this.selectPiece(row, col);
                    }
                }
            }
            
            selectPiece(row, col) {
                this.selectedPiece = { row, col, piece: this.board[row][col] };
                this.validMoves = this.getValidMoves(row, col);
                this.updateDisplay();
            }
            
            clearSelection() {
                this.selectedPiece = null;
                this.validMoves = [];
                this.updateDisplay();
            }
            
            isPieceOfCurrentPlayer(piece) {
                const isWhite = piece === piece.toUpperCase();
                return (this.currentPlayer === 'white' && isWhite) || (this.currentPlayer === 'black' && !isWhite);
            }
            
            getValidMoves(row, col) {
                const piece = this.board[row][col];
                if (!piece) return [];
                
                const moves = [];
                const pieceType = piece.toLowerCase();
                
                switch (pieceType) {
                    case 'p': // 폰
                        moves.push(...this.getPawnMoves(row, col));
                        break;
                    case 'r': // 룩
                        moves.push(...this.getRookMoves(row, col));
                        break;
                    case 'n': // 나이트
                        moves.push(...this.getKnightMoves(row, col));
                        break;
                    case 'b': // 비숍
                        moves.push(...this.getBishopMoves(row, col));
                        break;
                    case 'q': // 퀸
                        moves.push(...this.getQueenMoves(row, col));
                        break;
                    case 'k': // 킹
                        moves.push(...this.getKingMoves(row, col));
                        break;
                }
                
                return moves;
            }
            
            getPawnMoves(row, col) {
                const moves = [];
                const piece = this.board[row][col];
                const isWhite = piece === 'P';
                const direction = isWhite ? -1 : 1;
                const startRow = isWhite ? 6 : 1;
                
                // 전진
                if (this.isValidPosition(row + direction, col) && !this.board[row + direction][col]) {
                    moves.push({ row: row + direction, col: col });
                    
                    // 첫 번째 이동에서 2칸 전진
                    if (row === startRow && !this.board[row + 2 * direction][col]) {
                        moves.push({ row: row + 2 * direction, col: col });
                    }
                }
                
                // 대각선 공격
                const attackCols = [col - 1, col + 1];
                for (const attackCol of attackCols) {
                    if (this.isValidPosition(row + direction, attackCol)) {
                        const targetPiece = this.board[row + direction][attackCol];
                        if (targetPiece && this.isPieceOfCurrentPlayer(targetPiece) === false) {
                            moves.push({ row: row + direction, col: attackCol });
                        }
                    }
                }
                
                return moves;
            }
            
            getRookMoves(row, col) {
                return this.getLinearMoves(row, col, [[0, 1], [0, -1], [1, 0], [-1, 0]]);
            }
            
            getBishopMoves(row, col) {
                return this.getLinearMoves(row, col, [[1, 1], [1, -1], [-1, 1], [-1, -1]]);
            }
            
            getQueenMoves(row, col) {
                return this.getLinearMoves(row, col, [
                    [0, 1], [0, -1], [1, 0], [-1, 0], // 룩 이동
                    [1, 1], [1, -1], [-1, 1], [-1, -1] // 비숍 이동
                ]);
            }
            
            getKnightMoves(row, col) {
                const moves = [];
                const knightMoves = [
                    [-2, -1], [-2, 1], [-1, -2], [-1, 2],
                    [1, -2], [1, 2], [2, -1], [2, 1]
                ];
                
                for (const [dRow, dCol] of knightMoves) {
                    const newRow = row + dRow;
                    const newCol = col + dCol;
                    
                    if (this.isValidPosition(newRow, newCol)) {
                        const targetPiece = this.board[newRow][newCol];
                        if (!targetPiece || this.isPieceOfCurrentPlayer(targetPiece) === false) {
                            moves.push({ row: newRow, col: newCol });
                        }
                    }
                }
                
                return moves;
            }
            
            getKingMoves(row, col) {
                const moves = [];
                const kingMoves = [
                    [-1, -1], [-1, 0], [-1, 1],
                    [0, -1], [0, 1],
                    [1, -1], [1, 0], [1, 1]
                ];
                
                for (const [dRow, dCol] of kingMoves) {
                    const newRow = row + dRow;
                    const newCol = col + dCol;
                    
                    if (this.isValidPosition(newRow, newCol)) {
                        const targetPiece = this.board[newRow][newCol];
                        if (!targetPiece || this.isPieceOfCurrentPlayer(targetPiece) === false) {
                            moves.push({ row: newRow, col: newCol });
                        }
                    }
                }
                
                return moves;
            }
            
            getLinearMoves(row, col, directions) {
                const moves = [];
                
                for (const [dRow, dCol] of directions) {
                    let currentRow = row + dRow;
                    let currentCol = col + dCol;
                    
                    while (this.isValidPosition(currentRow, currentCol)) {
                        const targetPiece = this.board[currentRow][currentCol];
                        
                        if (!targetPiece) {
                            moves.push({ row: currentRow, col: currentCol });
                        } else {
                            if (this.isPieceOfCurrentPlayer(targetPiece) === false) {
                                moves.push({ row: currentRow, col: currentCol });
                            }
                            break;
                        }
                        
                        currentRow += dRow;
                        currentCol += dCol;
                    }
                }
                
                return moves;
            }
            
            isValidPosition(row, col) {
                return row >= 0 && row < 8 && col >= 0 && col < 8;
            }
            
            isValidMove(fromRow, fromCol, toRow, toCol) {
                const moves = this.getValidMoves(fromRow, fromCol);
                return moves.some(move => move.row === toRow && move.col === toCol);
            }
            
            makeMove(fromRow, fromCol, toRow, toCol) {
                const piece = this.board[fromRow][fromCol];
                this.board[toRow][toCol] = piece;
                this.board[fromRow][fromCol] = '';
                
                // 플레이어 변경
                this.currentPlayer = this.currentPlayer === 'white' ? 'black' : 'white';
                
                // 보드 업데이트
                this.renderBoard();
                this.updateDisplay();
            }
            
            updateDisplay() {
                // 현재 플레이어 표시 업데이트
                const indicator = document.getElementById('currentPlayerIndicator');
                indicator.className = `player-indicator ${this.currentPlayer}`;
                indicator.textContent = this.currentPlayer === 'white' ? '♔' : '♚';
                
                // 선택된 기물과 유효한 이동 표시
                this.clearBoardHighlights();
                
                if (this.selectedPiece) {
                    this.highlightCell(this.selectedPiece.row, this.selectedPiece.col, 'selected');
                    
                    for (const move of this.validMoves) {
                        this.highlightCell(move.row, move.col, 'valid-move');
                    }
                }
            }
            
            clearBoardHighlights() {
                const cells = document.querySelectorAll('.chess-cell');
                cells.forEach(cell => {
                    cell.classList.remove('selected', 'valid-move');
                });
            }
            
            highlightCell(row, col, className) {
                const cell = document.querySelector(`[data-row="${row}"][data-col="${col}"]`);
                if (cell) {
                    cell.classList.add(className);
                }
            }
        }
        
        // 게임 시작
        document.addEventListener('DOMContentLoaded', () => {
            new ChessGame();
        });
    </script>
</body>
</html>
