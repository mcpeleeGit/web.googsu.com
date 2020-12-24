<?php
require('api/kakao/service/KakaoAPIService.php');
class LoginService extends service {  
    public function loginLink(){
        $KakaoAPIService = new KakaoAPIService("JSON");
        $KakaoAPIService->getKakaoLoginLink();               
    }    

    public function loginCallBack($LoginCallBackRequestDTO){
        $KakaoAPIService = new KakaoAPIService();
        $KakaoAPIService->getToken();  
        $_SESSION["loginProfile"] = $KakaoAPIService->getProfile();  

        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
        header("Location: ".$protocol.$_SERVER['HTTP_HOST']);
        die();        
    }
}
?>