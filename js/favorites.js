// 즐겨찾기 관리 클래스
class FavoritesManager {
    constructor() {
        this.favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        this.init();
    }

    init() {
        // 즐겨찾기 상태 업데이트
        this.updateFavoritesUI();
        
        // 즐겨찾기 토글 이벤트 리스너 추가
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('favorite-btn')) {
                const toolId = e.target.dataset.toolId;
                this.toggleFavorite(toolId);
            }
        });
    }

    toggleFavorite(toolId) {
        const index = this.favorites.indexOf(toolId);
        if (index === -1) {
            this.favorites.push(toolId);
        } else {
            this.favorites.splice(index, 1);
        }
        localStorage.setItem('favorites', JSON.stringify(this.favorites));
        this.updateFavoritesUI();
    }

    isFavorite(toolId) {
        return this.favorites.includes(toolId);
    }

    updateFavoritesUI() {
        // 모든 즐겨찾기 버튼 업데이트
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            const toolId = btn.dataset.toolId;
            btn.innerHTML = this.isFavorite(toolId) ? '⭐' : '☆';
            btn.classList.toggle('active', this.isFavorite(toolId));
        });

        // 즐겨찾기 섹션 업데이트
        this.updateFavoritesSection();
    }

    updateFavoritesSection() {
        const favoritesSection = document.getElementById('favorites-section');
        if (!favoritesSection) return;

        const favoriteTools = this.favorites.map(id => {
            const toolCard = document.querySelector(`[data-tool-id="${id}"]`).closest('.tool-card');
            return {
                id: id,
                name: toolCard.querySelector('h3').textContent,
                description: toolCard.querySelector('p').textContent,
                icon: toolCard.querySelector('.tool-icon').textContent,
                url: toolCard.querySelector('.tool-link').href
            };
        });

        if (favoriteTools.length === 0) {
            favoritesSection.innerHTML = '<p class="no-favorites">즐겨찾기한 도구가 없습니다.</p>';
            return;
        }

        favoritesSection.innerHTML = `
            <div class="tools-grid">
                ${favoriteTools.map(tool => `
                    <div class="tool-card" data-tool-id="${tool.id}">
                        <div class="tool-icon">${tool.icon}</div>
                        <h3>${tool.name}</h3>
                        <p>${tool.description}</p>
                        <div class="tool-actions">
                            <a href="${tool.url}" class="tool-link">사용하기 →</a>
                            <button class="favorite-btn active" data-tool-id="${tool.id}">⭐</button>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }
}

// 페이지 로드 시 즐겨찾기 매니저 초기화
document.addEventListener('DOMContentLoaded', () => {
    new FavoritesManager();
}); 