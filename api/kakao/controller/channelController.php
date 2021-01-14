<?php
require('api/kakao/service/ChannelService.php');

class channelController {

    public function callback(){
        $ChannelService = new ChannelService();
        $ChannelService->callback();               
    }
}   
?>


