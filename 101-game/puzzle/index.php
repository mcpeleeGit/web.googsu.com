<?php
session_start();

// 게임 초기화
if (!isset($_SESSION['puzzle_game'])) {
    $_SESSION['puzzle_game'] = [
        'target_number' => rand(1, 100),
        'attempts' => 0,
        'max_attempts' => 10,
        'game_over' => false,
        'won' => false,
        'hint_history' => []
    ];
}

// 게임 재시작
if (isset($_POST['restart'])) {
    unset($_SESSION['puzzle_game']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// 점수 저장 처리
if (isset($_POST['save_score']) && isset($_POST['player_name'])) {
    $player_name = htmlspecialchars($_POST['player_name']);
    $score = (int)$_POST['score'];
    
    if (!isset($_SESSION['puzzle_high_scores'])) {
        $_SESSION['puzzle_high_scores'] = [];
    }
    
    $_SESSION['puzzle_high_scores'][] = [
        'name' => $player_name,
        'score' => $score,
        'attempts' => $_SESSION['puzzle_game']['attempts'],
        'date' => date('Y-m-d H:i:s')
    ];
    
    // 점수 정렬 (높은 순)
    usort($_SESSION['puzzle_high_scores'], function($a, $b) {
        return $b['score'] - $a['score'];
    });
    
    // 상위 10개만 유지
    $_SESSION['puzzle_high_scores'] = array_slice($_SESSION['puzzle_high_scores'], 0, 10);
    
    // 게임 재시작
    unset($_SESSION['puzzle_game']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>숫자 퍼즐 게임</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .game-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        
        .game-header {
            margin-bottom: 30px;
        }
        
        .game-title {
            color: #1971c2;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .game-subtitle {
            color: #6c757d;
            font-size: 1.1em;
        }
        
        .game-info {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
            border: 2px solid #e9ecef;
        }
        
        .info-item {
            text-align: center;
        }
        
        .info-label {
            color: #6c757d;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #1971c2;
            font-size: 1.5em;
            font-weight: bold;
        }
        
        .game-input {
            margin-bottom: 30px;
        }
        
        .input-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .number-input {
            width: 120px;
            padding: 15px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            font-size: 1.2em;
            text-align: center;
            outline: none;
            transition: border-color 0.3s ease;
        }
        
        .number-input:focus {
            border-color: #1971c2;
        }
        
        .guess-button {
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
        
        .guess-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .guess-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .hint-display {
            background: #e7f5ff;
            border: 2px solid #1971c2;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            font-size: 1.2em;
            color: #1971c2;
            font-weight: 600;
        }
        
        .hint-history {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .hint-history h3 {
            color: #495057;
            margin-bottom: 15px;
        }
        
        .hint-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: white;
            border-radius: 8px;
            margin-bottom: 8px;
            border: 1px solid #e9ecef;
        }
        
        .hint-number {
            font-weight: bold;
            color: #1971c2;
        }
        
        .hint-result {
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
            color: #28a745;
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
            border-radius: 15px;
            margin-top: 30px;
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
        
        .score-attempts {
            color: #a17e02;
            font-size: 0.9em;
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
            margin-top: 20px;
        }
        
        .restart-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        @media (max-width: 768px) {
            .game-container {
                padding: 20px;
            }
            
            .game-title {
                font-size: 2em;
            }
            
            .input-group {
                flex-direction: column;
            }
            
            .number-input {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div class="game-header">
            <h1 class="game-title">🔢 숫자 퍼즐</h1>
            <p class="game-subtitle">1부터 100 사이의 숫자를 맞춰보세요!</p>
        </div>
        
        <div class="game-info">
            <div class="info-item">
                <div class="info-label">시도 횟수</div>
                <div class="info-value" id="attempts"><?= $_SESSION['puzzle_game']['attempts'] ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">남은 기회</div>
                <div class="info-value" id="remaining"><?= $_SESSION['puzzle_game']['max_attempts'] - $_SESSION['puzzle_game']['attempts'] ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">최고 점수</div>
                <div class="info-value" id="highScore">
                    <?php 
                    if (isset($_SESSION['puzzle_high_scores']) && !empty($_SESSION['puzzle_high_scores'])) {
                        echo number_format($_SESSION['puzzle_high_scores'][0]['score']);
                    } else {
                        echo '0';
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <?php if (!$_SESSION['puzzle_game']['game_over']): ?>
            <div class="game-input">
                <div class="input-group">
                    <input type="number" id="guessInput" class="number-input" placeholder="1-100" min="1" max="100" autocomplete="off">
                    <button id="guessButton" class="guess-button">추측하기</button>
                </div>
                <p style="color: #6c757d; font-size: 0.9em;">힌트: 숫자가 너무 크거나 작다고 알려드립니다!</p>
            </div>
            
            <div class="hint-display" id="hintDisplay" style="display: none;">
                <span id="hintText"></span>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($_SESSION['puzzle_game']['hint_history'])): ?>
            <div class="hint-history">
                <h3>📝 추측 기록</h3>
                <?php foreach ($_SESSION['puzzle_game']['hint_history'] as $hint): ?>
                    <div class="hint-item">
                        <span class="hint-number"><?= $hint['guess'] ?></span>
                        <span class="hint-result"><?= $hint['hint'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($_SESSION['puzzle_game']['game_over']): ?>
            <div class="hint-display" style="background: <?= $_SESSION['puzzle_game']['won'] ? '#d4edda' : '#f8d7da' ?>; border-color: <?= $_SESSION['puzzle_game']['won'] ? '#28a745' : '#dc3545' ?>; color: <?= $_SESSION['puzzle_game']['won'] ? '#155724' : '#721c24' ?>;">
                <strong>
                    <?php if ($_SESSION['puzzle_game']['won']): ?>
                        🎉 축하합니다! 숫자를 맞췄습니다!
                    <?php else: ?>
                        😔 게임 오버! 정답은 <?= $_SESSION['puzzle_game']['target_number'] ?>였습니다.
                    <?php endif; ?>
                </strong>
            </div>
            
            <form method="post" style="margin-top: 20px;">
                <button type="submit" name="restart" class="restart-button">새 게임 시작</button>
            </form>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['puzzle_high_scores']) && !empty($_SESSION['puzzle_high_scores'])): ?>
            <div class="high-scores">
                <h3>🏆 최고 점수</h3>
                <?php foreach (array_slice($_SESSION['puzzle_high_scores'], 0, 5) as $score): ?>
                    <div class="score-item">
                        <span class="score-name"><?= $score['name'] ?></span>
                        <span class="score-value"><?= number_format($score['score']) ?></span>
                        <span class="score-attempts">(<?= $score['attempts'] ?>회)</span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="game-over-modal" id="gameOverModal">
        <div class="modal-content">
            <h2 id="modalTitle">🎉 축하합니다!</h2>
            <p id="modalMessage">숫자를 맞췄습니다!</p>
            <p>점수: <span id="modalScore">0</span></p>
            <form method="post" id="scoreForm">
                <input type="text" name="player_name" class="score-input" placeholder="플레이어 이름" maxlength="20" required>
                <input type="hidden" name="score" id="hiddenScore" value="0">
                <input type="hidden" name="save_score" value="1">
                <button type="submit" class="btn btn-primary">점수 저장</button>
            </form>
        </div>
    </div>

    <script>
        class NumberPuzzle {
            constructor() {
                this.attempts = <?= $_SESSION['puzzle_game']['attempts'] ?>;
                this.maxAttempts = <?= $_SESSION['puzzle_game']['max_attempts'] ?>;
                this.gameOver = <?= $_SESSION['puzzle_game']['game_over'] ? 'true' : 'false' ?>;
                this.won = <?= $_SESSION['puzzle_game']['won'] ? 'true' : 'false' ?>;
                this.targetNumber = <?= $_SESSION['puzzle_game']['target_number'] ?>;
                
                this.init();
            }
            
            init() {
                this.setupEventListeners();
                this.updateDisplay();
            }
            
            setupEventListeners() {
                const guessButton = document.getElementById('guessButton');
                const guessInput = document.getElementById('guessInput');
                
                if (guessButton && guessInput) {
                    guessButton.addEventListener('click', () => this.makeGuess());
                    guessInput.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            this.makeGuess();
                        }
                    });
                }
            }
            
            async makeGuess() {
                const guessInput = document.getElementById('guessInput');
                const guess = parseInt(guessInput.value);
                
                if (isNaN(guess) || guess < 1 || guess > 100) {
                    alert('1부터 100 사이의 숫자를 입력해주세요!');
                    return;
                }
                
                this.attempts++;
                
                if (guess === this.targetNumber) {
                    this.won = true;
                    this.gameOver = true;
                    this.showGameOver();
                } else {
                    const hint = guess > this.targetNumber ? '더 작습니다' : '더 큽니다';
                    this.addHint(guess, hint);
                    
                    if (this.attempts >= this.maxAttempts) {
                        this.gameOver = true;
                        this.showGameOver();
                    }
                }
                
                this.updateDisplay();
                guessInput.value = '';
                guessInput.focus();
            }
            
            addHint(guess, hint) {
                const hintHistory = document.querySelector('.hint-history');
                if (!hintHistory) {
                    const newHistory = document.createElement('div');
                    newHistory.className = 'hint-history';
                    newHistory.innerHTML = '<h3>📝 추측 기록</h3>';
                    document.querySelector('.game-container').insertBefore(newHistory, document.querySelector('.restart-button') || document.querySelector('.high-scores'));
                }
                
                const hintItem = document.createElement('div');
                hintItem.className = 'hint-item';
                hintItem.innerHTML = `
                    <span class="hint-number">${guess}</span>
                    <span class="hint-result">${hint}</span>
                `;
                
                document.querySelector('.hint-history').appendChild(hintItem);
            }
            
            showGameOver() {
                if (this.won) {
                    const score = Math.max(1, 1000 - (this.attempts * 50));
                    document.getElementById('modalScore').textContent = score.toLocaleString();
                    document.getElementById('hiddenScore').value = score;
                    document.getElementById('gameOverModal').style.display = 'flex';
                }
            }
            
            updateDisplay() {
                document.getElementById('attempts').textContent = this.attempts;
                document.getElementById('remaining').textContent = Math.max(0, this.maxAttempts - this.attempts);
                
                if (this.gameOver) {
                    const guessButton = document.getElementById('guessButton');
                    const guessInput = document.getElementById('guessInput');
                    if (guessButton) guessButton.disabled = true;
                    if (guessInput) guessInput.disabled = true;
                }
            }
        }
        
        // 게임 시작
        document.addEventListener('DOMContentLoaded', () => {
            new NumberPuzzle();
        });
    </script>
</body>
</html>
