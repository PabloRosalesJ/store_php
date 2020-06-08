<?php
require_once "models/categoria.php";
require_once "models/producto.php";

Utils::isIdentity();

class categoriaController{
    
    public function index(){
        require_once "views/categoria/listar.php";

    }

    // public function crear(){
    //     require_once "views/categoria/crear.php";
    // }

    public function guardar(){
        if ($_POST) {
            
            $categoria = new Categoria();

            if (!preg_match("/[0-9]/",$_POST["nombre"]) && $_POST["nombre"] != '') {
                $categoria->setNombre(strtolower($_POST["nombre"]));
                $categoria->crear();

            } else {
                header('Location:http://store.test/?c=categoria&a=index');
            }

        }
    }

    public function listar(){
        $cat = new Categoria();
        $categorias = $cat->todos('categoria');

        $res = Array( "datos" => Array() );
        
        while ($row = $categorias->fetch_object()) {
            $res["datos"][] = $row;
        }
        echo json_encode($res);
    }

    public function buscar(){
        if ($_POST) {
            $search = $_POST["search"];
            
            $categoria = new Categoria();
            $cat = $categoria->buscar($search);

            $res = Array('datos' => Array());

            while ($row = $cat->fetch_object()) {
                $res["datos"][] = $row;
            }

            echo json_encode($res);
        }
    }

    public function borrar(){
        if ($_POST) {
            $cat = new Categoria();

            $cat->eliminar($_POST["id"]);
        }
    }

    public function listByCategory(){
        if ($_GET) {
            $id = $_GET["id"];
            $name = $_GET["name"];
            $producto = new Producto();

            $productos = $producto->byCategory($id);
            $numrow = $productos->num_rows;
            require_once 'views/categoria/byCategory.php';
        }
    }
}

?>