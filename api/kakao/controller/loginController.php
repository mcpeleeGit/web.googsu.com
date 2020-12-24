<?php
require('api/kakao/service/LoginService.php');
require('api/kakao/dto/LoginCallBackRequestDTO.php');

class loginController {

    public function loginLink(){
        $LoginService = new LoginService();
        $LoginService->loginLink();               
    }

    public function loginCallBack(){
        $LoginService = new LoginService();
        $LoginService->loginCallBack(new LoginCallBackRequestDTO());        
    }
}   
?>


