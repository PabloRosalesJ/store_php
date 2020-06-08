<?php 

function autoloader($name){
    require_once "controllers/".$name.".php";
}

spl_autoload_register('autoloader');

?>