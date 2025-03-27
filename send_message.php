<?php
header('Content-Type: application/json');

// Facebook 앱 설정
$access_token = "37834a86ccf558710269fe9e2c3fafce"; // Facebook 앱의 영구 액세스 토큰

// POST 데이터 받기
$input = json_decode(file_get_contents('php://input'), true);

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

$options = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($data)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    echo json_encode([
        'success' => false,
        'error' => '메시지 전송에 실패했습니다.'
    ]);
} else {
    echo json_encode([
        'success' => true,
        'message' => '메시지가 성공적으로 전송되었습니다.'
    ]);
} 