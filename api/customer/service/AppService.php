<?php
class AppService extends service {  

    public function test(){
        $body = @file_get_contents("php://input");
        $this->hasAccess($body);
        Response::jsonReturn('excute', 'error');
    }

    public function excuteToken(){
        $this->hasAccess($_GET["token"]);
        Response::jsonReturn('excute', 'error'); 
    }

    public function hasAccess($token){
        //Write action to txt log
        $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                "Token: ".$token.PHP_EOL.
                "-------------------------".PHP_EOL;
        file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
    }

}
?>