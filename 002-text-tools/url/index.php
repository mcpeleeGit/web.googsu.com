<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Googsu URL 인코더/디코더</title>
    <meta name="description" content="Googsu의 URL 인코더/디코더를 사용하여 URL 문자열을 인코딩하거나 디코딩하세요.">
    <meta property="og:title" content="Googsu URL 인코더/디코더">
    <meta property="og:description" content="Googsu의 URL 인코더/디코더를 사용하여 URL 문자열을 인코딩하거나 디코딩하세요.">
    <meta property="og:url" content="https://googsu.com/003-encoder/url">
    <meta property="og:image" content="https://googsu.com/images/url-og-image.png">
    <style>
        .url-encoder-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            padding: 20px;
        }

        .input-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .input-group label {
            font-weight: bold;
            color: #495057;
        }

        textarea {
            width: 100%;
            height: 120px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            resize: vertical;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .action-button {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .encode-button {
            background-color: #1971c2;
            color: white;
        }

        .encode-button:hover {
            background-color: #1864ab;
        }

        .decode-button {
            background-color: #495057;
            color: white;
        }

        .decode-button:hover {
            background-color: #343a40;
        }

        .clear-button {
            background-color: #e9ecef;
            color: #495057;
        }

        .clear-button:hover {
            background-color: #dee2e6;
        }

        .history-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .history-title {
            font-size: 1.1em;
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .history-item {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .history-item:last-child {
            margin-bottom: 0;
        }

        .history-type {
            font-size: 0.9em;
            color: #1971c2;
            margin-bottom: 5px;
        }

        .history-content {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .history-text {
            font-family: monospace;
            font-size: 0.9em;
            color: #495057;
            word-break: break-all;
        }

        .history-arrow {
            color: #adb5bd;
            font-size: 0.9em;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="url-encoder-container">
                <div class="input-section">
                    <div class="input-group">
                        <label>URL 문자열</label>
                        <textarea id="input" placeholder="인코딩하거나 디코딩할 URL을 입력하세요"></textarea>
                    </div>
                    <div class="buttons">
                        <button class="action-button encode-button" onclick="encodeUrl()">
                            <i class="fas fa-lock"></i> 인코딩
                        </button>
                        <button class="action-button decode-button" onclick="decodeUrl()">
                            <i class="fas fa-lock-open"></i> 디코딩
                        </button>
                        <button class="action-button clear-button" onclick="clearInput()">
                            <i class="fas fa-eraser"></i> 지우기
                        </button>
                    </div>
                </div>
                <div class="history-section">
                    <div class="history-title">
                        <i class="fas fa-history"></i>
                        최근 변환 기록
                    </div>
                    <div id="history"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let history = [];

        function encodeUrl() {
            const input = document.getElementById('input').value;
            try {
                const encoded = encodeURIComponent(input);
                addToHistory('encode', input, encoded);
                document.getElementById('input').value = encoded;
            } catch (error) {
                alert('인코딩 중 오류가 발생했습니다.');
            }
        }

        function decodeUrl() {
            const input = document.getElementById('input').value;
            try {
                const decoded = decodeURIComponent(input);
                addToHistory('decode', input, decoded);
                document.getElementById('input').value = decoded;
            } catch (error) {
                alert('디코딩 중 오류가 발생했습니다.');
            }
        }

        function clearInput() {
            document.getElementById('input').value = '';
        }

        function addToHistory(type, input, output) {
            history.unshift({
                type,
                input,
                output,
                timestamp: new Date()
            });

            if (history.length > 3) {
                history.pop();
            }

            updateHistoryDisplay();
        }

        function updateHistoryDisplay() {
            const historyDiv = document.getElementById('history');
            historyDiv.innerHTML = '';

            history.forEach(item => {
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                
                const typeText = item.type === 'encode' ? '인코딩' : '디코딩';
                const typeIcon = item.type === 'encode' ? 'fa-lock' : 'fa-lock-open';
                
                historyItem.innerHTML = `
                    <div class="history-type">
                        <i class="fas ${typeIcon}"></i> ${typeText}
                    </div>
                    <div class="history-content">
                        <div class="history-text">${item.input}</div>
                        <div class="history-arrow">↓</div>
                        <div class="history-text">${item.output}</div>
                    </div>
                `;
                
                historyDiv.appendChild(historyItem);
            });
        }

        // 텍스트 영역 탭 키 지원
        document.getElementById('input').addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 1;
            }
        });
    </script>
</body>
</html> 