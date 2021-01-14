<?php
class ChannelService extends service {  
    public function callback(){

        //{"event":"added","id":"1111","id_type":"app_user_id","plus_friend_public_id":"_FLX","plus_friend_uuid":"@ad","updated_at":"2020-01-01T00:00:00Z"}'

        $this->hasAccess($_GET["event"], $_GET["id"], $_GET["id_type"], $_GET["plus_friend_public_id"], $_GET["plus_friend_uuid"], $_GET["updated_at"]);
        Response::jsonReturn('excute', 'error'); 
    }

    public function hasAccess($event, $id, $id_type, $plus_friend_public_id, $plus_friend_uuid, $updated_at){
        //Write action to txt log
        $log  = "/event: ".$event.
                "/id: ".$id.
                "/id_type: ".$id_type.
                "/plus_friend_public_id: ".$plus_friend_public_id.
                "/plus_friend_uuid: ".$plus_friend_uuid.
                "/updated_at: ".$updated_at.PHP_EOL;
        file_put_contents('./channel_callback_log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
    }       
}
?>