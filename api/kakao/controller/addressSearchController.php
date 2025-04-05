<?php
require('api/kakao/service/AddressSearchService.php');
require('api/kakao/dto/AddressSearchRequestDTO.php');
require('api/kakao/dto/Coord2regioncodehRequestDTO.php');

class addressSearchController {

    public function address(){
        $AddressSearchService = new AddressSearchService();
        $AddressSearchService->getAddress(new AddressSearchRequestDTO());
    }


    public function coord2regioncode(){
        $AddressSearchService = new AddressSearchService();
        $AddressSearchService->getCoord2regioncode(new Coord2regioncodehRequestDTO());
    }    
    
}   
?>


