<?php 
require_once "models/modelobase.php";
Utils::isIdentity();

class dashboardController{
    public function index(){
        require_once "views/dashboard/index.php";
    }
}

?>