<?php
class LoginCallBackRequestDTO {
    public function __construct()
    {
        Request::setParam($this);
    }   
    
    public $code;
}
?> 