<?php
require_once 'functions.php';

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'result' => null
];

try {
    // XML 데이터 가져오기
    $xml = '';
    if (isset($_FILES['xml_file']) && $_FILES['xml_file']['error'] === UPLOAD_ERR_OK) {
        $xml = file_get_contents($_FILES['xml_file']['tmp_name']);
    } elseif (isset($_POST['xml_content'])) {
        $xml = $_POST['xml_content'];
    } else {
        throw new Exception('XML 데이터가 제공되지 않았습니다.');
    }
    
    // XML 검증
    $result = validateXML($xml);
    
    $response['success'] = true;
    $response['result'] = [
        'valid' => $result['valid'],
        'errors' => $result['errors']
    ];
    
    if ($result['valid']) {
        $response['message'] = 'XML이 유효합니다.';
    } else {
        $response['message'] = 'XML이 유효하지 않습니다.';
    }
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response); 