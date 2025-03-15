<?php
$page_title = '공학용 계산기 - 유틸리티 모음';
$additional_css = ['css/calculator.css'];
$additional_js = ['js/calculator.js'];
include 'includes/header.php';
?>

        <main>
            <section class="calculator-section">
                <h2>공학용 계산기</h2>
                <div class="calculator">
                    <div class="display">
                        <input type="text" id="display" readonly>
                    </div>
                    <div class="buttons">
                        <!-- 기본 연산자 -->
                        <button class="btn" onclick="clearDisplay()">C</button>
                        <button class="btn" onclick="appendToDisplay('(')">(</button>
                        <button class="btn" onclick="appendToDisplay(')')">)</button>
                        <button class="btn operator" onclick="appendToDisplay('/')">/</button>
                        
                        <!-- 숫자 -->
                        <button class="btn" onclick="appendToDisplay('7')">7</button>
                        <button class="btn" onclick="appendToDisplay('8')">8</button>
                        <button class="btn" onclick="appendToDisplay('9')">9</button>
                        <button class="btn operator" onclick="appendToDisplay('*')">×</button>
                        
                        <button class="btn" onclick="appendToDisplay('4')">4</button>
                        <button class="btn" onclick="appendToDisplay('5')">5</button>
                        <button class="btn" onclick="appendToDisplay('6')">6</button>
                        <button class="btn operator" onclick="appendToDisplay('-')">-</button>
                        
                        <button class="btn" onclick="appendToDisplay('1')">1</button>
                        <button class="btn" onclick="appendToDisplay('2')">2</button>
                        <button class="btn" onclick="appendToDisplay('3')">3</button>
                        <button class="btn operator" onclick="appendToDisplay('+')">+</button>
                        
                        <button class="btn" onclick="appendToDisplay('0')">0</button>
                        <button class="btn" onclick="appendToDisplay('.')">.</button>
                        <button class="btn" onclick="deleteLastChar()">←</button>
                        <button class="btn operator" onclick="calculate()">=</button>
                        
                        <!-- 공학용 함수 -->
                        <button class="btn function" onclick="calculateFunction('sin')">sin</button>
                        <button class="btn function" onclick="calculateFunction('cos')">cos</button>
                        <button class="btn function" onclick="calculateFunction('tan')">tan</button>
                        <button class="btn function" onclick="calculateFunction('sqrt')">√</button>
                        
                        <button class="btn function" onclick="calculateFunction('log')">log</button>
                        <button class="btn function" onclick="calculateFunction('ln')">ln</button>
                        <button class="btn function" onclick="calculateFunction('pow')">x^y</button>
                        <button class="btn function" onclick="calculateFunction('pi')">π</button>
                    </div>
                </div>
            </section>
        </main>

<?php include 'includes/footer.php'; ?> 