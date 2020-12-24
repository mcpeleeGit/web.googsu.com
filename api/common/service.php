<?php
class service {  
    protected $pdo;
    public function __construct($isDbCon = 'N')
    {
        if($isDbCon == Constants::DB_CONN){
            require_once('api/common/dbconn.php');
            $this->pdo = new dbconn();
        }
    }
}
?>