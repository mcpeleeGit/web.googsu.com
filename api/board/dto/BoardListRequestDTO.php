<?php
class BoardListRequestDTO {
    public function __construct()
    {
        Request::setJsonParam($this);
        $this->isValidate();
    }   
    
    private function isValidate(){
        if(!isset($this->email) || !isset($this->password)){
            Response::jsonRequestParamError();
            return false;
        }        
        return true;
    }

    public $email;
    public $password;
}
?> 