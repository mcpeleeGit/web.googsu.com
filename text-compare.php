<?php
$page_title = '텍스트 비교';
$additional_css = ['/css/text-compare.css'];
$additional_js = ['/js/text-compare.js'];
include 'includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>텍스트 비교</h1>
        <p class="description">두 텍스트를 비교하여 차이점을 확인할 수 있습니다.</p>
        
        <div class="text-inputs">
            <div class="text-input-group">
                <label for="text1">텍스트 1:</label>
                <textarea id="text1" placeholder="첫 번째 텍스트를 입력하세요"></textarea>
            </div>
            <div class="text-input-group">
                <label for="text2">텍스트 2:</label>
                <textarea id="text2" placeholder="두 번째 텍스트를 입력하세요"></textarea>
            </div>
        </div>

        <div class="button-group">
            <button id="compareBtn" class="primary-button">비교하기</button>
            <button id="clearBtn" class="secondary-button">초기화</button>
        </div>

        <div class="result-section">
            <h2>비교 결과</h2>
            <div id="compareResult"></div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 