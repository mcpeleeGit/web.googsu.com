<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Timestamp Converter</title>
    <meta name="description" content="Convert Unix timestamps to human-readable dates and vice versa.">
    <meta property="og:title" content="Timestamp Converter">
    <meta property="og:description" content="Convert Unix timestamps to human-readable dates and vice versa.">
    <meta property="og:url" content="https://googsu.com/004-converter/timestamp">
    <meta property="og:image" content="https://googsu.com/images/timestamp-converter-og-image.png">
    <style>
        .timestamp-converter {
            width: 100%;
            padding: 20px;
        }

        .converter-section {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: #1971c2;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn:hover {
            background: #1864ab;
        }

        .result-display {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="timestamp-converter">
                <div class="converter-section">
                    <h3>타임스탬프 변환기</h3>
                    <div class="input-group">
                        <label for="timestampInput">Unix 타임스탬프 또는 날짜 입력 (예: 1609459200 또는 2021-01-01)</label>
                        <input type="text" id="timestampInput" placeholder="1609459200 또는 2021-01-01">
                    </div>
                    <button id="convertButton" class="btn">변환</button>
                    <div id="timestampResult" class="result-display"></div>
                </div>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timestampInput = document.getElementById('timestampInput');
            const convertButton = document.getElementById('convertButton');
            const timestampResult = document.getElementById('timestampResult');

            convertButton.addEventListener('click', function() {
                const input = timestampInput.value.trim();
                if (input) {
                    if (!isNaN(input)) {
                        // Unix 타임스탬프를 날짜로 변환
                        const date = new Date(input * 1000);
                        timestampResult.innerHTML = `변환된 날짜: ${date.toLocaleString()}`;
                    } else {
                        // 날짜를 Unix 타임스탬프로 변환
                        const date = new Date(input);
                        const unixTimestamp = Math.floor(date.getTime() / 1000);
                        timestampResult.innerHTML = `변환된 Unix 타임스탬프: ${unixTimestamp}`;
                    }
                } else {
                    alert("값을 입력하세요.");
                }
            });
        });
    </script>
</body>
</html>