<?php
class Response {  
    public static function jsonheader(){
        header('Access-Control-Allow-Origin: *, Content-Type: application/json; charset=UTF-8');
    }

    public static function jsonRequestParamError(){
        echo json_encode(array('result_code'=>200, 'result'=>'fail', 'message'=>'no param'));
    }    

    public static function jsonReturn($result, $failMsg){
        if($result){
            echo json_encode(array('result_code'=>200, 'result'=>'success'));
        }
        else{
            echo json_encode(array('result_code'=>200, 'result'=>'fail', 'message'=>$failMsg));
        }    
    }        
}
?>