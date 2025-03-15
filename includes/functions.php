<?php
/**
 * XML 검증 함수
 * @param string $xml XML 문자열
 * @return array 검증 결과
 */
function validateXML($xml) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadXML($xml);
    
    $errors = libxml_get_errors();
    libxml_clear_errors();
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * 16진수 문자열을 이미지로 변환
 * @param string $hex 16진수 문자열
 * @param string $type 이미지 타입 (jpeg, png, gif)
 * @return array 변환 결과
 */
function hexToImage($hex, $type) {
    // 16진수 문자열 정리
    $hex = preg_replace('/[^0-9A-Fa-f]/', '', $hex);
    
    // 16진수 문자열이 비어있는지 확인
    if (empty($hex)) {
        return [
            'success' => false,
            'message' => '유효한 16진수 문자열이 아닙니다.'
        ];
    }
    
    // 16진수 문자열을 바이트 배열로 변환
    $bytes = hex2bin($hex);
    if ($bytes === false) {
        return [
            'success' => false,
            'message' => '16진수 문자열을 바이트로 변환할 수 없습니다.'
        ];
    }
    
    // 이미지 정보 확인
    $imageInfo = @getimagesizefromstring($bytes);
    if ($imageInfo === false) {
        return [
            'success' => false,
            'message' => '유효한 이미지 데이터가 아닙니다.'
        ];
    }
    
    // 이미지 저장
    $filename = uniqid() . '.' . $type;
    $filepath = __DIR__ . '/../uploads/' . $filename;
    
    if (file_put_contents($filepath, $bytes) === false) {
        return [
            'success' => false,
            'message' => '이미지 저장에 실패했습니다.'
        ];
    }
    
    return [
        'success' => true,
        'filename' => $filename,
        'message' => '이미지 변환이 완료되었습니다.'
    ];
}

/**
 * 에러 메시지 포맷팅
 * @param array $errors 에러 배열
 * @return string 포맷된 에러 메시지
 */
function formatErrors($errors) {
    $message = '<ul class="error-list">';
    foreach ($errors as $error) {
        $message .= sprintf(
            '<li>Line %d: %s</li>',
            $error->line,
            htmlspecialchars($error->message)
        );
    }
    $message .= '</ul>';
    return $message;
}

/**
 * HTML 특수문자를 이스케이프하는 함수
 * @param string $str 이스케이프할 문자열
 * @return string 이스케이프된 문자열
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
} 