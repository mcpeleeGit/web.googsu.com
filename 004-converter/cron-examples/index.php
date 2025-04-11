<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Cron 예제</title>
    <meta name="description" content="Cron 작업을 설정하고 관리하는 예제를 제공합니다.">
    <meta property="og:title" content="Cron 예제">
    <meta property="og:description" content="Cron 작업을 설정하고 관리하는 예제를 제공합니다.">
    <meta property="og:url" content="https://googsu.com/006-developer-tools/cron-examples">
    <meta property="og:image" content="https://googsu.com/images/cron-examples-og-image.png">
    <style>
        .cron-examples-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .example, .explanation {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .example h3, .explanation h3 {
            margin-top: 0;
        }

        .example pre, .explanation pre {
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

        .input-group input {
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 16px;
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
            <div class="cron-examples-container">
                <div class="input-group">
                    <label for="cronInput">Cron 표현식 입력:</label>
                    <input type="text" id="cronInput" placeholder="예: * * * * *">
                    <button class="btn" onclick="explainCron()">설명 보기</button>
                </div>
                <div class="explanation" id="cronExplanation">
                    <h3>설명</h3>
                    <pre id="explanationText">Cron 표현식을 입력하고 '설명 보기' 버튼을 클릭하세요.</pre>
                </div>
                <div class="example">
                    <h3>기본 Cron 작업 설정</h3>
                    <p>매일 자정에 스크립트를 실행하는 예제:</p>
                    <pre>* 0 * * * /path/to/script.sh</pre>
                </div>
                <div class="example">
                    <h3>매주 특정 요일에 작업 실행</h3>
                    <p>매주 월요일 오전 3시에 백업 스크립트를 실행하는 예제:</p>
                    <pre>0 3 * * 1 /path/to/backup.sh</pre>
                </div>
                <div class="example">
                    <h3>매월 특정 날짜에 작업 실행</h3>
                    <p>매월 1일 오전 6시에 보고서를 생성하는 예제:</p>
                    <pre>0 6 1 * * /path/to/report.sh</pre>
                </div>
                <div class="example">
                    <h3>매시간 작업 실행</h3>
                    <p>매시간 15분마다 로그를 정리하는 예제:</p>
                    <pre>15 * * * * /path/to/cleanup.sh</pre>
                </div>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>

    <script>
        function explainCron() {
            const cronInput = document.getElementById('cronInput').value.trim();
            const explanationText = document.getElementById('explanationText');

            if (!cronInput) {
                explanationText.textContent = 'Cron 표현식을 입력하세요.';
                return;
            }

            const parts = cronInput.split(' ');
            if (parts.length !== 5) {
                explanationText.textContent = '유효한 Cron 표현식을 입력하세요. (5개의 필드 필요)';
                return;
            }

            const [minute, hour, day, month, weekday] = parts;
            explanationText.textContent = `분: ${minute}, 시: ${hour}, 일: ${day}, 월: ${month}, 요일: ${weekday}`;
        }
    </script>
</body>
</html> 