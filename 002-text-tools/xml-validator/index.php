<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>XML 검증기</title>
    <meta name="description" content="XML 데이터를 검증하고 구조를 확인할 수 있는 도구입니다.">
    <meta property="og:title" content="XML 검증기">
    <meta property="og:description" content="XML 데이터를 검증하고 구조를 확인할 수 있는 도구입니다.">
    <meta property="og:url" content="https://googsu.com/002-text-tools/xml-validator">
    <meta property="og:image" content="https://googsu.com/images/xml-validator-og-image.png">
    <style>
        .xml-validator-container {
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

        .validate-button {
            background-color: #1971c2;
            color: white;
        }

        .validate-button:hover {
            background-color: #1864ab;
        }

        .result-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .result-title {
            font-size: 1.1em;
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .result-box {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .result-box:last-child {
            margin-bottom: 0;
        }

        .part-header {
            font-size: 0.9em;
            color: #1971c2;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .part-content {
            font-family: monospace;
            font-size: 0.9em;
            color: #495057;
            white-space: pre-wrap;
            word-break: break-all;
        }

        .error-message {
            color: #e03131;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="xml-validator-container">
                <div class="input-section">
                    <div class="input-group">
                        <label>XML 입력</label>
                        <textarea name="input" placeholder="검증할 XML 데이터를 입력하세요"></textarea>
                    </div>
                    <div class="buttons">
                        <button class="action-button validate-button" type="button" onclick="validateXML()">
                            <i class="fas fa-check"></i> 검증
                        </button>
                    </div>
                </div>
                <div class="result-section">
                    <div class="result-title">
                        <i class="fas fa-file-code"></i>
                        결과
                    </div>
                    <div class="result-box">
                        <div class="part-content" id="xml-result"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>

    <script>
        function validateXML() {
            const input = document.querySelector('textarea[name="input"]').value;
            if (!input) {
                alert('XML 데이터를 입력하세요.');
                return;
            }

            try {
                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(input, "application/xml");
                const errorNode = xmlDoc.querySelector("parsererror");
                if (errorNode) {
                    document.getElementById('xml-result').textContent = '유효하지 않은 XML 데이터입니다.';
                } else {
                    document.getElementById('xml-result').textContent = '유효한 XML 데이터입니다.';
                }
            } catch (error) {
                alert('유효한 XML 데이터를 입력하세요.');
            }
        }
    </script>
</body>
</html> 