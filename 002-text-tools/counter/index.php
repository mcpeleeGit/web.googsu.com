<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Googsu 문자수 세기 도구</title>
    <meta name="description" content="Googsu의 문자수 세기 도구를 사용하여 텍스트의 글자 수, 단어 수, 줄 수, 바이트 크기를 쉽게 계산하세요.">
    <meta property="og:title" content="Googsu 문자수 세기 도구">
    <meta property="og:description" content="Googsu의 문자수 세기 도구를 사용하여 텍스트의 글자 수, 단어 수, 줄 수, 바이트 크기를 쉽게 계산하세요.">
    <meta property="og:url" content="https://googsu.com/002-text-tools/counter">
    <meta property="og:image" content="https://googsu.com/images/text-counter-og-image.png">
    <style>
        .counter-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            padding: 20px;
        }

        .input-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        textarea {
            flex: 1;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            resize: none;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .stat-title {
            font-size: 0.9em;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 1.5em;
            color: #1971c2;
            font-weight: bold;
        }

        .stat-sub {
            font-size: 0.8em;
            color: #868e96;
            margin-top: 5px;
        }

        .options {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-bottom: 10px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
        }

        .clear-button {
            padding: 8px 16px;
            background-color: #e9ecef;
            color: #495057;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .clear-button:hover {
            background-color: #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="counter-container">
                <div class="options">
                    <div class="checkbox-group">
                        <input type="checkbox" id="countSpaces" checked>
                        <label for="countSpaces">공백 포함</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="countLineBreaks" checked>
                        <label for="countLineBreaks">줄바꿈 포함</label>
                    </div>
                    <button class="clear-button" onclick="clearText()">지우기</button>
                </div>
                <div class="input-section">
                    <textarea id="textInput" placeholder="텍스트를 입력하세요..." oninput="updateStats()"></textarea>
                </div>
                <div class="stats-section">
                    <div class="stat-card">
                        <div class="stat-title">문자 수</div>
                        <div class="stat-value" id="charCount">0</div>
                        <div class="stat-sub" id="charCountNoSpace">공백 제외: 0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">단어 수</div>
                        <div class="stat-value" id="wordCount">0</div>
                        <div class="stat-sub">공백으로 구분</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">줄 수</div>
                        <div class="stat-value" id="lineCount">0</div>
                        <div class="stat-sub" id="lineCountNoEmpty">빈 줄 제외: 0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">바이트 크기</div>
                        <div class="stat-value" id="byteSize">0</div>
                        <div class="stat-sub">UTF-8 인코딩</div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>
    <script>
        function updateStats() {
            const text = document.getElementById('textInput').value;
            const countSpaces = document.getElementById('countSpaces').checked;
            const countLineBreaks = document.getElementById('countLineBreaks').checked;

            // 문자 수 계산
            let charCount = text.length;
            if (!countSpaces) {
                charCount = text.replace(/\s/g, '').length;
            }
            document.getElementById('charCount').textContent = charCount;
            document.getElementById('charCountNoSpace').textContent = 
                `공백 제외: ${text.replace(/\s/g, '').length}`;

            // 단어 수 계산
            const words = text.trim().split(/\s+/);
            const wordCount = text.trim() === '' ? 0 : words.length;
            document.getElementById('wordCount').textContent = wordCount;

            // 줄 수 계산
            const lines = text.split('\n');
            const lineCount = countLineBreaks ? lines.length : lines.filter(line => line.trim()).length;
            document.getElementById('lineCount').textContent = lineCount;
            document.getElementById('lineCountNoEmpty').textContent = 
                `빈 줄 제외: ${lines.filter(line => line.trim()).length}`;

            // 바이트 크기 계산
            const byteSize = new Blob([text]).size;
            document.getElementById('byteSize').textContent = 
                byteSize >= 1024 ? 
                `${(byteSize / 1024).toFixed(2)} KB` : 
                `${byteSize} Bytes`;
        }

        function clearText() {
            document.getElementById('textInput').value = '';
            updateStats();
        }

        // 탭 키 지원
        document.getElementById('textInput').addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 1;
                updateStats();
            }
        });

        // 초기 통계 업데이트
        updateStats();
    </script>
</body>
</html> 