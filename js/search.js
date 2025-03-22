document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('toolSearch');
    const searchButton = document.getElementById('searchButton');
    const toolCards = document.querySelectorAll('.tool-card');

    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        toolCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.querySelector('p').textContent.toLowerCase();
            const isMatch = title.includes(searchTerm) || description.includes(searchTerm);
            
            card.style.display = isMatch || searchTerm === '' ? 'block' : 'none';
        });
    }

    // 검색 입력 이벤트
    searchInput.addEventListener('input', performSearch);

    // 검색 버튼 클릭 이벤트
    searchButton.addEventListener('click', performSearch);

    // Enter 키 이벤트
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
}); 