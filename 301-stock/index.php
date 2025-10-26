<!DOCTYPE html>
<html lang="ko">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Googsu Stock Dashboard - 주식 투자 대시보드</title>
    <meta name="description" content="바쁜 회사원을 위한 실시간 주식 투자 대시보드. 투자 적기와 위험요소를 한눈에 파악하세요.">
    <meta property="og:title" content="Googsu Stock Dashboard">
    <meta property="og:description" content="바쁜 회사원을 위한 실시간 주식 투자 대시보드">
    <meta property="og:image" content="https://web.googsu.com/images/stock-dashboard-og-image.png">
    <link rel="icon" type="image/png" href="../images/favicon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .search-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .search-container {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stock-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stock-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .stock-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .stock-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .stock-code {
            background: #f8f9fa;
            color: #6c757d;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .stock-price {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .price-up {
            color: #e74c3c;
        }

        .price-down {
            color: #3498db;
        }

        .price-neutral {
            color: #95a5a6;
        }

        .price-change {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .change-value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .change-percent {
            background: #ecf0f1;
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .analysis-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
        }

        .analysis-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .analysis-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .analysis-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .analysis-good {
            background: #d5f4e6;
            color: #27ae60;
        }

        .analysis-bad {
            background: #fadbd8;
            color: #e74c3c;
        }

        .analysis-neutral {
            background: #f8f9fa;
            color: #6c757d;
        }

        .recommendation {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .recommendation-buy {
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            color: white;
        }

        .recommendation-sell {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            color: white;
        }

        .recommendation-hold {
            background: linear-gradient(45deg, #f39c12, #e67e22);
            color: white;
        }

        .loading {
            text-align: center;
            padding: 50px;
            color: white;
            font-size: 1.2rem;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
        }

        .popular-stocks {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .popular-stocks h3 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 1.3rem;
        }

        .popular-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .popular-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .popular-item:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .remove-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 15px;
            cursor: pointer;
            font-size: 0.8rem;
            margin-left: 10px;
        }

        .remove-btn:hover {
            background: #c0392b;
        }

        /* 차트 모달 스타일 */
        .chart-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .chart-modal-content {
            background-color: white;
            margin: 2% auto;
            padding: 0;
            border-radius: 15px;
            width: 90%;
            max-width: 1000px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .chart-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
        }

        .chart-modal-header h3 {
            margin: 0;
            font-size: 1.3rem;
        }

        .chart-close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .chart-close-btn:hover {
            background-color: rgba(255,255,255,0.2);
        }

        .chart-tabs {
            display: flex;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .chart-tab {
            flex: 1;
            padding: 15px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .chart-tab.active {
            background: white;
            color: #667eea;
            border-bottom: 3px solid #667eea;
        }

        .chart-tab:hover {
            background: #e9ecef;
        }

        .chart-container {
            height: 400px;
            padding: 20px;
        }

        .chart-info {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .chart-info-item {
            text-align: center;
        }

        .chart-info-item .label {
            display: block;
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .chart-info-item .value {
            display: block;
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .chart-info-item .value.positive {
            color: #e74c3c;
        }

        .chart-info-item .value.negative {
            color: #3498db;
        }

        .chart-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .chart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* 알림 스타일 */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
        }

        .notification {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease;
            border-left: 4px solid #667eea;
        }

        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification.hide {
            transform: translateX(100%);
            opacity: 0;
        }

        .notification-content {
            display: flex;
            align-items: center;
            padding: 15px;
            gap: 12px;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .notification-success .notification-icon {
            background: #d5f4e6;
            color: #27ae60;
        }

        .notification-error .notification-icon {
            background: #fadbd8;
            color: #e74c3c;
        }

        .notification-warning .notification-icon {
            background: #fef5e7;
            color: #f39c12;
        }

        .notification-info .notification-icon {
            background: #e3f2fd;
            color: #3498db;
        }

        .notification-buy .notification-icon {
            background: #d5f4e6;
            color: #27ae60;
        }

        .notification-sell .notification-icon {
            background: #fadbd8;
            color: #e74c3c;
        }

        .notification-hold .notification-icon {
            background: #fef5e7;
            color: #f39c12;
        }

        .notification-message {
            flex: 1;
            min-width: 0;
        }

        .notification-text {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .notification-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .notification-close {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .notification-close:hover {
            background: #f8f9fa;
            color: #2c3e50;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .search-container {
                flex-direction: column;
            }

            .search-input {
                min-width: 100%;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .analysis-grid {
                grid-template-columns: 1fr;
            }

            .chart-modal-content {
                width: 95%;
                margin: 5% auto;
            }

            .chart-container {
                height: 300px;
            }

            .chart-info {
                flex-direction: column;
                gap: 15px;
            }

            .notification-container {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-chart-line"></i> Googsu Stock Dashboard</h1>
            <p>바쁜 회사원을 위한 실시간 주식 투자 분석 도구</p>
            <div style="margin-top: 10px; font-size: 0.9rem; opacity: 0.8;">
                <a href="test-api.html" style="color: white; text-decoration: underline; margin-right: 15px;">
                    <i class="fas fa-bug"></i> API 테스트
                </a>
                <span style="color: white;">|</span>
                <span style="margin-left: 15px; color: white;">
                    <i class="fas fa-keyboard"></i> Ctrl+D: 디버그 모드
                </span>
            </div>
        </div>

        <div class="search-section">
            <div class="search-container">
                <input type="text" id="stockSearch" class="search-input" placeholder="종목명 또는 종목코드 입력 (예: 삼성전자, 005930)" />
                <button onclick="searchStock()" class="search-btn">
                    <i class="fas fa-search"></i> 검색
                </button>
            </div>
        </div>

        <div class="popular-stocks">
            <h3><i class="fas fa-star"></i> 인기 종목</h3>
            <div class="popular-list" id="popularStocks">
                <div class="popular-item" onclick="addStock('삼성전자', '005930')">
                    <span>삼성전자 (005930)</span>
                </div>
                <div class="popular-item" onclick="addStock('SK하이닉스', '000660')">
                    <span>SK하이닉스 (000660)</span>
                </div>
                <div class="popular-item" onclick="addStock('LG에너지솔루션', '373220')">
                    <span>LG에너지솔루션 (373220)</span>
                </div>
                <div class="popular-item" onclick="addStock('NAVER', '035420')">
                    <span>NAVER (035420)</span>
                </div>
                <div class="popular-item" onclick="addStock('카카오', '035720')">
                    <span>카카오 (035720)</span>
                </div>
                <div class="popular-item" onclick="addStock('현대차', '005380')">
                    <span>현대차 (005380)</span>
                </div>
            </div>
        </div>

        <div class="dashboard-grid" id="stockDashboard">
            <div class="loading">
                <div class="spinner"></div>
                <p>주식 데이터를 불러오는 중...</p>
            </div>
        </div>
    </div>

    <script>
        // 알림 관리 클래스
        class NotificationManager {
            constructor() {
                this.notifications = [];
                this.maxNotifications = 5;
                this.autoHideDelay = 5000;
            }

            show(message, type = 'info', duration = null) {
                const notification = this.createNotification(message, type);
                this.notifications.push(notification);
                
                if (this.notifications.length > this.maxNotifications) {
                    const oldNotification = this.notifications.shift();
                    oldNotification.remove();
                }
                
                if (duration !== 0) {
                    setTimeout(() => {
                        this.hide(notification);
                    }, duration || this.autoHideDelay);
                }
                
                return notification;
            }

            createNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `notification notification-${type}`;
                
                const icon = this.getIcon(type);
                const timestamp = new Date().toLocaleTimeString('ko-KR', { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                
                notification.innerHTML = `
                    <div class="notification-content">
                        <div class="notification-icon">
                            <i class="fas ${icon}"></i>
                        </div>
                        <div class="notification-message">
                            <div class="notification-text">${message}</div>
                            <div class="notification-time">${timestamp}</div>
                        </div>
                        <button class="notification-close" onclick="notificationManager.hide(this.parentElement.parentElement)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                
                let container = document.getElementById('notification-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'notification-container';
                    container.className = 'notification-container';
                    document.body.appendChild(container);
                }
                
                container.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.add('show');
                }, 10);
                
                return notification;
            }

            hide(notification) {
                if (notification && notification.parentElement) {
                    notification.classList.add('hide');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                        const index = this.notifications.indexOf(notification);
                        if (index > -1) {
                            this.notifications.splice(index, 1);
                        }
                    }, 300);
                }
            }

            getIcon(type) {
                const icons = {
                    'success': 'fa-check-circle',
                    'error': 'fa-exclamation-circle',
                    'warning': 'fa-exclamation-triangle',
                    'info': 'fa-info-circle',
                    'buy': 'fa-arrow-up',
                    'sell': 'fa-arrow-down',
                    'hold': 'fa-pause-circle'
                };
                return icons[type] || 'fa-info-circle';
            }

            showStockAlert(stock, alertType, message) {
                const type = alertType === 'buy' ? 'buy' : alertType === 'sell' ? 'sell' : 'info';
                const fullMessage = `${stock.name} (${stock.code}): ${message}`;
                return this.show(fullMessage, type);
            }

            showPriceAlert(stock, oldPrice, newPrice) {
                const change = newPrice - oldPrice;
                const changePercent = ((change / oldPrice) * 100).toFixed(2);
                const isPositive = change > 0;
                
                const message = `가격 변동: ${isPositive ? '+' : ''}${change.toLocaleString()}원 (${isPositive ? '+' : ''}${changePercent}%)`;
                const type = isPositive ? 'success' : 'error';
                
                return this.showStockAlert(stock, type, message);
            }

            showRecommendationAlert(stock, oldRecommendation, newRecommendation) {
                const recommendationText = {
                    'buy': '매수 추천',
                    'sell': '매도 추천',
                    'hold': '관망 추천'
                };
                
                const message = `투자 추천 변경: ${recommendationText[oldRecommendation]} → ${recommendationText[newRecommendation]}`;
                return this.showStockAlert(stock, newRecommendation, message);
            }

            showVolumeAlert(stock, volumeRatio) {
                const message = `거래량 급증: 평균 대비 ${volumeRatio.toFixed(1)}배`;
                return this.showStockAlert(stock, 'warning', message);
            }

            showRSIAlert(stock, rsi) {
                let message, type;
                if (rsi > 80) {
                    message = `RSI 과매수: ${rsi.toFixed(1)} (매도 고려)`;
                    type = 'sell';
                } else if (rsi < 20) {
                    message = `RSI 과매도: ${rsi.toFixed(1)} (매수 기회)`;
                    type = 'buy';
                } else {
                    return null;
                }
                
                return this.showStockAlert(stock, type, message);
            }
        }

        // 차트 모달 클래스 (간단 버전)
        class ChartModal {
            constructor() {
                this.modal = null;
                this.currentChart = null;
            }

            show(stockData) {
                this.createModal(stockData);
                this.modal.style.display = 'block';
            }

            hide() {
                if (this.modal) {
                    this.modal.style.display = 'none';
                    if (this.currentChart) {
                        this.currentChart.destroy();
                        this.currentChart = null;
                    }
                }
            }

            createModal(stockData) {
                if (this.modal) {
                    this.modal.remove();
                }

                this.modal = document.createElement('div');
                this.modal.className = 'chart-modal';
                this.modal.innerHTML = `
                    <div class="chart-modal-content">
                        <div class="chart-modal-header">
                            <h3>${stockData.name} (${stockData.code}) 차트 분석</h3>
                            <button class="chart-close-btn" onclick="chartModal.hide()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="chart-container">
                            <canvas id="stockChartCanvas"></canvas>
                        </div>
                        <div class="chart-info">
                            <div class="chart-info-item">
                                <span class="label">현재가:</span>
                                <span class="value">${stockData.price.toLocaleString()}원</span>
                            </div>
                            <div class="chart-info-item">
                                <span class="label">등락률:</span>
                                <span class="value ${stockData.change > 0 ? 'positive' : 'negative'}">
                                    ${stockData.change > 0 ? '+' : ''}${stockData.changePercent.toFixed(2)}%
                                </span>
                            </div>
                            <div class="chart-info-item">
                                <span class="label">거래량:</span>
                                <span class="value">${stockData.volume ? stockData.volume.toLocaleString() : 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                `;

                document.body.appendChild(this.modal);
                
                // 간단한 차트 생성
                this.createSimpleChart(stockData);
            }

            createSimpleChart(stockData) {
                const canvas = document.getElementById('stockChartCanvas');
                if (!canvas) return;

                const ctx = canvas.getContext('2d');
                const data = this.generateMockData(stockData);
                
                this.currentChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: '주가',
                            data: data.prices,
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                }
                            }
                        }
                    }
                });
            }

            generateMockData(stockData) {
                const labels = [];
                const prices = [];
                const basePrice = stockData.price;
                
                for (let i = 29; i >= 0; i--) {
                    const date = new Date();
                    date.setDate(date.getDate() - i);
                    labels.push(date.toLocaleDateString('ko-KR', { month: 'short', day: 'numeric' }));
                    
                    const variation = (Math.random() - 0.5) * 0.1;
                    const price = basePrice * (1 + variation);
                    prices.push(Math.round(price));
                }
                
                return { labels, prices };
            }
        }

        // 전역 인스턴스 생성
        let notificationManager = new NotificationManager();
        let chartModal = new ChartModal();

        // 전역 변수
        let watchedStocks = new Map();
        let updateInterval;
        let debugMode = false; // 디버그 모드 토글

        // 페이지 로드 시 초기화
        document.addEventListener('DOMContentLoaded', function() {
            loadWatchedStocks();
            startRealTimeUpdates();
            
            // API 연결 테스트
            testApiConnection();
            
            // 웰컴 메시지 표시
            setTimeout(() => {
                notificationManager.show('Googsu Stock Dashboard에 오신 것을 환영합니다! 🎉', 'info', 3000);
            }, 1000);

            // 디버그 모드 토글 (Ctrl+D)
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'd') {
                    debugMode = !debugMode;
                    notificationManager.show(`디버그 모드: ${debugMode ? 'ON' : 'OFF'}`, 'info', 2000);
                    console.log('디버그 모드:', debugMode);
                }
            });
        });

        // 검색 기능
        async function searchStock() {
            const searchTerm = document.getElementById('stockSearch').value.trim();
            if (!searchTerm) {
                notificationManager.show('종목명 또는 종목코드를 입력해주세요.', 'warning');
                return;
            }

            try {
                if (debugMode) console.log(`검색 시작: ${searchTerm}`);
                const url = `api/stock-api.php?action=search&query=${encodeURIComponent(searchTerm)}`;
                if (debugMode) console.log('요청 URL:', url);
                
                const response = await fetch(url);
                
                if (debugMode) console.log('응답 상태:', response.status, response.statusText);
                
                if (!response.ok) {
                    throw new Error(`HTTP 오류: ${response.status} ${response.statusText}`);
                }
                
                const result = await response.json();
                if (debugMode) console.log('검색 결과:', result);
                
                if (result.success && result.data.length > 0) {
                    // 검색 결과가 있으면 첫 번째 결과를 대시보드에 추가
                    const stock = result.data[0];
                    await addStockToDashboard(stock);
                    notificationManager.show(`검색 결과: ${stock.name} (${stock.code})`, 'success', 2000);
                } else {
                    notificationManager.show('검색 결과가 없습니다. 다른 키워드로 시도해보세요.', 'warning');
                }
            } catch (error) {
                console.error('검색 오류:', error);
                notificationManager.show(`검색 중 오류가 발생했습니다: ${error.message}`, 'error');
            }
            
            document.getElementById('stockSearch').value = '';
        }

        // 인기 종목 추가
        async function addStock(name, code) {
            try {
                console.log(`주가 조회 시작: ${name} (${code})`);
                const response = await fetch(`api/stock-api.php?action=price&code=${code}`);
                
                if (!response.ok) {
                    throw new Error(`HTTP 오류: ${response.status} ${response.statusText}`);
                }
                
                const result = await response.json();
                console.log('API 응답:', result);
                
                if (result.success) {
                    await addStockToDashboard(result.data);
                    notificationManager.show(`${name} 주가 정보를 성공적으로 가져왔습니다.`, 'success', 2000);
                } else {
                    console.error('주가 조회 오류:', result);
                    notificationManager.show(`주가 조회 실패: ${result.message}`, 'error');
                }
            } catch (error) {
                console.error('API 호출 오류:', error);
                notificationManager.show(`주가 정보를 가져오는 중 오류가 발생했습니다: ${error.message}`, 'error');
            }
        }

        // 대시보드에 종목 추가
        async function addStockToDashboard(stock) {
            if (watchedStocks.has(stock.code)) {
                alert('이미 관심 종목에 추가된 주식입니다.');
                return;
            }

            // 투자 분석 데이터 가져오기
            try {
                const analysisResponse = await fetch(`api/stock-api.php?action=analysis&code=${stock.code}`);
                const analysisResult = await analysisResponse.json();
                
                if (analysisResult.success) {
                    stock.analysis = analysisResult.data;
                }
            } catch (error) {
                console.error('분석 데이터 조회 오류:', error);
            }

            watchedStocks.set(stock.code, stock);
            renderDashboard();
            saveWatchedStocks();
        }

        // 대시보드 렌더링
        function renderDashboard() {
            const dashboard = document.getElementById('stockDashboard');
            
            if (watchedStocks.size === 0) {
                dashboard.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 50px; color: white;">
                        <i class="fas fa-chart-line" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.5;"></i>
                        <h3>관심 종목을 추가해보세요</h3>
                        <p>위의 검색창이나 인기 종목을 클릭하여 주식을 추가할 수 있습니다.</p>
                    </div>
                `;
                return;
            }

            let html = '';
            for (let [code, stock] of watchedStocks) {
                html += createStockCard(stock);
            }
            dashboard.innerHTML = html;
        }

        // 주식 카드 생성
        function createStockCard(stock) {
            const isPositive = stock.change > 0;
            const isNegative = stock.change < 0;
            const priceClass = isPositive ? 'price-up' : isNegative ? 'price-down' : 'price-neutral';
            const changeClass = isPositive ? 'analysis-good' : isNegative ? 'analysis-bad' : 'analysis-neutral';
            const changeIcon = isPositive ? 'fa-arrow-up' : isNegative ? 'fa-arrow-down' : 'fa-minus';
            
            // 투자 분석 데이터 사용 (API에서 가져온 데이터 또는 기본값)
            const analysis = stock.analysis || analyzeStock(stock);
            
            return `
                <div class="stock-card">
                    <div class="stock-header">
                        <div>
                            <div class="stock-name">${stock.name}</div>
                            <div class="stock-code">${stock.code}</div>
                        </div>
                        <button class="remove-btn" onclick="removeStock('${stock.code}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="stock-price ${priceClass}">
                        ${stock.price.toLocaleString()}원
                    </div>
                    
                    <div class="price-change">
                        <i class="fas ${changeIcon}"></i>
                        <span class="change-value ${priceClass}">
                            ${isPositive ? '+' : ''}${stock.change.toLocaleString()}원
                        </span>
                        <span class="change-percent ${changeClass}">
                            ${isPositive ? '+' : ''}${stock.changePercent.toFixed(2)}%
                        </span>
                    </div>
                    
                    <div class="analysis-section">
                        <div class="analysis-title">
                            <i class="fas fa-chart-bar"></i> 투자 분석
                        </div>
                        <div class="analysis-grid">
                            ${analysis.factors ? analysis.factors.map(factor => `
                                <div class="analysis-item ${factor.type === 'good' ? 'analysis-good' : factor.type === 'bad' ? 'analysis-bad' : 'analysis-neutral'}">
                                    <i class="fas ${getFactorIcon(factor.text)}"></i>
                                    <span>${factor.text}</span>
                                </div>
                            `).join('') : `
                                <div class="analysis-item ${analysis.technical > 0 ? 'analysis-good' : analysis.technical < 0 ? 'analysis-bad' : 'analysis-neutral'}">
                                    <i class="fas fa-chart-line"></i>
                                    <span>기술적 분석: ${analysis.technical > 0 ? '긍정적' : analysis.technical < 0 ? '부정적' : '중립'}</span>
                                </div>
                                <div class="analysis-item ${analysis.volume > 0 ? 'analysis-good' : analysis.volume < 0 ? 'analysis-bad' : 'analysis-neutral'}">
                                    <i class="fas fa-chart-area"></i>
                                    <span>거래량: ${analysis.volume > 0 ? '증가' : analysis.volume < 0 ? '감소' : '보통'}</span>
                                </div>
                                <div class="analysis-item ${analysis.momentum > 0 ? 'analysis-good' : analysis.momentum < 0 ? 'analysis-bad' : 'analysis-neutral'}">
                                    <i class="fas fa-bolt"></i>
                                    <span>모멘텀: ${analysis.momentum > 0 ? '강함' : analysis.momentum < 0 ? '약함' : '보통'}</span>
                                </div>
                                <div class="analysis-item ${analysis.volatility > 0 ? 'analysis-bad' : 'analysis-good'}">
                                    <i class="fas fa-wave-square"></i>
                                    <span>변동성: ${analysis.volatility > 0 ? '높음' : '낮음'}</span>
                                </div>
                            `}
                        </div>
                        
                        <div class="recommendation recommendation-${analysis.recommendation}">
                            <i class="fas fa-lightbulb"></i>
                            ${analysis.recommendation === 'buy' ? '매수 추천' : analysis.recommendation === 'sell' ? '매도 추천' : '관망 추천'}
                            ${analysis.confidence ? ` (신뢰도: ${analysis.confidence}%)` : ''}
                        </div>
                        
                        <button class="chart-btn" onclick="chartModal.show(${JSON.stringify(stock).replace(/"/g, '&quot;')})">
                            <i class="fas fa-chart-line"></i> 상세 차트 보기
                        </button>
                    </div>
                </div>
            `;
        }

        // 분석 요소 아이콘 매핑
        function getFactorIcon(text) {
            if (text.includes('RSI')) return 'fa-chart-line';
            if (text.includes('이동평균') || text.includes('추세')) return 'fa-chart-area';
            if (text.includes('거래량')) return 'fa-chart-bar';
            if (text.includes('변동성')) return 'fa-wave-square';
            if (text.includes('MACD')) return 'fa-chart-pie';
            return 'fa-info-circle';
        }

        // 주식 분석 (모의 알고리즘)
        function analyzeStock(stock) {
            const technical = Math.random() - 0.5; // -0.5 ~ 0.5
            const volume = Math.random() - 0.5;
            const momentum = Math.random() - 0.5;
            const volatility = Math.random();
            
            let recommendation = 'hold';
            if (technical > 0.3 && volume > 0.2 && momentum > 0.2 && volatility < 0.5) {
                recommendation = 'buy';
            } else if (technical < -0.3 || volatility > 0.8) {
                recommendation = 'sell';
            }
            
            return {
                technical: technical,
                volume: volume,
                momentum: momentum,
                volatility: volatility,
                recommendation: recommendation
            };
        }

        // 종목 제거
        function removeStock(code) {
            if (confirm('이 종목을 관심 종목에서 제거하시겠습니까?')) {
                watchedStocks.delete(code);
                renderDashboard();
                saveWatchedStocks();
            }
        }

        // 관심 종목 저장
        function saveWatchedStocks() {
            const stocksArray = Array.from(watchedStocks.values());
            localStorage.setItem('watchedStocks', JSON.stringify(stocksArray));
        }

        // 관심 종목 불러오기
        function loadWatchedStocks() {
            const saved = localStorage.getItem('watchedStocks');
            if (saved) {
                const stocksArray = JSON.parse(saved);
                watchedStocks = new Map(stocksArray.map(stock => [stock.code, stock]));
                renderDashboard();
            }
        }

        // 실시간 업데이트 시작
        function startRealTimeUpdates() {
            updateInterval = setInterval(() => {
                updateStockPrices();
            }, 30000); // 30초마다 업데이트
        }

        // 디바운싱 함수
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // 검색 디바운싱
        const debouncedSearch = debounce(searchStock, 500);

        // API 연결 테스트
        async function testApiConnection() {
            try {
                console.log('API 연결 테스트 시작...');
                const response = await fetch('api/stock-api.php?action=test');
                
                if (!response.ok) {
                    throw new Error(`HTTP 오류: ${response.status} ${response.statusText}`);
                }
                
                const result = await response.json();
                console.log('API 테스트 결과:', result);
                
                if (result.success) {
                    console.log('✅ API 연결 성공');
                } else {
                    console.error('❌ API 연결 실패:', result.message);
                    notificationManager.show('API 연결에 문제가 있습니다. 페이지를 새로고침해주세요.', 'warning');
                }
            } catch (error) {
                console.error('❌ API 연결 오류:', error);
                notificationManager.show(`API 연결 오류: ${error.message}`, 'error');
            }
        }

        // 주가 업데이트 (실제 API 호출)
        async function updateStockPrices() {
            if (watchedStocks.size === 0) return;
            
            const codes = Array.from(watchedStocks.keys());
            try {
                const response = await fetch(`api/stock-api.php?action=prices&codes=${codes.join(',')}`);
                const result = await response.json();
                
                if (result.success) {
                    for (let priceData of result.data) {
                        if (watchedStocks.has(priceData.code)) {
                            const stock = watchedStocks.get(priceData.code);
                            const oldPrice = stock.price;
                            const oldRecommendation = stock.analysis ? stock.analysis.recommendation : null;
                            
                            // 가격 정보 업데이트
                            stock.price = priceData.price;
                            stock.change = priceData.change;
                            stock.changePercent = priceData.changePercent;
                            stock.volume = priceData.volume;
                            stock.high = priceData.high;
                            stock.low = priceData.low;
                            stock.timestamp = priceData.timestamp;
                            
                            // 가격 변동 알림 (5% 이상 변동 시)
                            if (Math.abs(stock.changePercent) >= 5) {
                                notificationManager.showPriceAlert(stock, oldPrice, stock.price);
                            }
                            
                            // 새로운 분석 데이터 가져오기
                            try {
                                const analysisResponse = await fetch(`api/stock-api.php?action=analysis&code=${priceData.code}`);
                                const analysisResult = await analysisResponse.json();
                                
                                if (analysisResult.success) {
                                    const newRecommendation = analysisResult.data.recommendation;
                                    
                                    // 추천 변경 알림
                                    if (oldRecommendation && oldRecommendation !== newRecommendation) {
                                        notificationManager.showRecommendationAlert(stock, oldRecommendation, newRecommendation);
                                    }
                                    
                                    // RSI 극값 알림
                                    if (analysisResult.data.technical && analysisResult.data.technical.rsi) {
                                        notificationManager.showRSIAlert(stock, analysisResult.data.technical.rsi);
                                    }
                                    
                                    // 거래량 급증 알림
                                    if (analysisResult.data.technical && analysisResult.data.technical.volumeRatio > 2) {
                                        notificationManager.showVolumeAlert(stock, analysisResult.data.technical.volumeRatio);
                                    }
                                    
                                    stock.analysis = analysisResult.data;
                                }
                            } catch (error) {
                                console.error('분석 데이터 조회 오류:', error);
                            }
                            
                            watchedStocks.set(priceData.code, stock);
                        }
                    }
                    renderDashboard();
                    saveWatchedStocks();
                }
            } catch (error) {
                console.error('주가 업데이트 오류:', error);
                notificationManager.show('주가 업데이트 중 오류가 발생했습니다.', 'error');
            }
        }

        // 검색 입력 이벤트
        document.getElementById('stockSearch').addEventListener('input', function(e) {
            if (e.target.value.trim().length > 2) {
                debouncedSearch();
            }
        });

        // 엔터키로 검색
        document.getElementById('stockSearch').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchStock();
            }
        });

        // 페이지 언로드 시 정리
        window.addEventListener('beforeunload', function() {
            if (updateInterval) {
                clearInterval(updateInterval);
            }
        });

        // 모달 외부 클릭 시 닫기
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('chart-modal')) {
                chartModal.hide();
            }
        });

        // ESC 키로 모달 닫기
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                chartModal.hide();
            }
        });
    </script>
    </body>
</html>

