<?php 
session_start();
class dataBase{
    public static function conectar(){
        $conn = new mysqli("localhost", "root", "", "store");
        $conn->query("SET NAMES UTF8");

        return $conn;
    }
}

?>