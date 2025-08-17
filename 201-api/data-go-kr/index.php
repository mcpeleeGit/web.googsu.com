<?php
require(__DIR__ . '/../../api/common/route.php');
Route::init($_SERVER['REQUEST_URI']);

// API 키 설정 (실제 운영환경에서는 환경변수나 설정 파일 사용)
$API_KEYS = [
    'women-family' => 'zva3%2Fdp1gXxyS%2BhepqopjmT7AJrKytHhRTg%2FUpforAZ0enJxnLJdqW5f9u8Y2Ya%2FeQUhXJGoOmWFEaoFCyezjw%3D%3D'
];

// API 호출 함수
function callDataGoKrAPI($apiType, $params = []) {
    global $API_KEYS;
    
    if (!isset($API_KEYS[$apiType])) {
        return ['error' => 'API 키를 찾을 수 없습니다.'];
    }
    
    $baseUrl = '';
    $serviceKey = $API_KEYS[$apiType];
    
    $possibleUrls = [];
    switch ($apiType) {
        case 'women-family':
            $possibleUrls = [
                'https://apis.data.go.kr/1383000/stis/srvyCrBrkMcrDataService/getServeyCareerBreakTargetList'
            ];
            break;
        default:
            return ['error' => '지원하지 않는 API 타입입니다.'];
    }
    
    // 기본 파라미터 설정 (Data.go.kr API 표준)
    $defaultParams = [
        'serviceKey' => $serviceKey,
        'type' => 'json',
        'numOfRows' => 10,
        'pageNo' => 1,
        'fctExmnYr' => '2019'  // 실태조사연도 (필수 파라미터)
    ];
    
    // 사용자 파라미터와 병합
    $params = array_merge($defaultParams, $params);
    
    // 여러 URL을 시도
    foreach ($possibleUrls as $baseUrl) {
        $url = $baseUrl . '?' . http_build_query($params);
        
        // 디버깅을 위한 로그
        error_log("Data.go.kr API 호출 시도: " . $url);
        
        // cURL을 사용한 API 호출
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json, text/plain, */*',
            'Accept-Language: ko-KR,ko;q=0.9,en;q=0.8',
            'Cache-Control: no-cache',
            'Pragma: no-cache'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        // 디버깅 정보 로깅
        error_log("cURL 정보: URL: $baseUrl, HTTP Code: $httpCode, Error: $error, Response Length: " . strlen($response));
        
        if ($error) {
            continue; // 다음 URL 시도
        }
        
        // HTTP 상태 코드 확인
        if ($httpCode === 200) {
            if (empty($response)) {
                continue; // 응답이 비어있으면 다음 URL 시도
            }
            
            // JSON 응답 파싱
            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                continue; // JSON 파싱 실패하면 다음 URL 시도
            }
            
            // 성공한 경우
            return [
                'success' => true,
                'data' => $data,
                'url' => $url,
                'httpCode' => $httpCode,
                'response_length' => strlen($response),
                'working_url' => $baseUrl
            ];
        }
        
        // SOAP 오류인지 확인
        if (strpos($response, 'soapenv:Envelope') !== false) {
            $soapError = parseSOAPError($response);
            error_log("SOAP 오류 발생: " . json_encode($soapError));
            continue; // 다음 URL 시도
        }
    }
    
    // 모든 URL 시도 실패
    return [
        'error' => '모든 API 엔드포인트 시도 실패',
        'tried_urls' => $possibleUrls,
        'last_response' => $response ?? '응답 없음',
        'last_http_code' => $httpCode ?? 'HTTP 코드 없음',
        'suggestion' => 'Data.go.kr 공식 문서에서 정확한 API 엔드포인트를 확인해주세요.'
    ];
}

// SOAP 오류 파싱 함수
function parseSOAPError($soapResponse) {
    $error = [];
    
    // faultcode 추출
    if (preg_match('/<faultcode>(.*?)<\/faultcode>/', $soapResponse, $matches)) {
        $error['faultcode'] = $matches[1];
    }
    
    // faultstring 추출
    if (preg_match('/<faultstring>(.*?)<\/faultstring>/', $soapResponse, $matches)) {
        $error['faultstring'] = $matches[1];
    }
    
    // detail 메시지 추출
    if (preg_match('/status="([^"]*)"/', $soapResponse, $matches)) {
        $error['detail'] = $matches[1];
    }
    
    return $error;
}

// AJAX 요청 처리
if (isset($_POST['action']) && $_POST['action'] === 'test_api') {
    $apiType = $_POST['api_type'] ?? '';
    $params = [];
    
    // POST 파라미터에서 필요한 값들 추출
    if (isset($_POST['fctExmnYr'])) {
        $params['fctExmnYr'] = $_POST['fctExmnYr'];
    }
    if (isset($_POST['numOfRows'])) {
        $params['numOfRows'] = $_POST['numOfRows'];
    }
    if (isset($_POST['pageNo'])) {
        $params['pageNo'] = $_POST['pageNo'];
    }
    
    $result = callDataGoKrAPI($apiType, $params);
    
    header('Content-Type: application/json');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Data.go.kr API - 공공데이터포털 API 활용</title>
    <meta name="description" content="Data.go.kr의 다양한 공공데이터 API를 조회하고 활용할 수 있는 서비스입니다.">
    <meta property="og:title" content="Data.go.kr API - 공공데이터포털 API 활용">
    <meta property="og:description" content="Data.go.kr의 다양한 공공데이터 API를 조회하고 활용할 수 있는 서비스입니다.">
    <meta property="og:url" content="https://googsu.com/201-api/data-go-kr">
    <meta property="og:image" content="https://googsu.com/images/tools-og-image.png">
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
        
        .api-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 20px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .home-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .home-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        
        .api-title {
            color: white;
            font-size: 2em;
            font-weight: bold;
            margin: 0;
        }
        
        .api-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 120px 20px 40px;
        }
        
        .api-intro {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .api-intro h2 {
            color: #333;
            font-size: 1.8em;
            margin-bottom: 15px;
        }
        
        .api-intro p {
            color: #666;
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .api-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .api-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .api-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .api-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .api-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8em;
        }
        
        .api-info h3 {
            color: #333;
            font-size: 1.3em;
            margin-bottom: 5px;
        }
        
        .api-info .department {
            color: #666;
            font-size: 0.9em;
            font-weight: 500;
        }
        
        .api-description {
            color: #555;
            font-size: 0.95em;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        
        .api-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9em;
        }
        
        .detail-value {
            color: #666;
            font-size: 0.9em;
            text-align: right;
            max-width: 200px;
            word-break: break-all;
        }
        
        .api-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .action-button {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .action-button.secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }
        
        .action-button.secondary:hover {
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }
        
        .add-api-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 2px dashed #dee2e6;
        }
        
        .add-api-section h3 {
            color: #666;
            font-size: 1.4em;
            margin-bottom: 15px;
        }
        
        .add-api-section p {
            color: #999;
            font-size: 1em;
            margin-bottom: 20px;
        }
        
        .add-api-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .add-api-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .api-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-approved {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        
        .api-test-panel {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .test-panel-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .test-panel-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5em;
        }
        
        .test-panel-title {
            color: #333;
            font-size: 1.4em;
            font-weight: 600;
        }
        
        .test-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9em;
        }
        
        .form-group input, .form-group select {
            padding: 8px 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 0.9em;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .test-button {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 20px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            grid-column: 1 / -1;
            justify-self: center;
        }
        
        .test-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);
        }
        
        .test-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .api-result {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #e9ecef;
            display: none;
        }
        
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .result-title {
            font-weight: 600;
            color: #333;
            font-size: 1.1em;
        }
        
        .result-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
        }
        
        .status-success {
            background: #d4edda;
            color: #155724;
        }
        
        .status-error {
            background: #f8d7da;
            color: #721c24;
        }
        
        .result-content {
            background: white;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e9ecef;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .result-url {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 0.85em;
            word-break: break-all;
            margin-bottom: 15px;
        }
        
        .result-data {
            font-family: monospace;
            font-size: 0.85em;
            white-space: pre-wrap;
            color: #333;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @media (max-width: 768px) {
            .api-container {
                padding: 100px 15px 30px;
            }
            
            .api-list {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .api-card {
                padding: 20px;
            }
            
            .api-actions {
                flex-direction: column;
            }
            
            .action-button {
                text-align: center;
                justify-content: center;
            }
            
            .test-form {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .api-header {
                padding: 15px 0;
            }
            
            .api-title {
                font-size: 1.5em;
            }
            
            .api-card-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .detail-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .detail-value {
                text-align: left;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="api-header">
        <div class="header-container">
            <a href="/201-api" class="home-link">
                <i class="fas fa-arrow-left"></i>
                API 홈으로
            </a>
            <h1 class="api-title">📊 Data.go.kr API</h1>
            <div></div>
        </div>
    </div>
    
    <div class="api-container">
        <div class="api-intro">
            <h2>공공데이터포털 API 활용</h2>
            <p>Data.go.kr에서 제공하는 다양한 공공데이터 API를 조회하고 활용할 수 있습니다.<br>
            정부기관의 공개 데이터를 활용하여 유용한 서비스를 만들어보세요!</p>
        </div>
        
        <!-- API 테스트 패널 -->
        <div class="api-test-panel">
            <div class="test-panel-header">
                <div class="test-panel-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <h3 class="test-panel-title">API 테스트 및 조회</h3>
            </div>
            
            <form id="apiTestForm" class="test-form">
                <div class="form-group">
                    <label for="apiType">API 선택</label>
                    <select id="apiType" name="apiType" required>
                        <option value="">API를 선택하세요</option>
                        <option value="women-family">경력단절여성 경제활동실태조사</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="fctExmnYr">실태조사연도</label>
                    <select id="fctExmnYr" name="fctExmnYr" required>
                        <option value="2019">2019년</option>
                        <option value="2018">2018년</option>
                        <option value="2017">2017년</option>
                        <option value="2016">2016년</option>
                        <option value="2015">2015년</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="numOfRows">조회 건수</label>
                    <select id="numOfRows" name="numOfRows">
                        <option value="5">5건</option>
                        <option value="10" selected>10건</option>
                        <option value="20">20건</option>
                        <option value="50">50건</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="pageNo">페이지 번호</label>
                    <input type="number" id="pageNo" name="pageNo" value="1" min="1" max="100">
                </div>
                
                <button type="submit" class="test-button" id="testButton">
                    <i class="fas fa-play"></i>
                    API 테스트 실행
                </button>
            </form>
            
            <div class="loading" id="loading">
                <div class="spinner"></div>
                <p>API를 호출하고 있습니다...</p>
            </div>
            
            <div class="api-result" id="apiResult">
                <div class="result-header">
                    <span class="result-title">API 호출 결과</span>
                    <span class="result-status" id="resultStatus">성공</span>
                </div>
                <div class="result-content">
                    <div class="result-url" id="resultUrl"></div>
                    <div class="result-data" id="resultData"></div>
                </div>
            </div>
        </div>
        
        <div class="api-list">
            <!-- 여성가족부 경력단절여성 경제활동실태조사 API -->
            <div class="api-card">
                <div class="api-card-header">
                    <div class="api-icon">
                        <i class="fas fa-female"></i>
                    </div>
                    <div class="api-info">
                        <h3>경력단절여성 경제활동실태조사</h3>
                        <div class="department">여성가족부</div>
                    </div>
                </div>
                
                <div class="api-description">
                    경력단절여성의 경제활동 실태를 파악하기 위한 조사 데이터로, 
                    경력단절 현황, 재취업 의향, 경제활동 참여 실태 등을 제공합니다.
                </div>
                
                <div class="api-details">
                    <div class="detail-item">
                        <span class="detail-label">서비스 유형</span>
                        <span class="detail-value">REST API</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">데이터 포맷</span>
                        <span class="detail-value">JSON, XML</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">End Point</span>
                        <span class="detail-value">https://apis.data.go.kr/1383000/stis/srvyCrBrkMcrDataService/getServeyCareerBreakTargetList</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">필수 파라미터</span>
                        <span class="detail-value">ServiceKey, pageNo, numOfRows, type, fctExmnYr</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">심의 여부</span>
                        <span class="detail-value">
                            <span class="api-status status-approved">자동승인</span>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">활용 기간</span>
                        <span class="detail-value">2025-08-15 ~ 2027-08-15</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">처리 상태</span>
                        <span class="detail-value">
                            <span class="api-status status-approved">승인</span>
                        </span>
                    </div>
                </div>
                
                <div class="api-actions">
                    <a href="https://www.data.go.kr/data/15013061/openapi.do" target="_blank" class="action-button">
                        <i class="fas fa-external-link-alt"></i>
                        상세 정보
                    </a>
                    <button class="action-button secondary" onclick="showUsageGuide('women-family')">
                        <i class="fas fa-book"></i>
                        활용 가이드
                    </button>
                </div>
            </div>
            
            <!-- 추가 API 카드들을 위한 확장 가능한 구조 -->
            <div class="api-card">
                <div class="api-card-header">
                    <div class="api-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="api-info">
                        <h3>새로운 API 추가</h3>
                        <div class="department">확장 가능</div>
                    </div>
                </div>
                
                <div class="api-description">
                    Data.go.kr에서 제공하는 다양한 공공데이터 API를 추가하여 
                    더 많은 데이터를 활용할 수 있습니다.
                </div>
                
                <div class="api-details">
                    <div class="detail-item">
                        <span class="detail-label">상태</span>
                        <span class="detail-value">준비 중</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">추가 예정</span>
                        <span class="detail-value">인구통계, 경제지표, 환경데이터 등</span>
                    </div>
                </div>
                
                <div class="api-actions">
                    <button class="action-button secondary" disabled>
                        <i class="fas fa-clock"></i>
                        준비 중
                    </button>
                </div>
            </div>
        </div>
        
        <div class="add-api-section">
            <h3>더 많은 API 추가하기</h3>
            <p>Data.go.kr에서 제공하는 다양한 공공데이터 API를 추가하여 서비스를 확장할 수 있습니다.</p>
            <button class="add-api-button" onclick="showAddAPIModal()">
                <i class="fas fa-plus"></i>
                새 API 추가
            </button>
        </div>
    </div>
    
    <!-- API 활용 가이드 모달 -->
    <div id="apiGuideModal" class="modal" style="display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content" style="background-color: white; margin: 5% auto; padding: 20px; border-radius: 15px; width: 90%; max-width: 600px; max-height: 80%; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 id="guideModalTitle">API 활용 가이드</h3>
                <span onclick="closeGuideModal()" style="cursor: pointer; font-size: 24px; font-weight: bold;">&times;</span>
            </div>
            <div id="guideModalContent">
                <!-- 가이드 내용이 여기에 표시됩니다 -->
            </div>
        </div>
    </div>
    
    <!-- 새 API 추가 모달 -->
    <div id="addAPIModal" class="modal" style="display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content" style="background-color: white; margin: 5% auto; padding: 20px; border-radius: 15px; width: 90%; max-width: 600px; max-height: 80%; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3>새로운 API 추가</h3>
                <span onclick="closeAddAPIModal()" style="cursor: pointer; font-size: 24px; font-weight: bold;">&times;</span>
            </div>
            <div>
                <div style="margin-bottom: 20px;">
                    <h4>➕ 새로운 Data.go.kr API 추가</h4>
                    <p>Data.go.kr에서 제공하는 다양한 공공데이터 API를 추가할 수 있습니다.</p>
                </div>
                <div style="margin-bottom: 20px;">
                    <h4>🔍 추가 가능한 API 카테고리</h4>
                    <ul style="text-align: left; padding-left: 20px;">
                        <li><strong>인구통계:</strong> 인구동향, 가족구조, 출산율 등</li>
                        <li><strong>경제지표:</strong> 소득분배, 소비동향, 고용통계 등</li>
                        <li><strong>환경데이터:</strong> 대기질, 수질, 기상정보 등</li>
                        <li><strong>교통정보:</strong> 교통량, 대중교통, 도로정보 등</li>
                        <li><strong>건강의료:</strong> 질병통계, 의료시설, 건강검진 등</li>
                        <li><strong>교육정보:</strong> 학교현황, 학업성취도, 교육통계 등</li>
                    </ul>
                </div>
                <div style="margin-bottom: 20px;">
                    <h4>📋 추가 방법</h4>
                    <ol style="text-align: left; padding-left: 20px;">
                        <li>Data.go.kr에서 원하는 API 검색</li>
                        <li>API 정보 및 인증키 확인</li>
                        <li>이 페이지에 API 정보 추가</li>
                        <li>API 테스트 및 활용 방안 검토</li>
                    </ol>
                </div>
                <div style="text-align: center;">
                    <a href="https://www.data.go.kr/" target="_blank" style="background: #28a745; color: white; padding: 12px 25px; border-radius: 15px; text-decoration: none; display: inline-block; margin-right: 10px;">
                        <i class="fas fa-external-link-alt"></i>
                        Data.go.kr 방문
                    </a>
                    <button onclick="closeAddAPIModal()" style="background: #667eea; color: white; border: none; padding: 12px 25px; border-radius: 15px; cursor: pointer;">닫기</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // API 테스트 폼 제출 처리
        document.getElementById('apiTestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const apiType = formData.get('apiType');
            const fctExmnYr = formData.get('fctExmnYr'); // 실태조사연도 추가
            const numOfRows = formData.get('numOfRows');
            const pageNo = formData.get('pageNo');
            
            if (!apiType) {
                alert('API를 선택해주세요.');
                return;
            }
            
            // 로딩 표시
            document.getElementById('loading').style.display = 'block';
            document.getElementById('apiResult').style.display = 'none';
            document.getElementById('testButton').disabled = true;
            
            // API 호출
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'action': 'test_api',
                    'api_type': apiType,
                    'fctExmnYr': fctExmnYr, // 실태조사연도 파라미터 추가
                    'numOfRows': numOfRows,
                    'pageNo': pageNo
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                // 로딩 숨기기
                document.getElementById('loading').style.display = 'none';
                document.getElementById('testButton').disabled = false;
                
                // 결과 표시
                displayAPIResult(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loading').style.display = 'none';
                document.getElementById('testButton').disabled = false;
                
                // 에러 결과 표시
                displayAPIResult({
                    success: false,
                    error: 'API 호출 중 오류가 발생했습니다: ' + error.message,
                    details: '네트워크 오류 또는 서버 오류가 발생했습니다. 개발자 도구의 콘솔을 확인해주세요.'
                });
            });
        });
        
        // API 결과 표시 함수
        function displayAPIResult(result) {
            const resultDiv = document.getElementById('apiResult');
            const statusSpan = document.getElementById('resultStatus');
            const urlDiv = document.getElementById('resultUrl');
            const dataDiv = document.getElementById('resultData');
            
            if (result.success) {
                statusSpan.textContent = '성공';
                statusSpan.className = 'result-status status-success';
                
                if (result.url) {
                    urlDiv.textContent = '호출 URL: ' + result.url;
                    urlDiv.style.display = 'block';
                }
                
                if (result.data) {
                    let displayData = result.data;
                    if (result.response_length) {
                        displayData = {
                            ...result.data,
                            _debug: {
                                response_length: result.response_length,
                                http_code: result.httpCode
                            }
                        };
                    }
                    dataDiv.textContent = JSON.stringify(displayData, null, 2);
                }
            } else {
                statusSpan.textContent = '오류';
                statusSpan.className = 'result-status status-error';
                
                if (result.url) {
                    urlDiv.textContent = '호출 URL: ' + result.url;
                    urlDiv.style.display = 'block';
                }
                
                let errorMessage = result.error || '알 수 없는 오류가 발생했습니다.';
                
                // SOAP 오류 정보 추가
                if (result.soap_error) {
                    errorMessage += '\n\n🔴 SOAP 오류 상세 정보:';
                    if (result.soap_error.faultcode) {
                        errorMessage += '\n• 오류 코드: ' + result.soap_error.faultcode;
                    }
                    if (result.soap_error.faultstring) {
                        errorMessage += '\n• 오류 메시지: ' + result.soap_error.faultstring;
                    }
                    if (result.soap_error.detail) {
                        errorMessage += '\n• 상세 내용: ' + result.soap_error.detail;
                    }
                }
                
                // 기타 오류 정보 추가
                if (result.response) {
                    errorMessage += '\n\n📄 응답 내용:\n' + result.response;
                }
                if (result.raw_response) {
                    errorMessage += '\n\n📄 원본 응답:\n' + result.raw_response;
                }
                if (result.details) {
                    errorMessage += '\n\nℹ️ 상세 정보:\n' + result.details;
                }
                if (result.curl_info) {
                    errorMessage += '\n\n🔧 cURL 정보:\n' + JSON.stringify(result.curl_info, null, 2);
                }
                
                // 문제 해결 가이드 추가
                if (result.soap_error && result.soap_error.detail && result.soap_error.detail.includes('Service Not Found')) {
                    errorMessage += '\n\n💡 문제 해결 방법:';
                    errorMessage += '\n1. API 엔드포인트 URL이 올바른지 확인';
                    errorMessage += '\n2. API 키가 유효한지 확인';
                    errorMessage += '\n3. Data.go.kr 공식 문서에서 정확한 URL 확인';
                    errorMessage += '\n4. API 서비스가 현재 활성화되어 있는지 확인';
                }
                
                dataDiv.textContent = errorMessage;
            }
            
            resultDiv.style.display = 'block';
        }
        
        // 활용 가이드 표시 함수
        function showUsageGuide(apiType) {
            const modal = document.getElementById('apiGuideModal');
            const modalTitle = document.getElementById('guideModalTitle');
            const modalContent = document.getElementById('guideModalContent');
            
            if (apiType === 'women-family') {
                modalTitle.textContent = '경력단절여성 경제활동실태조사 API 활용 가이드';
                modalContent.innerHTML = `
                    <div style="margin-bottom: 20px;">
                        <h4>📚 API 활용 가이드</h4>
                        <p>여성가족부에서 제공하는 공식 활용 가이드를 참고하세요.</p>
                        <a href="https://www.data.go.kr/data/15013061/openapi.do" target="_blank" style="color: #667eea; text-decoration: none;">
                            📖 공식 문서 보기
                        </a>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <h4>🔑 인증키 관리</h4>
                        <p>보안을 위해 API 키는 서버 환경변수나 설정 파일을 통해 관리됩니다.</p>
                        <p><strong>참고:</strong> 실제 운영환경에서는 환경변수(.env) 또는 별도 설정 파일을 사용하세요.</p>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <h4>💡 활용 아이디어</h4>
                        <ul style="text-align: left; padding-left: 20px;">
                            <li>경력단절여성 맞춤형 취업 정보 서비스</li>
                            <li>경력 개발 및 교육 프로그램 추천</li>
                            <li>경제활동 참여율 시각화 대시보드</li>
                            <li>지역별 경력단절 현황 분석</li>
                        </ul>
                    </div>
                    <button onclick="closeGuideModal()" style="background: #667eea; color: white; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer;">닫기</button>
                `;
            }
            
            modal.style.display = 'block';
        }
        
        // 모달 닫기 함수들
        function closeGuideModal() {
            document.getElementById('apiGuideModal').style.display = 'none';
        }
        
        function closeAddAPIModal() {
            document.getElementById('addAPIModal').style.display = 'none';
        }
        
        // 모달 외부 클릭 시 닫기
        window.onclick = function(event) {
            const guideModal = document.getElementById('apiGuideModal');
            const addModal = document.getElementById('addAPIModal');
            
            if (event.target === guideModal) {
                guideModal.style.display = 'none';
            }
            if (event.target === addModal) {
                addModal.style.display = 'none';
            }
        }

        // 간단한 API 테스트 함수 (개발용)
        function quickTest() {
            console.log('간단한 API 테스트 시작...');
            
            // 로딩 표시
            document.getElementById('loading').style.display = 'block';
            document.getElementById('apiResult').style.display = 'none';
            
            // 기본 파라미터로 API 테스트
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'action': 'test_api',
                    'api_type': 'women-family',
                    'fctExmnYr': '2019', // 실태조사연도 파라미터 추가
                    'numOfRows': '5',
                    'pageNo': '1'
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('API 응답:', data);
                document.getElementById('loading').style.display = 'none';
                displayAPIResult(data);
            })
            .catch(error => {
                console.error('API 테스트 오류:', error);
                document.getElementById('loading').style.display = 'none';
                displayAPIResult({
                    success: false,
                    error: 'API 테스트 실패: ' + error.message,
                    details: '개발자 도구의 콘솔을 확인하여 자세한 오류 정보를 확인하세요.'
                });
            });
        }
        
        // 페이지 로드 시 간단한 테스트 실행 (개발용)
        // document.addEventListener('DOMContentLoaded', () => {
        //     // 개발 중일 때만 주석 해제
        //     // setTimeout(quickTest, 1000);
        // });
    </script>
</body>
</html>
