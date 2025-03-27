<?php
session_start();

// Facebook 앱 설정
$app_id = '3040550802927623';
$app_secret = 'e4a2740dae26044edca7f0c484f9000c'; // Facebook 앱 시크릿 키로 교체 필요

// OAuth 콜백 처리
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    // 액세스 토큰 요청
    $token_url = 'https://graph.facebook.com/v18.0/oauth/access_token';
    $token_params = [
        'client_id' => $app_id,
        'client_secret' => $app_secret,
        'redirect_uri' => 'https://' . $_SERVER['HTTP_HOST'] . '/oauth_callback.php',
        'code' => $code
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url . '?' . http_build_query($token_params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $token_response = curl_exec($ch);
    curl_close($ch);
    
    $token_data = json_decode($token_response, true);
    
    if (isset($token_data['access_token'])) {
        // 액세스 토큰 저장
        $_SESSION['fb_access_token'] = $token_data['access_token'];
        
        // 사용자 정보 가져오기
        $graph_url = 'https://graph.facebook.com/v18.0/me';
        $graph_params = [
            'fields' => 'id,name,email,picture',
            'access_token' => $token_data['access_token']
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url . '?' . http_build_query($graph_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $graph_response = curl_exec($ch);
        curl_close($ch);
        
        $user_data = json_decode($graph_response, true);
        
        if (isset($user_data['id'])) {
            // 사용자 정보 저장
            $_SESSION['fb_user_id'] = $user_data['id'];
            $_SESSION['fb_user_name'] = $user_data['name'];
            $_SESSION['fb_user_email'] = $user_data['email'] ?? '';
            $_SESSION['fb_user_picture'] = $user_data['picture']['data']['url'] ?? '';
            
            // 메인 페이지로 리디렉션
            header('Location: facebook.php');
            exit;
        }
    }
}

// 오류 발생 시 메인 페이지로 리디렉션
header('Location: facebook.php?error=oauth_failed');
exit; 