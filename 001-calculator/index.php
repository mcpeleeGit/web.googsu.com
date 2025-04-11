<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../common/head.php'; ?>
    <title>공학용 계산기 - Googsu</title>
    <meta name="description" content="Googsu의 공학용 계산기는 삼각함수, 지수, 로그 등 다양한 수학 계산을 지원합니다.">
    <meta property="og:title" content="공학용 계산기 - Googsu">
    <meta property="og:description" content="Googsu의 공학용 계산기는 삼각함수, 지수, 로그 등 다양한 수학 계산을 지원합니다.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://googsu.com/001-calculator">
    <meta property="og:image" content="https://googsu.com/images/calculator-og-image.png">
    <style>
        .calculator {
            width: 100%;
            height: 100%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .display {
            width: 100%;
            padding: 15px;
            font-size: 24px;
            text-align: right;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .keypad {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }

        .btn {
            padding: 15px;
            font-size: 18px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn:hover {
            background: #e9ecef;
        }

        .btn.operator {
            background: #e7f5ff;
            color: #1971c2;
        }

        .btn.function {
            background: #fff9db;
            color: #e67700;
        }

        .btn.equal {
            background: #1971c2;
            color: white;
        }

        .btn.equal:hover {
            background: #1864ab;
        }

        .history {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .history h3 {
            margin-bottom: 10px;
            color: #495057;
            font-size: 18px;
        }

        .history-item {
            padding: 10px;
            margin: 5px 0;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
        }

        .history-expression {
            color: #495057;
        }

        .history-result {
            color: #1971c2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../common/menu.php'; ?>
        <div class="content-area">
            <div class="calculator">
                <input type="text" class="display" id="display" placeholder="수식을 입력하거나 버튼을 클릭하세요">
                <div class="keypad">
                    <!-- 함수 버튼 -->
                    <button class="btn function">sin</button>
                    <button class="btn function">cos</button>
                    <button class="btn function">tan</button>
                    <button class="btn function">√</button>
                    <button class="btn function">^</button>

                    <!-- 숫자 및 연산자 -->
                    <button class="btn">7</button>
                    <button class="btn">8</button>
                    <button class="btn">9</button>
                    <button class="btn operator">÷</button>
                    <button class="btn function">π</button>

                    <button class="btn">4</button>
                    <button class="btn">5</button>
                    <button class="btn">6</button>
                    <button class="btn operator">×</button>
                    <button class="btn function">e</button>

                    <button class="btn">1</button>
                    <button class="btn">2</button>
                    <button class="btn">3</button>
                    <button class="btn operator">-</button>
                    <button class="btn">(</button>

                    <button class="btn">0</button>
                    <button class="btn">.</button>
                    <button class="btn">C</button>
                    <button class="btn operator">+</button>
                    <button class="btn">)</button>

                    <button class="btn equal" style="grid-column: span 5;">=</button>
                </div>

                <!-- 계산 기록 -->
                <div class="history">
                    <h3>최근 계산 기록</h3>
                    <div id="history-list">
                        <!-- 계산 기록이 여기에 동적으로 추가됩니다 -->
                    </div>
                </div>
            </div>
        </div>
        <?php include '../common/footer.php'; ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const display = document.getElementById('display');
            const buttons = document.querySelectorAll('.btn');
            const historyList = document.getElementById('history-list');
            let calculationHistory = [];

            // 계산 기록 업데이트 함수
            function updateHistory(expression, result) {
                calculationHistory.unshift({ expression, result });
                if (calculationHistory.length > 3) {
                    calculationHistory.pop();
                }

                historyList.innerHTML = '';
                calculationHistory.forEach(item => {
                    const historyItem = document.createElement('div');
                    historyItem.className = 'history-item';
                    historyItem.innerHTML = `
                        <span class="history-expression">${item.expression}</span>
                        <span class="history-result">${item.result}</span>
                    `;
                    historyList.appendChild(historyItem);
                });
            }

            // 수식 계산 함수
            function calculateExpression(expr) {
                try {
                    // 수학 함수 처리
                    let expression = expr
                        .replace(/sin/g, 'Math.sin')
                        .replace(/cos/g, 'Math.cos')
                        .replace(/tan/g, 'Math.tan')
                        .replace(/π/g, 'Math.PI')
                        .replace(/e/g, 'Math.E')
                        .replace(/√/g, 'Math.sqrt')
                        .replace(/×/g, '*')
                        .replace(/÷/g, '/');

                    const result = eval(expression);
                    const formattedResult = Number.isInteger(result) ? result : result.toFixed(8);
                    updateHistory(expr, formattedResult);
                    return formattedResult;
                } catch (error) {
                    return 'Error';
                }
            }

            // 입력 필드 값 변경 감지
            display.addEventListener('input', function(e) {
                // 현재 커서 위치 저장
                const cursorPos = this.selectionStart;
                // 입력 필드의 현재 값을 저장
                const currentValue = this.value;
                
                // 커서 위치 복원
                this.value = currentValue;
                this.setSelectionRange(cursorPos, cursorPos);
            });

            // 키보드 입력 처리
            display.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const result = calculateExpression(this.value);
                    this.value = result;
                }
            });

            // 버튼 클릭 처리
            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const value = button.textContent;
                    const cursorPos = display.selectionStart;

                    if (value === 'C') {
                        display.value = '';
                    } else if (value === '=') {
                        const result = calculateExpression(display.value);
                        display.value = result;
                    } else {
                        // 현재 커서 위치에 값을 삽입
                        const currentValue = display.value;
                        display.value = currentValue.slice(0, cursorPos) + value + currentValue.slice(cursorPos);
                        // 커서를 삽입된 텍스트 다음으로 이동
                        display.setSelectionRange(cursorPos + value.length, cursorPos + value.length);
                    }
                    // 입력 필드에 포커스 유지
                    display.focus();
                });
            });
        });
    </script>
</body>
</html> 