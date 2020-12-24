<?php
class DaumSearchService extends service {  

    public function getWeb($DaumSearchRequestDTO){

        $url = "https://dapi.kakao.com/v2/search/web?query=".$DaumSearchRequestDTO->query;
        $REST_API_KEY = "4408b5bb51bdf4c89879e933556a21e8"; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       
        $header = "KakaoAK ".$REST_API_KEY; 
        $headers = array();
        $headers[] = "Authorization: ".$header;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $res = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        
        header( "Content-Type:application/json;charset=UTF-8" );
        echo($res);    
    }
}
?>