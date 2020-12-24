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
        $this->Redirect($protocol.$_SERVER['HTTP_HOST']."/", false);  
    }

    public function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit(0);
    }
}
?>