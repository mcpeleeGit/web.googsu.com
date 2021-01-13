<?php
class AppRequestDTO {
    public function __construct()
    {
        Request::setJsonParam($this);
        $this->isValidate();
    }   
    
    private function isValidate(){
        if(!isset($this->token)){
            Response::jsonRequestParamError();
            return false;
        }        
        return true;
    }

    public $token;
}
?> 