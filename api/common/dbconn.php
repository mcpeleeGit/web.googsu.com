<?php
class dbconn extends PDO
{
    public function __construct()
    {
        parent::__construct('mysql:host=localhost;dbname=mcpelee','mcpelee','mcse98go^^');
        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
?>