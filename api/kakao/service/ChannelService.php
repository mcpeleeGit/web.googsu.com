<?php
class ChannelService extends service {  
    public function callback(){

        //{"event":"added","id":"1111","id_type":"app_user_id","plus_friend_public_id":"_FLX","plus_friend_uuid":"@ad","updated_at":"2020-01-01T00:00:00Z"}'

        // Takes raw data from the request
        $json = file_get_contents('php://input');

        // Converts it into a PHP object
        $data = json_decode($json);        

        $this->hasAccess($data);
        Response::jsonReturn('excute', 'error'); 
    }

    public function hasAccess($data){
        //Write action to txt log
        $log  = "/event: ".$data->event.
                "/id: ".$data->id.
                "/id_type: ".$data->id_type.
                "/plus_friend_public_id: ".$data->plus_friend_public_id.
                "/plus_friend_uuid: ".$data->plus_friend_uuid.
                "/updated_at: ".$data->updated_at.PHP_EOL;
        file_put_contents('./channel_callback_log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
    }       
}
