<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Markdown to HTML Converter</title>
    <meta name="description" content="Convert Markdown text to HTML effortlessly.">
    <meta property="og:title" content="Markdown to HTML Converter">
    <meta property="og:description" content="Convert Markdown text to HTML effortlessly.">
    <meta property="og:url" content="https://googsu.com/004-converter/markdown">
    <meta property="og:image" content="https://googsu.com/images/markdown-converter-og-image.png">
    <style>
        .markdown-converter {
            width: 100%;
            padding: 20px;
        }

        .input-section, .output-section {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            font-family: monospace;
            font-size: 14px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            resize: vertical;
        }

        .output-section {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="markdown-converter">
                <div class="input-section">
                    <h3>Markdown 입력</h3>
                    <textarea id="markdownInput" placeholder="# 제목\n\n이것은 **굵은 텍스트**입니다.\n\n- 목록 항목 1\n- 목록 항목 2\n\n[링크](https://example.com)"></textarea>
                </div>
                <div class="output-section">
                    <h3>HTML 미리보기</h3>
                    <div id="htmlOutput"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const markdownInput = document.getElementById('markdownInput');
            const htmlOutput = document.getElementById('htmlOutput');

            markdownInput.addEventListener('input', function() {
                const markdownText = markdownInput.value;
                const html = marked.parse(markdownText);
                htmlOutput.innerHTML = html;
            });

            // Trigger initial conversion for the placeholder example
            const initialMarkdown = markdownInput.value;
            htmlOutput.innerHTML = marked.parse(initialMarkdown);
        });
    </script>
</body>
</html> 