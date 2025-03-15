<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => '허용되지 않은 메소드입니다.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$url = $input['url'] ?? '';

if (empty($url)) {
    http_response_code(400);
    echo json_encode(['error' => 'URL이 필요합니다.']);
    exit;
}

function checkTLSVersion($url, $version) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    switch ($version) {
        case '1.0':
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0);
            break;
        case '1.1':
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_1);
            break;
        case '1.2':
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            break;
        case '1.3':
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_3);
            break;
    }

    $result = curl_exec($ch);
    $error = curl_errno($ch);
    curl_close($ch);

    return $error === 0;
}

function getCertificateInfo($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_CERTINFO, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    curl_exec($ch);
    $certInfo = curl_getinfo($ch, CURLINFO_CERTINFO);
    $error = curl_errno($ch);
    curl_close($ch);

    if ($error !== 0 || empty($certInfo)) {
        return null;
    }

    $cert = $certInfo[0];
    return [
        'subject' => $cert['Subject'] ?? '',
        'issuer' => $cert['Issuer'] ?? '',
        'validFrom' => $cert['Start date'] ?? '',
        'validTo' => $cert['Expire date'] ?? '',
        'serialNumber' => $cert['Serial Number'] ?? '',
        'version' => $cert['Version'] ?? '',
        'signatureAlgorithm' => $cert['Signature Algorithm'] ?? ''
    ];
}

try {
    $tlsVersions = [
        'tls1' => checkTLSVersion($url, '1.0'),
        'tls1-1' => checkTLSVersion($url, '1.1'),
        'tls1-2' => checkTLSVersion($url, '1.2'),
        'tls1-3' => checkTLSVersion($url, '1.3')
    ];

    $certInfo = getCertificateInfo($url);

    echo json_encode([
        'tls_versions' => $tlsVersions,
        'certificate' => $certInfo
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => '서버 오류가 발생했습니다.']);
} 