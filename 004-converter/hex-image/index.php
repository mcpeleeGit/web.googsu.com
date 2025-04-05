<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>HEX to Image Converter</title>
    <meta name="description" content="Convert HEX strings to images and vice versa with ease.">
    <meta property="og:title" content="HEX to Image Converter">
    <meta property="og:description" content="Convert HEX strings to images and vice versa with ease.">
    <meta property="og:url" content="https://googsu.com/004-converter/hex-image">
    <meta property="og:image" content="https://googsu.com/images/hex-image-og-image.png">
    <style>
        .hex-image-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            padding: 20px;
        }

        .input-section {
            display: flex;
            gap: 20px;
        }

        .hex-input, .image-preview {
            flex: 1;
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
            height: 200px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            resize: vertical;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
        }

        .drop-zone {
            width: 100%;
            height: 200px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .drop-zone:hover, .drop-zone.dragover {
            border-color: #1971c2;
            background-color: #f8f9fa;
        }

        .drop-zone i {
            font-size: 48px;
            color: #adb5bd;
        }

        .drop-zone p {
            color: #868e96;
            margin: 0;
        }

        .preview-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            display: none;
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

        .convert-button {
            background-color: #1971c2;
            color: white;
        }

        .convert-button:hover {
            background-color: #1864ab;
        }

        .clear-button {
            background-color: #e9ecef;
            color: #495057;
        }

        .clear-button:hover {
            background-color: #dee2e6;
        }

        .error-message {
            color: #e03131;
            font-size: 0.9em;
            display: none;
        }

        #fileInput {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div class="hex-image-container">
                <div class="input-section">
                    <div class="hex-input">
                        <div class="input-group">
                            <label>HEX 문자열</label>
                            <textarea id="hexInput" placeholder="이미지의 HEX 문자열을 입력하세요&#10;예: 89504E470D0A1A0A..."></textarea>
                            <div id="hexError" class="error-message">
                                <i class="fas fa-exclamation-circle"></i> 
                                유효하지 않은 HEX 문자열입니다.
                            </div>
                        </div>
                        <div class="buttons">
                            <button class="action-button convert-button" onclick="hexToImage()">
                                <i class="fas fa-image"></i> 이미지로 변환
                            </button>
                            <button class="action-button clear-button" onclick="clearHex()">
                                <i class="fas fa-eraser"></i> 지우기
                            </button>
                        </div>
                    </div>
                    <div class="image-preview">
                        <div class="input-group">
                            <label>이미지</label>
                            <input type="file" id="fileInput" accept="image/*">
                            <div class="drop-zone" onclick="document.getElementById('fileInput').click()">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>이미지를 드래그하거나 클릭하여 업로드</p>
                            </div>
                            <img id="previewImage" class="preview-image">
                            <div id="imageError" class="error-message">
                                <i class="fas fa-exclamation-circle"></i> 
                                이미지 처리 중 오류가 발생했습니다.
                            </div>
                        </div>
                        <div class="buttons">
                            <button class="action-button convert-button" onclick="imageToHex()">
                                <i class="fas fa-code"></i> HEX로 변환
                            </button>
                            <button class="action-button clear-button" onclick="clearImage()">
                                <i class="fas fa-eraser"></i> 지우기
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // 드래그 앤 드롭 이벤트 처리
        const dropZone = document.querySelector('.drop-zone');
        const fileInput = document.getElementById('fileInput');
        const previewImage = document.getElementById('previewImage');
        const hexInput = document.getElementById('hexInput');
        const hexError = document.getElementById('hexError');
        const imageError = document.getElementById('imageError');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('dragover');
        }

        function unhighlight(e) {
            dropZone.classList.remove('dragover');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        dropZone.style.display = 'none';
                        imageError.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imageError.textContent = '이미지 파일만 업로드 가능합니다.';
                    imageError.style.display = 'block';
                }
            }
        }

        function hexToImage() {
            const hex = hexInput.value.replace(/\s/g, '');
            if (!/^[0-9A-Fa-f]+$/.test(hex)) {
                hexError.style.display = 'block';
                return;
            }

            hexError.style.display = 'none';
            const bytes = new Uint8Array(hex.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));
            const blob = new Blob([bytes], { type: 'application/octet-stream' });
            previewImage.src = URL.createObjectURL(blob);
            previewImage.style.display = 'block';
            dropZone.style.display = 'none';
        }

        function imageToHex() {
            if (!previewImage.src) {
                imageError.textContent = '이미지를 먼저 업로드해주세요.';
                imageError.style.display = 'block';
                return;
            }

            fetch(previewImage.src)
                .then(response => response.arrayBuffer())
                .then(buffer => {
                    const bytes = new Uint8Array(buffer);
                    const hex = Array.from(bytes)
                        .map(byte => byte.toString(16).padStart(2, '0'))
                        .join('');
                    hexInput.value = hex.toUpperCase();
                    imageError.style.display = 'none';
                })
                .catch(error => {
                    imageError.textContent = '이미지 처리 중 오류가 발생했습니다.';
                    imageError.style.display = 'block';
                });
        }

        function clearHex() {
            hexInput.value = '';
            hexError.style.display = 'none';
        }

        function clearImage() {
            previewImage.src = '';
            previewImage.style.display = 'none';
            dropZone.style.display = 'flex';
            imageError.style.display = 'none';
            fileInput.value = '';
        }

        // 텍스트 영역 탭 키 지원
        hexInput.addEventListener('keydown', function(e) {
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