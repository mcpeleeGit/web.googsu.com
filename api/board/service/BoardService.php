<?php
require('api/customer/dao/LoginDAO.php');
require('api/customer/vo/LoginRequestVO.php');
require('api/customer/transformer/LoginTransformer.php');

class LoginService extends service {  
    protected $loginDAO;

    public function __construct($isDbCon = 'N')
    {
        parent::__construct($isDbCon);
        $this->loginDAO = new LoginDAO($this->pdo);
    }

    public function excuteLogin($loginRequestDTO){
        $loginRequestVO = LoginTransformer::transform($loginRequestDTO, new LoginRequestVO());
        $result = ($this->loginDAO)->validLogin($loginRequestVO);
        if($result) {
            session_start();
            $_SESSION['user_login'] = $loginRequestDTO->email;
        }
        Response::jsonReturn($result, 'no account'); 
    }
}
?>