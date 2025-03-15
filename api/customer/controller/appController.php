<?php
require('api/customer/service/AppService.php');

class appController {
    public function excuteToken(){
        $AppService = new AppService();
        $AppService->excuteToken();
    }

    public function test(){
        $AppService = new AppService();
        $AppService->test();
    }
}   
?>


