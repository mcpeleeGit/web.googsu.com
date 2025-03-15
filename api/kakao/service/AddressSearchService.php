<?php
class AddressSearchService extends service {  

    public function getAddress($AddressSearchRequestDTO){

        $url = "https://dapi.kakao.com/v2/local/search/address.json?query=".urlencode($AddressSearchRequestDTO->query);
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


    public function getCoord2regioncode($Coord2regioncodehRequestDTO){

        $url = "https://dapi.kakao.com/v2/local/geo/coord2regioncode.json?x=".$Coord2regioncodehRequestDTO->x."&y=".$Coord2regioncodehRequestDTO->y;
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