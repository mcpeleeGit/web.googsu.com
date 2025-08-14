<?php
require(__DIR__ . '/../../api/common/route.php');
Route::init($_SERVER['REQUEST_URI']);

$search_results = [];
$search_type = 'web';
$query = '';
$error_message = '';

if (isset($_POST['search']) && !empty($_POST['query'])) {
    $query = trim($_POST['query']);
    $search_type = $_POST['search_type'] ?? 'web';
    
    $api_key = '1805ae3954ee7dcb64bd017be06eb477';
    $base_url = 'https://dapi.kakao.com/v2/search/';
    
    $endpoints = [
        'web' => 'web',
        'video' => 'vclip',
        'image' => 'image',
        'blog' => 'blog',
        'book' => 'web', // 책 검색은 웹문서 검색으로 대체
        'cafe' => 'cafe'
    ];
    
    // 디버깅을 위한 로그
    error_log("Search type: " . $search_type . ", Endpoint: " . $endpoints[$search_type]);
    
    $endpoint = $endpoints[$search_type];
    
    // 책 검색일 경우 검색어에 "책" 키워드 추가
    if ($search_type === 'book') {
        $query = $query . ' 책';
    }
    
    $url = $base_url . $endpoint . '?query=' . urlencode($query) . '&size=20';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: KakaoAK ' . $api_key
    ]);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code === 200) {
        $data = json_decode($response, true);
        if ($data && isset($data['documents'])) {
            $search_results = $data['documents'];
        } else {
            $error_message = 'API 응답 데이터 형식이 올바르지 않습니다. 응답: ' . substr($response, 0, 200);
        }
    } else {
        $error_message = 'API 호출 중 오류가 발생했습니다. (HTTP 코드: ' . $http_code . ') URL: ' . $url . ' 응답: ' . substr($response, 0, 200);
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>다음 검색 API - 종합 검색</title>
    <?php include '../../common/head.php'; ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        .search-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            overflow: hidden;
            margin-top: 20px;
        }
        
        .search-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .search-title {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .search-subtitle {
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .search-form {
            padding: 40px;
            background: #f8f9fa;
        }
        
        .search-input-group {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
        }
        
        .search-input {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            font-size: 1.1em;
            outline: none;
            transition: border-color 0.3s ease;
        }
        
        .search-input:focus {
            border-color: #28a745;
        }
        
        .search-type-select {
            padding: 15px 20px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            font-size: 1.1em;
            background: white;
            cursor: pointer;
        }
        
        .search-button {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .search-results {
            padding: 40px;
        }
        
        .results-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .results-title {
            font-size: 1.8em;
            color: #495057;
            margin-bottom: 10px;
        }
        
        .results-count {
            color: #6c757d;
            font-size: 1.1em;
        }
        
        .result-item {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .result-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: #28a745;
        }
        
        .result-title {
            font-size: 1.3em;
            color: #1971c2;
            margin-bottom: 10px;
            text-decoration: none;
            display: block;
        }
        
        .result-title:hover {
            color: #1864ab;
            text-decoration: underline;
        }
        
        .result-content {
            color: #495057;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .result-meta {
            display: flex;
            gap: 20px;
            color: #6c757d;
            font-size: 0.9em;
            flex-wrap: wrap;
        }
        
        .result-url {
            color: #28a745;
            text-decoration: none;
            word-break: break-all;
        }
        
        .result-url:hover {
            text-decoration: underline;
        }
        
        .result-thumbnail {
            max-width: 300px;
            max-height: 200px;
            border-radius: 12px;
            margin: 15px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        
        .result-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .thumbnail-container {
            display: flex;
            gap: 15px;
            align-items: flex-start;
            margin: 15px 0;
        }
        
        .thumbnail-main {
            flex-shrink: 0;
        }
        
        .content-with-thumbnail {
            flex: 1;
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .no-results i {
            font-size: 4em;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .search-types-info {
            background: #e8f5e8;
            border: 1px solid #c3e6cb;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .search-types-info h3 {
            color: #155724;
            margin-bottom: 15px;
        }
        
        .search-types-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .search-type-info {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        
        .search-type-info h4 {
            color: #28a745;
            margin-bottom: 8px;
            font-size: 1em;
        }
        
        .search-type-info p {
            color: #6c757d;
            font-size: 0.9em;
            margin: 0;
        }
        
        @media (max-width: 768px) {
            .search-input-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input, .search-type-select, .search-button {
                width: 100%;
            }
            
            .search-header {
                padding: 30px 20px;
            }
            
            .search-title {
                font-size: 2em;
            }
            
            .search-form, .search-results {
                padding: 20px;
            }
            
            .result-meta {
                flex-direction: column;
                gap: 10px;
            }
            
            .thumbnail-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .result-thumbnail {
                max-width: 100%;
                max-height: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="search-container">
        <div class="search-header">
            <h1 class="search-title">🔍 다음 검색 API</h1>
            <p class="search-subtitle">카카오 다음 검색 API를 활용한 종합 검색 서비스</p>
        </div>
        
        <div class="search-form">
            <form method="post">
                <div class="search-input-group">
                    <input type="text" name="query" class="search-input" placeholder="검색어를 입력하세요..." value="<?= htmlspecialchars($query) ?>" required>
                    <select name="search_type" class="search-type-select">
                        <option value="web" <?= $search_type === 'web' ? 'selected' : '' ?>>웹문서</option>
                        <option value="video" <?= $search_type === 'video' ? 'selected' : '' ?>>동영상</option>
                        <option value="image" <?= $search_type === 'image' ? 'selected' : '' ?>>이미지</option>
                        <option value="blog" <?= $search_type === 'blog' ? 'selected' : '' ?>>블로그</option>
                        <option value="book" <?= $search_type === 'book' ? 'selected' : '' ?>>책</option>
                        <option value="cafe" <?= $search_type === 'cafe' ? 'selected' : '' ?>>카페</option>
                    </select>
                    <button type="submit" name="search" class="search-button">
                        <i class="fas fa-search"></i> 검색
                    </button>
                </div>
            </form>
            
            <div class="search-types-info">
                <h3>📚 검색 유형별 특징</h3>
                <div class="search-types-list">
                    <div class="search-type-info">
                        <h4>🌐 웹문서</h4>
                        <p>웹사이트와 문서를 검색합니다. 가장 포괄적인 검색 결과를 제공합니다.</p>
                    </div>
                    <div class="search-type-info">
                        <h4>🎥 동영상</h4>
                        <p>동영상 콘텐츠를 검색합니다. 썸네일과 재생 시간 정보를 제공합니다.</p>
                    </div>
                    <div class="search-type-info">
                        <h4>🖼️ 이미지</h4>
                        <p>이미지 파일을 검색합니다. 고화질 썸네일과 이미지 정보를 제공합니다.</p>
                    </div>
                    <div class="search-type-info">
                        <h4>📝 블로그</h4>
                        <p>블로그 포스트를 검색합니다. 최신 블로그 콘텐츠를 찾을 수 있습니다.</p>
                    </div>
                    <div class="search-type-info">
                        <h4>📖 책</h4>
                        <p>도서 관련 웹문서를 검색합니다. 책 정보, 서평, 구매 링크 등을 찾을 수 있습니다.</p>
                    </div>
                    <div class="search-type-info">
                        <h4>☕ 카페</h4>
                        <p>다음 카페 게시물을 검색합니다. 커뮤니티 콘텐츠를 찾을 수 있습니다.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($search_results)): ?>
            <div class="search-results">
                <div class="results-header">
                    <h2 class="results-title">검색 결과</h2>
                    <p class="results-count">"<?= htmlspecialchars($query) ?>"에 대한 <?= $search_type ?> 검색 결과 (<?= count($search_results) ?>개)</p>
                </div>
                
                <?php foreach ($search_results as $result): ?>
                    <div class="result-item">
                        <?php if ($search_type === 'web'): ?>
                            <a href="<?= htmlspecialchars($result['url'] ?? '#') ?>" class="result-title" target="_blank">
                                <?= htmlspecialchars(strip_tags($result['title'] ?? '제목 없음')) ?>
                            </a>
                            <div class="result-content"><?= htmlspecialchars(strip_tags($result['contents'] ?? '내용 없음')) ?></div>
                            <div class="result-meta">
                                <span><i class="fas fa-link"></i> <a href="<?= htmlspecialchars($result['url'] ?? '#') ?>" class="result-url" target="_blank"><?= htmlspecialchars($result['url'] ?? 'URL 없음') ?></a></span>
                                <span><i class="fas fa-calendar"></i> <?= isset($result['datetime']) ? date('Y-m-d H:i', strtotime($result['datetime'])) : '날짜 정보 없음' ?></span>
                            </div>
                            
                        <?php elseif ($search_type === 'video'): ?>
                            <a href="<?= htmlspecialchars($result['url']) ?>" class="result-title" target="_blank">
                                <?= htmlspecialchars(strip_tags($result['title'])) ?>
                            </a>
                            <div class="thumbnail-container">
                                <?php if (isset($result['thumbnail'])): ?>
                                    <div class="thumbnail-main">
                                        <img src="<?= htmlspecialchars($result['thumbnail']) ?>" alt="동영상 썸네일" class="result-thumbnail" onclick="window.open('<?= htmlspecialchars($result['url']) ?>', '_blank')">
                                    </div>
                                <?php endif; ?>
                                <div class="content-with-thumbnail">
                                    <div class="result-content"><?= htmlspecialchars(strip_tags($result['description'] ?? $result['contents'] ?? '내용 없음')) ?></div>
                                    <div class="result-meta">
                                        <span><i class="fas fa-play"></i> 재생시간: <?= isset($result['duration']) ? $result['duration'] : '정보 없음' ?></span>
                                        <span><i class="fas fa-eye"></i> 조회수: <?= isset($result['view_count']) ? number_format($result['view_count']) : '정보 없음' ?></span>
                                        <span><i class="fas fa-calendar"></i> <?= isset($result['datetime']) ? date('Y-m-d H:i', strtotime($result['datetime'])) : '날짜 정보 없음' ?></span>
                                    </div>
                                </div>
                            </div>
                            
                        <?php elseif ($search_type === 'image'): ?>
                            <a href="<?= htmlspecialchars($result['image_url'] ?? $result['url'] ?? '#') ?>" class="result-title" target="_blank">
                                <?= htmlspecialchars(strip_tags($result['title'] ?? '제목 없음')) ?>
                            </a>
                            <div class="thumbnail-container">
                                <?php if (isset($result['thumbnail_url'])): ?>
                                    <div class="thumbnail-main">
                                        <img src="<?= htmlspecialchars($result['thumbnail_url']) ?>" alt="이미지" class="result-thumbnail" onclick="window.open('<?= htmlspecialchars($result['image_url'] ?? $result['url'] ?? '#') ?>', '_blank')">
                                    </div>
                                <?php endif; ?>
                                <div class="content-with-thumbnail">
                                    <div class="result-meta">
                                        <span><i class="fas fa-image"></i> 크기: <?= isset($result['width']) && isset($result['height']) ? $result['width'] . 'x' . $result['height'] : '정보 없음' ?></span>
                                        <span><i class="fas fa-calendar"></i> <?= isset($result['datetime']) ? date('Y-m-d H:i', strtotime($result['datetime'])) : '날짜 정보 없음' ?></span>
                                    </div>
                                </div>
                            </div>
                            
                        <?php elseif ($search_type === 'blog'): ?>
                            <a href="<?= htmlspecialchars($result['url'] ?? '#') ?>" class="result-title" target="_blank">
                                <?= htmlspecialchars(strip_tags($result['title'] ?? '제목 없음')) ?>
                            </a>
                            <div class="result-content"><?= htmlspecialchars(strip_tags($result['contents'] ?? '내용 없음')) ?></div>
                            <div class="result-meta">
                                <span><i class="fas fa-user"></i> 작성자: <?= htmlspecialchars($result['blogname'] ?? '작성자 정보 없음') ?></span>
                                <span><i class="fas fa-calendar"></i> <?= isset($result['datetime']) ? date('Y-m-d H:i', strtotime($result['datetime'])) : '날짜 정보 없음' ?></span>
                            </div>
                            
                        <?php elseif ($search_type === 'book'): ?>
                            <a href="<?= htmlspecialchars($result['url'] ?? '#') ?>" class="result-title" target="_blank">
                                <?= htmlspecialchars(strip_tags($result['title'] ?? '제목 없음')) ?>
                            </a>
                            <div class="result-content"><?= htmlspecialchars(strip_tags($result['contents'] ?? '내용 없음')) ?></div>
                            <div class="result-meta">
                                <span><i class="fas fa-link"></i> <a href="<?= htmlspecialchars($result['url'] ?? '#') ?>" class="result-url" target="_blank"><?= htmlspecialchars($result['url'] ?? 'URL 없음') ?></a></span>
                                <span><i class="fas fa-calendar"></i> <?= isset($result['datetime']) ? date('Y-m-d H:i', strtotime($result['datetime'])) : '날짜 정보 없음' ?></span>
                                <span><i class="fas fa-book"></i> 책 관련 웹문서 검색 결과</span>
                            </div>
                            
                        <?php elseif ($search_type === 'cafe'): ?>
                            <a href="<?= htmlspecialchars($result['url'] ?? '#') ?>" class="result-title" target="_blank">
                                <?= htmlspecialchars(strip_tags($result['title'] ?? '제목 없음')) ?>
                            </a>
                            <div class="result-content"><?= htmlspecialchars(strip_tags($result['contents'] ?? '내용 없음')) ?></div>
                            <div class="result-meta">
                                <span><i class="fas fa-coffee"></i> 카페: <?= htmlspecialchars($result['cafename'] ?? '카페 정보 없음') ?></span>
                                <span><i class="fas fa-calendar"></i> <?= isset($result['datetime']) ? date('Y-m-d H:i', strtotime($result['datetime'])) : '날짜 정보 없음' ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif (!empty($query)): ?>
            <div class="no-results">
                <i class="fas fa-search"></i>
                <h3>검색 결과가 없습니다</h3>
                <p>"<?= htmlspecialchars($query) ?>"에 대한 <?= $search_type ?> 검색 결과를 찾을 수 없습니다.</p>
                <p>다른 검색어나 검색 유형을 시도해보세요.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
