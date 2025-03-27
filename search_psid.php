<?php
session_start();
header('Content-Type: application/json');

// Facebook 앱 설정
$access_token = $_SESSION['fb_access_token'] ?? '';

if (empty($access_token)) {
    echo json_encode([
        'success' => false,
        'error' => '로그인이 필요합니다.'
    ]);
    exit;
}

// POST 데이터 받기
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['search_term'])) {
    echo json_encode([
        'success' => false,
        'error' => '검색어를 입력해주세요.'
    ]);
    exit;
}

$search_term = $input['search_term'];

// Facebook Graph API로 사용자 검색
$url = "https://graph.facebook.com/v18.0/search";
$params = [
    'q' => $search_term,
    'type' => 'user',
    'fields' => 'id,name,email,picture',
    'access_token' => $access_token
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo json_encode([
        'success' => false,
        'error' => 'Facebook API 호출 실패'
    ]);
    exit;
}

$data = json_decode($response, true);

if (isset($data['error'])) {
    echo json_encode([
        'success' => false,
        'error' => $data['error']['message']
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'users' => $data['data'] ?? []
]); 