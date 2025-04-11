<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Googsu 텍스트 비교 도구</title>
    <meta name="description" content="Googsu의 텍스트 비교 도구를 사용하여 두 텍스트의 차이점을 쉽게 비교하고 분석하세요.">
    <meta property="og:title" content="Googsu 텍스트 비교 도구">
    <meta property="og:description" content="Googsu의 텍스트 비교 도구를 사용하여 두 텍스트의 차이점을 쉽게 비교하고 분석하세요.">
    <meta property="og:url" content="https://googsu.com/002-text-tools/compare">
    <meta property="og:image" content="https://googsu.com/images/text-compare-og-image.png">
    <style>
        .text-compare-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            padding: 20px;
        }

        .input-area {
            display: flex;
            gap: 20px;
            height: 60%;
        }

        .text-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .text-section h3 {
            margin: 0;
            color: #333;
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

        .compare-button {
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.2s;
        }

        .compare-button:hover {
            background-color: #0056b3;
        }

        .result-area {
            flex: 1;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: white;
        }

        .diff-line {
            display: flex;
            padding: 5px 10px;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
        }

        .diff-line:nth-child(even) {
            background: #f8f9fa;
        }

        .line-number {
            color: #6c757d;
            margin-right: 15px;
            user-select: none;
            min-width: 40px;
        }

        .diff-content {
            flex: 1;
            white-space: pre;
        }

        .diff {
            background-color: #ffd7d7;
        }

        .same {
            background-color: transparent;
        }

        .options {
            display: flex;
            gap: 20px;
            align-items: center;
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
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="text-compare-container">
                <div class="input-area">
                    <div class="text-section">
                        <h3>텍스트 1</h3>
                        <textarea id="text1" placeholder="첫 번째 텍스트를 입력하세요"></textarea>
                    </div>
                    <div class="text-section">
                        <h3>텍스트 2</h3>
                        <textarea id="text2" placeholder="두 번째 텍스트를 입력하세요"></textarea>
                    </div>
                </div>
                <div class="options">
                    <div class="checkbox-group">
                        <input type="checkbox" id="ignoreCase" checked>
                        <label for="ignoreCase">대소문자 무시</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="ignoreSpace" checked>
                        <label for="ignoreSpace">공백 무시</label>
                    </div>
                    <button class="compare-button" onclick="compareTexts()">비교하기</button>
                </div>
                <div class="result-area" id="result"></div>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>
    <script>
        function compareTexts() {
            const text1 = document.getElementById('text1').value;
            const text2 = document.getElementById('text2').value;
            const ignoreCase = document.getElementById('ignoreCase').checked;
            const ignoreSpace = document.getElementById('ignoreSpace').checked;
            
            const lines1 = text1.split('\n');
            const lines2 = text2.split('\n');
            const result = document.getElementById('result');
            result.innerHTML = '';

            const maxLines = Math.max(lines1.length, lines2.length);

            for (let i = 0; i < maxLines; i++) {
                const line1 = lines1[i] || '';
                const line2 = lines2[i] || '';
                
                let processedLine1 = line1;
                let processedLine2 = line2;

                if (ignoreCase) {
                    processedLine1 = processedLine1.toLowerCase();
                    processedLine2 = processedLine2.toLowerCase();
                }
                if (ignoreSpace) {
                    processedLine1 = processedLine1.replace(/\s+/g, '');
                    processedLine2 = processedLine2.replace(/\s+/g, '');
                }

                const diffDiv = document.createElement('div');
                diffDiv.className = 'diff-line';

                // 라인 번호 추가
                const lineNumber = document.createElement('span');
                lineNumber.className = 'line-number';
                lineNumber.textContent = (i + 1).toString().padStart(3, '0');
                diffDiv.appendChild(lineNumber);

                // 내용 추가
                const content = document.createElement('span');
                content.className = 'diff-content';

                if (processedLine1 !== processedLine2) {
                    // 문자 단위 비교를 위한 함수
                    const charDiff = compareCharacters(line1, line2);
                    content.innerHTML = charDiff;
                } else {
                    content.textContent = line1;
                }

                diffDiv.appendChild(content);
                result.appendChild(diffDiv);
            }
        }

        function compareCharacters(str1, str2) {
            let result = '';
            const maxLength = Math.max(str1.length, str2.length);
            
            for (let i = 0; i < maxLength; i++) {
                const char1 = str1[i] || '';
                const char2 = str2[i] || '';
                
                if (char1 === char2) {
                    result += char1;
                } else {
                    result += `<span class="diff">${char1}</span>`;
                }
            }
            
            return result;
        }

        // 텍스트 영역 탭 키 지원
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);
                    this.selectionStart = this.selectionEnd = start + 1;
                }
            });
        });
    </script>
</body>
</html> 