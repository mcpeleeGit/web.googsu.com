<?php
class LoginTransformer {
    public static function transform($loginRequestDTO, $loginRequestVO){
        $loginRequestVO->email = $loginRequestDTO->email;
        $loginRequestVO->password = $loginRequestDTO->password;
        return $loginRequestVO;
    }
}   
?>