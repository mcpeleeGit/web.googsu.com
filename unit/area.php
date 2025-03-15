<?php
$page_title = '면적 단위 변환';
$additional_css = ['/css/text-compare.css'];
include_once '../includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>면적 변환</h1>
        
        <form id="converterForm" class="needs-validation" novalidate>
            <div class="text-inputs">
                <div class="text-input-group">
                    <!-- From Unit Section -->
                    <div class="mui-card converter-card">
                        <div class="mui-card-header d-flex align-items-center">
                            <div class="mui-card-icon me-2">
                                <i class="fas fa-arrow-right text-primary"></i>
                            </div>
                            <h3>변환 전</h3>
                        </div>
                        <div class="mui-card-content">
                            <div class="mb-4">
                                <label class="mui-label">단위 선택</label>
                                <select class="form-select mui-select" id="fromUnit" required>
                                    <option value="mm2">제곱밀리미터 (mm²)</option>
                                    <option value="cm2">제곱센티미터 (cm²)</option>
                                    <option value="m2">제곱미터 (m²)</option>
                                    <option value="km2">제곱킬로미터 (km²)</option>
                                    <option value="ha">헥타르 (ha)</option>
                                    <option value="acre">에이커 (acre)</option>
                                    <option value="ft2">제곱피트 (ft²)</option>
                                    <option value="yd2">제곱야드 (yd²)</option>
                                    <option value="mi2">제곱마일 (mi²)</option>
                                    <option value="pyeong">평</option>
                                </select>
                            </div>
                            <div>
                                <label class="mui-label">값 입력</label>
                                <input type="number" 
                                       class="form-control mui-input" 
                                       id="inputValue" 
                                       step="any" 
                                       placeholder="숫자를 입력하세요"
                                       required>
                                <div class="invalid-feedback">
                                    올바른 숫자를 입력해주세요
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-input-group">
                    <!-- To Unit Section -->
                    <div class="mui-card converter-card">
                        <div class="mui-card-header d-flex align-items-center">
                            <div class="mui-card-icon me-2">
                                <i class="fas fa-arrow-left text-primary"></i>
                            </div>
                            <h3>변환 후</h3>
                        </div>
                        <div class="mui-card-content">
                            <div class="mb-4">
                                <label class="mui-label">단위 선택</label>
                                <select class="form-select mui-select" id="toUnit" required>
                                    <option value="mm2">제곱밀리미터 (mm²)</option>
                                    <option value="cm2">제곱센티미터 (cm²)</option>
                                    <option value="m2" selected>제곱미터 (m²)</option>
                                    <option value="km2">제곱킬로미터 (km²)</option>
                                    <option value="ha">헥타르 (ha)</option>
                                    <option value="acre">에이커 (acre)</option>
                                    <option value="ft2">제곱피트 (ft²)</option>
                                    <option value="yd2">제곱야드 (yd²)</option>
                                    <option value="mi2">제곱마일 (mi²)</option>
                                    <option value="pyeong">평</option>
                                </select>
                            </div>
                            <div>
                                <label class="mui-label">변환 결과</label>
                                <input type="text" 
                                       class="form-control mui-input" 
                                       id="result" 
                                       readonly 
                                       placeholder="변환 결과가 여기에 표시됩니다">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn mui-button">
                    <span class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-exchange-alt me-2"></i>
                        <span class="button-text">변환</span>
                    </span>
                </button>
            </div>
        </form>

        <div class="result-section">
            <table class="table mui-table">
                <thead>
                    <tr>
                        <th>단위</th>
                        <th>제곱미터(m²) 기준</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 제곱밀리미터 (mm²)</td><td>0.000001 m²</td></tr>
                    <tr><td>1 제곱센티미터 (cm²)</td><td>0.0001 m²</td></tr>
                    <tr><td>1 제곱미터 (m²)</td><td>1 m²</td></tr>
                    <tr><td>1 제곱킬로미터 (km²)</td><td>1,000,000 m²</td></tr>
                    <tr><td>1 헥타르 (ha)</td><td>10,000 m²</td></tr>
                    <tr><td>1 에이커 (acre)</td><td>4,046.86 m²</td></tr>
                    <tr><td>1 제곱피트 (ft²)</td><td>0.092903 m²</td></tr>
                    <tr><td>1 제곱야드 (yd²)</td><td>0.836127 m²</td></tr>
                    <tr><td>1 제곱마일 (mi²)</td><td>2,589,988.11 m²</td></tr>
                    <tr><td>1 평</td><td>3.305785 m²</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
