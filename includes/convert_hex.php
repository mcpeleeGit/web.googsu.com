<?php
require_once 'functions.php';

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'result' => null
];

try {
    // 입력 데이터 검증
    if (!isset($_POST['hex_input']) || empty($_POST['hex_input'])) {
        throw new Exception('16진수 문자열이 제공되지 않았습니다.');
    }
    
    if (!isset($_POST['image_type']) || !in_array($_POST['image_type'], ['jpeg', 'png', 'gif'])) {
        throw new Exception('유효하지 않은 이미지 형식입니다.');
    }
    
    // 16진수-이미지 변환
    $result = hexToImage($_POST['hex_input'], $_POST['image_type']);
    
    if ($result['success']) {
        $response['success'] = true;
        $response['message'] = $result['message'];
        $response['result'] = [
            'filename' => $result['filename'],
            'url' => 'uploads/' . $result['filename']
        ];
    } else {
        throw new Exception($result['message']);
    }
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response); 