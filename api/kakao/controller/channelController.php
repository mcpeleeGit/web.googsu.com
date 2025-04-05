<?php
require('api/kakao/service/ChannelService.php');

class channelController {

    public function callback(){
        $ChannelService = new ChannelService();
        $ChannelService->callback();
    }

    public function unlinkCallBack(){
        $ChannelService = new ChannelService();
        $ChannelService->unlinkCallBack();
    }

    public function linkCallBack(){
        $ChannelService = new ChannelService();
        $ChannelService->linkCallBack();
    }
}
?>


