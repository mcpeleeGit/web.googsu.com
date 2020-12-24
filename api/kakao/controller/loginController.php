<?php
require('api/kakao/service/KakaoAPIService.php');
require('api/kakao/service/LoginService.php');
require('api/kakao/dto/LoginCallBackRequestDTO.php');

class loginController {

    public function loginLink(){
        $KakaoAPIService = new KakaoAPIService();
        header( "Content-Type:application/json;charset=UTF-8" );
        echo json_encode(array('result_code'=>200, 'result'=>$KakaoAPIService->getKakaoLoginLink()));               
    }

    public function defaultMethod(){
        $LoginService = new LoginService();
        $LoginService->excuteLogin();
    }

    public function callBackLogin(){
        $LoginService = new LoginService();
        $LoginService->callBackLogin(new LoginCallBackRequestDTO());        
    }
}   
?>


