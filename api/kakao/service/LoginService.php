<?php
class LoginService extends service {  

    public function excuteLogin(){

        $client_id = "4408b5bb51bdf4c89879e933556a21e8";
        $redirect_uri = urlencode("http://".$_SERVER['HTTP_HOST']."/api/kakao/login/callBackLogin");
        $kakaoLoginUrl = "Location: https://kauth.kakao.com/oauth/authorize?client_id=".$client_id."&redirect_uri=".$redirect_uri."&response_type=code";

        header($kakaoLoginUrl);
        die();
    }

    public function callBackLogin($LoginCallBackRequestDTO){

        $client_id = "4408b5bb51bdf4c89879e933556a21e8"; 
        $client_secret = "QZhr9itOs0mxVRDxIvuOfOLzjZMc5q1U"; 
        $redirect_uri = urlencode("http://".$_SERVER['HTTP_HOST']."/api/kakao/login/callBackLogin");
        $returnUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=".$client_id."&redirect_uri=".$redirect_uri."&code=".$LoginCallBackRequestDTO->code."&client_secret=".$client_secret;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $returnUrl);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $loginResponse = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $accessToken= json_decode($loginResponse)->access_token; //Access Token만 따로 뺌

        //프로필 조회
        $header = "Bearer ".$accessToken; // Bearer 다음에 공백 추가
        $data = array(
        'propertyKeys' => 'kakao_account.email'
        );
        $getProfileUrl = "https://kapi.kakao.com/v2/user/me";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getProfileUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $data); //POST로 보낼 데이터 지정하기
        $headers = array();
        $headers[] = "Authorization: ".$header;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $profileResponse = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $profileObj = json_decode($profileResponse);

        $userId = $profileObj->id;
        $userName = $profileObj->properties->nickname;
        $userEmail = $profileObj->kakao_account->email;
        
        echo '<meta charset="utf-8">';
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">';
        echo '<h1>Kakao Login CallBack</h1>';
        echo '<p><h4>1. https://kauth.kakao.com/oauth/authorize CallBack Code</h2> <br>'.$LoginCallBackRequestDTO->code.'</p>';
        echo '<p><h4>2. https://kauth.kakao.com/oauth/token Return Values</h2> <br>'.$loginResponse.'</p>';
        echo '<p><h4>3. https://kapi.kakao.com/v2/user/me Return Values</h2> <br>'.$profileResponse.'</p>';
        echo "<p> Headers : ".$headers[0].'</p>';
        echo "<p> accessToken : ".$accessToken.'</p>';
        echo "<p> userId : ".$userId.'</p>';
        echo "<p> userName : ".$userName.'</p>';
        echo "<p> userEmail : ".$userEmail.'</p>';           
    }
}
?>