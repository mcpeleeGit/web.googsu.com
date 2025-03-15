<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => '허용되지 않은 메소드입니다.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$content = $input['content'] ?? '';
$size = intval($input['size'] ?? 200);
$margin = intval($input['margin'] ?? 1);
$format = strtolower($input['format'] ?? 'png');

if (empty($content)) {
    http_response_code(400);
    echo json_encode(['error' => '내용을 입력해주세요.']);
    exit;
}

// QR코드 크기와 여백 검증
if ($size < 100 || $size > 1000) {
    http_response_code(400);
    echo json_encode(['error' => 'QR코드 크기는 100px에서 1000px 사이여야 합니다.']);
    exit;
}

if ($margin < 0 || $margin > 4) {
    http_response_code(400);
    echo json_encode(['error' => '여백은 0에서 4 사이여야 합니다.']);
    exit;
}

if (!in_array($format, ['png', 'svg'])) {
    http_response_code(400);
    echo json_encode(['error' => '지원하지 않는 형식입니다.']);
    exit;
}

try {
    require_once '../vendor/autoload.php';
    
    $options = new QROptions([
        'version' => 5,
        'outputType' => $format === 'png' ? QRCode::OUTPUT_IMAGE_PNG : QRCode::OUTPUT_MARKUP_SVG,
        'eccLevel' => QRCode::ECC_L,
        'scale' => 5,
        'imageBase64' => true,
        'addQuietzone' => $margin > 0,
        'quietzoneSize' => $margin,
    ]);

    $qrcode = new QRCode($options);
    $result = $qrcode->render($content);

    if ($format === 'png') {
        $result = 'data:image/png;base64,' . $result;
    }

    echo json_encode([
        'success' => true,
        'data' => $result,
        'format' => $format
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'QR코드 생성 중 오류가 발생했습니다.']);
} 