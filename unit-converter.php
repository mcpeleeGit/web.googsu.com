<?php
include_once 'includes/header.php';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">단위 변환기</h1>
    
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <form id="converterForm">
                        <div class="mb-3">
                            <label for="conversionType" class="form-label">변환 종류</label>
                            <select class="form-select" id="conversionType">
                                <option value="length">길이</option>
                                <option value="weight">무게</option>
                                <option value="temperature">온도</option>
                                <option value="area">면적</option>
                            </select>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col">
                                <label for="fromUnit" class="form-label">변환 전 단위</label>
                                <select class="form-select" id="fromUnit"></select>
                            </div>
                            <div class="col">
                                <label for="toUnit" class="form-label">변환 후 단위</label>
                                <select class="form-select" id="toUnit"></select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="inputValue" class="form-label">값 입력</label>
                            <input type="number" class="form-control" id="inputValue" step="any">
                        </div>
                        
                        <div class="mb-3">
                            <label for="result" class="form-label">변환 결과</label>
                            <input type="text" class="form-control" id="result" readonly>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">변환하기</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const unitData = {
    length: {
        units: ['mm', 'cm', 'm', 'km', 'inch', 'feet', 'yard', 'mile'],
        conversions: {
            mm: 1,
            cm: 10,
            m: 1000,
            km: 1000000,
            inch: 25.4,
            feet: 304.8,
            yard: 914.4,
            mile: 1609344
        }
    },
    weight: {
        units: ['mg', 'g', 'kg', 'ton', 'oz', 'lb'],
        conversions: {
            mg: 1,
            g: 1000,
            kg: 1000000,
            ton: 1000000000,
            oz: 28349.5,
            lb: 453592
        }
    },
    temperature: {
        units: ['Celsius', 'Fahrenheit', 'Kelvin'],
        conversions: {} // 특별 처리
    },
    area: {
        units: ['mm²', 'cm²', 'm²', 'km²', 'acre', 'hectare'],
        conversions: {
            'mm²': 1,
            'cm²': 100,
            'm²': 1000000,
            'km²': 1000000000000,
            'acre': 4046856422.4,
            'hectare': 10000000000
        }
    }
};

function updateUnitSelects() {
    const type = document.getElementById('conversionType').value;
    const fromUnit = document.getElementById('fromUnit');
    const toUnit = document.getElementById('toUnit');
    
    fromUnit.innerHTML = '';
    toUnit.innerHTML = '';
    
    unitData[type].units.forEach(unit => {
        fromUnit.add(new Option(unit, unit));
        toUnit.add(new Option(unit, unit));
    });
}

function convertTemperature(value, from, to) {
    let celsius;
    
    // 먼저 섭씨로 변환
    if (from === 'Celsius') {
        celsius = value;
    } else if (from === 'Fahrenheit') {
        celsius = (value - 32) * 5/9;
    } else if (from === 'Kelvin') {
        celsius = value - 273.15;
    }
    
    // 목표 단위로 변환
    if (to === 'Celsius') {
        return celsius;
    } else if (to === 'Fahrenheit') {
        return (celsius * 9/5) + 32;
    } else if (to === 'Kelvin') {
        return celsius + 273.15;
    }
}

function convert(value, from, to, type) {
    if (type === 'temperature') {
        return convertTemperature(value, from, to);
    }
    
    const conversions = unitData[type].conversions;
    return (value * conversions[from]) / conversions[to];
}

document.getElementById('conversionType').addEventListener('change', updateUnitSelects);

document.getElementById('converterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const type = document.getElementById('conversionType').value;
    const fromUnit = document.getElementById('fromUnit').value;
    const toUnit = document.getElementById('toUnit').value;
    const inputValue = parseFloat(document.getElementById('inputValue').value);
    
    if (isNaN(inputValue)) {
        alert('올바른 숫자를 입력해주세요.');
        return;
    }
    
    const result = convert(inputValue, fromUnit, toUnit, type);
    document.getElementById('result').value = `${result.toFixed(4)} ${toUnit}`;
});

// 초기 단위 옵션 설정
updateUnitSelects();
</script>

<?php
include_once 'includes/footer.php';
?> 