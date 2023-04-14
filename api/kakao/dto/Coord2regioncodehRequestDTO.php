<?php
class Coord2regioncodehRequestDTO {
    public function __construct()
    {
        Request::setParam($this);
    }   
    
    public $x;
    public $y;
}
?> 