<?php
class LoginDAO extends dao {  
    public function __construct($pdo)
    {
        parent::__construct($pdo);
    }

    public function validLogin($loginRequestVO){
        $sql = 'SELECT 
                    (CASE 
                        WHEN count(user_login) = 0 THEN false
                        ELSE true
                     END) AS result
                  FROM wp_users 
                 WHERE user_login= :email 
                   AND user_pass= :password
                ';
        return $this->getResult($sql, $loginRequestVO);
    }
}   
?>


