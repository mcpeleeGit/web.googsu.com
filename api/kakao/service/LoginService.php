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
        $KakaoAPIService = new KakaoAPIService("JSON");
        $KakaoAPIService->getProfile();  
    }

}
?>