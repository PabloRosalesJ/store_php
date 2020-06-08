<?php
require_once "controllers/autoloader.php";
require_once "models/producto.php";
require_once "helpers/utils.php";

$notf = Array();
$p = new Producto();
$ls = $p->listSurtit();
$_SESSION["notifycation"] = $ls;


$controller = isset($_GET["c"]) ? $_GET["c"]."Controller" : null;
$action = isset($_GET["a"]) ? $_GET["a"] : null;

if (class_exists($controller) && $controller != null) {

    $controlador = new $controller();
    
    if (method_exists($controlador, $action) ) {

        $controlador->$action();
        
    }else {
        header("Location:http://store.test/?c=dashboard&a=index");
    }
}else {
    header("Location:http://store.test/?c=dashboard&a=index");
}
?>

