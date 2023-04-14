<?php
class Request {  
    public static function setJsonParam(&$class)
    {
        $reflect = new ReflectionClass($class);
        $props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        $json = file_get_contents('php://input');
        $data = json_decode($json);
        
        foreach ($props as $prop) {
            $class->{$prop->getName()} = $data->{$prop->getName()};
        }
    }    

    public static function setParam(&$class)
    {
        $reflect = new ReflectionClass($class);
        $props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        
        foreach ($props as $prop) {
            $class->{$prop->getName()} = $_GET[$prop->getName()];
        }
    }        
}
?>