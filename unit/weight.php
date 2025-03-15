<?php
$page_title = '무게 단위 변환';
$additional_css = ['/css/text-compare.css'];
include_once '../includes/header.php';
?>

<div class="container">
    <div class="text-compare-container">
        <h1>무게 변환</h1>
        
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
                                    <option value="mg">밀리그램 (mg)</option>
                                    <option value="g">그램 (g)</option>
                                    <option value="kg">킬로그램 (kg)</option>
                                    <option value="t">톤 (t)</option>
                                    <option value="oz">온스 (oz)</option>
                                    <option value="lb">파운드 (lb)</option>
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
                                    <option value="mg">밀리그램 (mg)</option>
                                    <option value="g">그램 (g)</option>
                                    <option value="kg" selected>킬로그램 (kg)</option>
                                    <option value="t">톤 (t)</option>
                                    <option value="oz">온스 (oz)</option>
                                    <option value="lb">파운드 (lb)</option>
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
                        <th>킬로그램(kg) 기준</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 밀리그램 (mg)</td><td>0.000001 kg</td></tr>
                    <tr><td>1 그램 (g)</td><td>0.001 kg</td></tr>
                    <tr><td>1 킬로그램 (kg)</td><td>1 kg</td></tr>
                    <tr><td>1 톤 (t)</td><td>1,000 kg</td></tr>
                    <tr><td>1 온스 (oz)</td><td>0.02835 kg</td></tr>
                    <tr><td>1 파운드 (lb)</td><td>0.45359 kg</td></tr>
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
        mg: 0.000001,
        g: 0.001,
        kg: 1,
        t: 1000,
        oz: 0.02835,
        lb: 0.45359
    };

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }
        
        const value = parseFloat(inputValue.value);
        const kilograms = value * conversions[fromUnit.value];
        const converted = kilograms / conversions[toUnit.value];
        
        const unitSymbols = {
            mg: 'mg',
            g: 'g',
            kg: 'kg',
            t: 't',
            oz: 'oz',
            lb: 'lb'
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