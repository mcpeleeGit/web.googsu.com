<?php
class SignUpService extends service {  
    public function __construct($isDbCon = 'N')
    {
        parent::__construct($isDbCon);
    }

    public function saveUser(){
        
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        if(!isset($data->{'email'}) || !isset($data->{'password'})){
            echo json_encode(array('result_code'=>200, 'result'=>'fail', 'message'=>'no param'));
            return;
        }
        $email = $data->{'email'};
        $password = $data->{'password'};

        try {
            $sql = "INSERT INTO wp_users (user_login, user_pass, user_nicename, user_email) 
                    VALUES ('".$email."','".$password."','".$email."','".$email."')" ;
            
            $stmt = ($this->pdo)->prepare($sql);
            $stmt->execute();            
            
        } catch (PDOException $e) {
            echo json_encode(array('result_code'=>200, 'result'=>'fail', 'message'=>'insert fail'));
        }    
        echo json_encode(array('result_code'=>200, 'result'=>'success'));        
    }
}
?>