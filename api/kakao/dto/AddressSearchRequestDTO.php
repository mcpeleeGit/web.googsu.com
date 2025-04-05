<?php
class AddressSearchRequestDTO {
    public function __construct()
    {
        Request::setParam($this);
    }   
    
    public $query;
}
?> 