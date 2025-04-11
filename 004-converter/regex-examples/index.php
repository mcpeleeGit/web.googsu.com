<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>정규식 예제</title>
    <meta name="description" content="정규 표현식을 작성하고 테스트할 수 있는 예제를 제공합니다.">
    <meta property="og:title" content="정규식 예제">
    <meta property="og:description" content="정규 표현식을 작성하고 테스트할 수 있는 예제를 제공합니다.">
    <meta property="og:url" content="https://googsu.com/004-converter/regex-examples">
    <meta property="og:image" content="https://googsu.com/images/regex-examples-og-image.png">
    <style>
        .regex-examples-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .example, .tester {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .example h3, .tester h3 {
            margin-top: 0;
        }

        .example pre, .tester pre {
            background: #e9ecef;
            padding: 10px;
            border-radius: 8px;
            overflow-x: auto;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .input-group input, .input-group textarea {
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
        }

        .btn {
            padding: 10px 20px;
            background-color: #1971c2;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn:hover {
            background-color: #1864ab;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="regex-examples-container">
                <div class="tester">
                    <h3>정규식 테스트</h3>
                    <div class="input-group">
                        <label for="regexInput">정규식 입력:</label>
                        <input type="text" id="regexInput" placeholder="예: ^[a-zA-Z0-9]+$">
                        <label for="testString">테스트 문자열:</label>
                        <textarea id="testString" rows="4" placeholder="테스트할 문자열을 입력하세요"></textarea>
                        <button class="btn" onclick="testRegex()">테스트</button>
                    </div>
                    <div class="result" id="regexResult">
                        <h3>결과</h3>
                        <pre id="resultText">정규식과 테스트 문자열을 입력하고 '테스트' 버튼을 클릭하세요.</pre>
                    </div>
                </div>
                <div class="example">
                    <h3>이메일 주소 검증</h3>
                    <p>이메일 주소 형식을 검증하는 정규식:</p>
                    <pre>/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/</pre>
                </div>
                <div class="example">
                    <h3>URL 검증</h3>
                    <p>URL 형식을 검증하는 정규식:</p>
                    <pre>/^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\/\w .-]*)*\/?$/</pre>
                </div>
                <div class="example">
                    <h3>전화번호 검증</h3>
                    <p>전화번호 형식을 검증하는 정규식 (한국):</p>
                    <pre>/^(01[016789])-?(\d{3,4})-?(\d{4})$/</pre>
                </div>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>

    <script>
        function testRegex() {
            const regexInput = document.getElementById('regexInput').value.trim();
            const testString = document.getElementById('testString').value;
            const resultText = document.getElementById('resultText');

            if (!regexInput || !testString) {
                resultText.textContent = '정규식과 테스트 문자열을 모두 입력하세요.';
                return;
            }

            try {
                const regex = new RegExp(regexInput);
                const isMatch = regex.test(testString);
                resultText.textContent = isMatch ? '일치합니다.' : '일치하지 않습니다.';
            } catch (e) {
                resultText.textContent = '유효한 정규식을 입력하세요.';
            }
        }
    </script>
</body>
</html> 