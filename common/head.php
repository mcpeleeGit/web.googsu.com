<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="icon" href="/images/favicon.png" type="image/png">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f5f5f5;
    }

    .container {
        width: 1024px;
        height: 900px;
        background-color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .menu-area {
        height: 60px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        padding: 0 20px;
        background: white;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 10;
    }

    footer {
        height: 60px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        padding: 0 20px;
        background: white;
        font-size: 0.85em;
    }    

    .content-area {
        flex: 1;
        padding: 20px;
        margin-top: 60px;
        overflow-y: auto;
        height: calc(100% - 60px);
    }

    .home-icon {
        font-size: 24px;
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .home-icon:hover {
        color: #007bff;
    }

    .menu-icon {
        margin-left: 20px;
        font-size: 24px;
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .menu-icon:hover {
        color: #007bff;
    }

    /* 드롭다운 메뉴 스타일 수정 */
    .dropdown {
        position: relative;
    }

    .dropdown-content {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: white;
        min-width: 200px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        display: none;
        z-index: 1000;
    }

    /* hover 스타일 제거하고 active 클래스로 대체 */
    .dropdown.active .dropdown-content {
        display: block;
        z-index: 1000;
    }

    .dropdown-content a {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        color: #333;
        text-decoration: none;
        transition: background-color 0.2s;
        white-space: nowrap;
    }

    .dropdown-content a:hover {
        background-color: #f8f9fa;
    }

    .dropdown-content i {
        width: 24px;
        margin-right: 10px;
    }

    /* 모바일에서 드롭다운 화살표 표시 */
    @media (max-width: 768px) {
        .dropdown > a::after {
            content: '▼';
            font-size: 12px;
            margin-left: 5px;
        }
    }
</style> 