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

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'success' => false,
        'error' => '잘못된 JSON 형식입니다.'
    ]);
    exit;
}

if (!isset($input['recipient_id']) || !isset($input['message'])) {
    echo json_encode([
        'success' => false,
        'error' => '필수 파라미터가 누락되었습니다.'
    ]);
    exit;
}

$recipient_id = $input['recipient_id'];
$message = $input['message'];

// 메시지 전송
$url = "https://graph.facebook.com/v18.0/me/messages";
$data = [
    'recipient' => ['id' => $recipient_id],
    'message' => ['text' => $message]
];

// cURL 초기화
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
]);

// 요청 실행
$result = curl_exec($ch);

// cURL 에러 체크
if (curl_errno($ch)) {
    echo json_encode([
        'success' => false,
        'error' => '메시지 전송에 실패했습니다: ' . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

// HTTP 상태 코드 체크
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo json_encode([
        'success' => false,
        'error' => '메시지 전송에 실패했습니다. HTTP 상태 코드: ' . $http_code
    ]);
    exit;
}

$response = json_decode($result, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'success' => false,
        'error' => '응답 처리 중 오류가 발생했습니다.'
    ]);
    exit;
}

if (isset($response['error'])) {
    echo json_encode([
        'success' => false,
        'error' => $response['error']['message']
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => '메시지가 성공적으로 전송되었습니다.'
]); 