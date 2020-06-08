<?php 
require_once "config/database.php";

class modeloBase{
    public $db;
    public $url;

    public function __construct()
    {
        $this->db = dataBase::conectar();
    }

    public function todos($tabla){
        $this->db->query("SET NAMES UTF8");
        $query = $this->db->query("select * from $tabla WHERE estatus=1 ORDER BY id DESC" );
        return $query;
    }
}