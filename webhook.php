<?php
// Facebook 앱 설정
$verify_token = "your_verify_token"; // Webhook 검증용 토큰
$access_token = "your_access_token"; // Facebook 앱의 영구 액세스 토큰

// Webhook 검증
if (isset($_GET['hub_verify_token'])) {
    if ($_GET['hub_verify_token'] === $verify_token) {
        echo $_GET['hub_challenge'];
        exit;
    }
}

// Webhook 이벤트 처리
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['entry'][0]['messaging'][0])) {
    $messaging = $input['entry'][0]['messaging'][0];
    $sender_id = $messaging['sender']['id'];
    $message = $messaging['message']['text'] ?? '';
    
    // 메시지 저장 (선택사항)
    file_put_contents('messages.log', date('Y-m-d H:i:s') . " - Sender: $sender_id, Message: $message\n", FILE_APPEND);
    
    // 자동 응답
    sendMessage($sender_id, "메시지를 받았습니다: $message");
}

// 메시지 전송 함수
function sendMessage($recipient_id, $message) {
    global $access_token;
    
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
        error_log("메시지 전송 실패: " . error_get_last()['message']);
        return false;
    }
    
    return true;
} 