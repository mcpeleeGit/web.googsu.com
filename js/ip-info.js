document.addEventListener('DOMContentLoaded', function() {
    // 현재 IP 정보 가져오기
    fetchCurrentIP();

    // IP 조회 버튼 이벤트 리스너
    document.getElementById('lookup-btn').addEventListener('click', function() {
        const ipInput = document.getElementById('ip-input').value.trim();
        if (ipInput) {
            fetchIPInfo(ipInput);
        } else {
            alert('IP 주소를 입력해주세요.');
        }
    });
});

async function fetchCurrentIP() {
    try {
        const response = await fetch('https://api.ipify.org?format=json');
        const data = await response.json();
        const ip = data.ip;
        
        // IP 정보 표시
        document.getElementById('ip-address').textContent = ip;
        
        // IP 위치 정보 가져오기
        fetchIPInfo(ip);
    } catch (error) {
        console.error('IP 주소를 가져오는데 실패했습니다:', error);
        document.getElementById('ip-address').textContent = '오류 발생';
    }
}

async function fetchIPInfo(ip) {
    try {
        const response = await fetch(`https://ipapi.co/${ip}/json/`);
        const data = await response.json();

        // 현재 IP 정보 업데이트
        if (ip === document.getElementById('ip-address').textContent) {
            updateIPInfo(data, '');
        } else {
            // 조회 결과 표시
            document.getElementById('lookup-result').style.display = 'block';
            updateIPInfo(data, 'lookup-');
        }
    } catch (error) {
        console.error('IP 정보를 가져오는데 실패했습니다:', error);
        alert('IP 정보를 가져오는데 실패했습니다.');
    }
}

function updateIPInfo(data, prefix) {
    document.getElementById(`${prefix}country`).textContent = data.country_name || '알 수 없음';
    document.getElementById(`${prefix}city`).textContent = data.city || '알 수 없음';
    document.getElementById(`${prefix}isp`).textContent = data.org || '알 수 없음';
} 