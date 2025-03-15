<?php
class ChannelService extends service {
    public function callback(){

        //{"event":"added","id":"1111","id_type":"app_user_id","plus_friend_public_id":"_FLX","plus_friend_uuid":"@ad","updated_at":"2020-01-01T00:00:00Z"}'

        // Takes raw data from the request
        $json = file_get_contents('php://input');

        // Converts it into a PHP object
        $data = json_decode($json);

        $this->hasAccess($data, $json);
        Response::jsonReturn('callback', 'callback');
    }

    public function hasAccess($data, $json){
        //Write action to txt log
        $log  = "/REMOTE_ADDR: ".$_SERVER['REMOTE_ADDR'].
            "/event: ".$data->event.
            "/id: ".$data->id.
            "/id_type: ".$data->id_type.
            "/plus_friend_public_id: ".$data->plus_friend_public_id.
            "/plus_friend_uuid: ".$data->plus_friend_uuid.
            "raw:".$json.
            "/updated_at: ".$data->updated_at.PHP_EOL;
        file_put_contents('./channel_callback_log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
    }


    public function unlinkCallBack(){

        //http_response_code(500);

        $this->unlinkhasAccess();
        Response::jsonReturn('unlinkCallBack', 'unlinkCallBack');
    }

    public function unlinkhasAccess(){
        //Write action to txt log
        $log  = "/REMOTE_ADDR: ".$_SERVER['REMOTE_ADDR'].
            "/user_id: ".$_GET["user_id"].$_POST["user_id"].
            "/referrer_type: ".$_GET["referrer_type"].$_POST["referrer_type"].PHP_EOL;
        file_put_contents('./unlinkCallBack_log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
    }

    public function linkCallBack(){
        //sleep(8);
        $json = file_get_contents('php://input');
        $this->linkhasAccess($json);
        Response::jsonReturn('linkCallBack', 'linkCallBack');
    }

    public function linkhasAccess($json){
        $log = "";
        foreach (getallheaders() as $name => $value) {
             $log = $log . "$name: $value\n";
        }
        $log  = $log . "/REMOTE_ADDR: ".$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].
            "raw:".$json.PHP_EOL;
        file_put_contents('./linkCallBack_log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
    }
}
