<?php
class DaumSearchRequestDTO {
    public function __construct()
    {
        Request::setParam($this);
    }   
    
    public $query;
}
?> 