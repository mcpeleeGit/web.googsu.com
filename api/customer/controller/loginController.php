<?php
require('api/customer/service/LoginService.php');
require('api/customer/dto/LoginRequestDTO.php');

class loginController {
    public function defaultMethod(){
        $LoginService = new LoginService(Constants::DB_CONN);
        $LoginService->excuteLogin(new LoginRequestDTO());
    }
}   
?>


