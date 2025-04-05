<?php  
require('api/customer/service/SignUpService.php');

class signupController {
    public function defaultMethod(){
        $SignUpService = new SignUpService(Constants::DB_CONN);
        $SignUpService->saveUser();
    }
}

?>