:root {
    --mui-primary: #1976d2;
    --mui-primary-dark: #1565c0;
    --mui-primary-light: #42a5f5;
    --mui-secondary: #9c27b0;
    --mui-background: #f5f5f5;
    --mui-surface: #ffffff;
    --mui-text-primary: #1a1a1a;
    --mui-text-secondary: #666666;
    --mui-divider: #e0e0e0;
}

.mui-surface {
    background-color: var(--mui-surface);
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.mui-header {
    background-color: var(--mui-primary);
    color: white;
}

.mui-card {
    background-color: var(--mui-surface);
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.converter-card {
    width: 320px;
}

.converter-button {
    padding: 0 1rem;
}

.mui-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.mui-card-header {
    padding: 16px;
    border-bottom: 1px solid var(--mui-divider);
    background-color: rgba(25, 118, 210, 0.05);
}

.mui-card-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mui-card-content {
    padding: 24px;
}

.mui-title {
    color: var(--mui-text-primary);
    font-weight: 500;
    margin: 0;
}

.mui-label {
    color: var(--mui-text-secondary);
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 8px;
    display: block;
}

.mui-input,
.mui-select {
    border: 1px solid var(--mui-divider);
    border-radius: 4px;
    padding: 10px 12px;
    font-size: 1rem;
    transition: all 0.2s;
}

.mui-input:focus,
.mui-select:focus {
    border-color: var(--mui-primary);
    box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
}

.mui-button {
    background-color: var(--mui-primary);
    color: white;
    border: none;
    padding: 12px 32px;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: all 0.2s;
    border-radius: 8px;
    min-width: 120px;
}

.mui-button:hover {
    background-color: var(--mui-primary-dark);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    color: white;
    transform: translateY(-1px);
}

.button-text {
    font-size: 1rem;
}

.mui-table {
    margin: 0;
}

.mui-table thead {
    background-color: rgba(25, 118, 210, 0.05);
}

.mui-table th {
    color: var(--mui-text-primary);
    font-weight: 500;
    border-bottom: 2px solid var(--mui-divider);
}

.mui-table td {
    color: var(--mui-text-secondary);
    border-bottom: 1px solid var(--mui-divider);
    padding: 1rem;
}

.mui-table tr:hover {
    background-color: rgba(25, 118, 210, 0.02);
}

body {
    background-color: var(--mui-background);
}

.text-primary {
    color: var(--mui-primary) !important;
}

.converter-wrapper {
    overflow-x: auto;
}

@media (max-width: 991.98px) {
    .converter-card {
        width: 280px;
    }
    
    .converter-button {
        padding: 1rem 0;
    }
    
    .gap-4 {
        gap: 1rem !important;
    }
}

/* Additional styles for text-compare layout */
.text-compare-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.text-inputs {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 2rem;
}

.text-input-group {
    flex: 0 1 auto;
}

.button-group {
    text-align: center;
    margin: 2rem 0;
}

.result-section {
    max-width: 800px;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .text-inputs {
        flex-direction: column;
        align-items: center;
    }
    
    .text-input-group {
        width: 100%;
        max-width: 320px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('converterForm');
    const inputValue = document.getElementById('inputValue');
    const result = document.getElementById('result');
    const fromUnit = document.getElementById('fromUnit');
    const toUnit = document.getElementById('toUnit');

    const conversions = {
        mm2: 0.000001,
        cm2: 0.0001,
        m2: 1,
        km2: 1000000,
        ha: 10000,
        acre: 4046.86,
        ft2: 0.092903,
        yd2: 0.836127,
        mi2: 2589988.11,
        pyeong: 3.305785
    };

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }
        
        const value = parseFloat(inputValue.value);
        const squareMeters = value * conversions[fromUnit.value];
        const converted = squareMeters / conversions[toUnit.value];
        
        const unitSymbols = {
            mm2: 'mm²',
            cm2: 'cm²',
            m2: 'm²',
            km2: 'km²',
            ha: 'ha',
            acre: 'acre',
            ft2: 'ft²',
            yd2: 'yd²',
            mi2: 'mi²',
            pyeong: '평'
        };
        
        result.value = `${converted.toLocaleString('ko-KR', {
            maximumFractionDigits: 6,
            minimumFractionDigits: 0
        })} ${unitSymbols[toUnit.value]}`;
    });

    inputValue.addEventListener('input', function(e) {
        if (this.value === '') {
            this.setCustomValidity('값을 입력해주세요');
        } else if (isNaN(this.value)) {
            this.setCustomValidity('올바른 숫자를 입력해주세요');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>

<?php
include_once '../includes/footer.php';
?> 