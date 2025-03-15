<?php
require('api/kakao/service/DaumSearchService.php');
require('api/kakao/dto/DaumSearchRequestDTO.php');

class daumSearchController {

    public function web(){
        $DaumSearchService = new DaumSearchService();
        $DaumSearchService->getWeb(new DaumSearchRequestDTO());
    }

    public function vclip(){
        $DaumSearchService = new DaumSearchService();
        $DaumSearchService->getVclip(new DaumSearchRequestDTO());        
    }

    public function image(){
        $DaumSearchService = new DaumSearchService();
        $DaumSearchService->getImage(new DaumSearchRequestDTO());        
    }   
    
    public function blog(){
        $DaumSearchService = new DaumSearchService();
        $DaumSearchService->getBlog(new DaumSearchRequestDTO());        
    }   
    
    public function book(){
        $DaumSearchService = new DaumSearchService();
        $DaumSearchService->getBook(new DaumSearchRequestDTO());        
    }       
    
    public function cafe(){
        $DaumSearchService = new DaumSearchService();
        $DaumSearchService->getCafe(new DaumSearchRequestDTO());        
    }        
}   
?>


