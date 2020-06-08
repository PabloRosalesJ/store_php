<?php 
require_once "models/producto.php";
require_once "models/categoria.php";
require_once "helpers/utils.php";
//  Utils::isIdentity();

class productoController{
    
    public function index(){

        require_once "views/producto/listar.php";

    }

    public function ver(){
        Utils::isIdentity();
        if ($_GET) {
            $id_product = $_GET["id"];
            if (is_numeric($id_product)) {

                $p = new Producto();

                $producto = $p->find($id_product);

                require_once "views/producto/show.php";

            }else {
                echo "<h1>404</h2>";
            }
        }

    }

    public function guardar(){
        if ($_POST) {

            $nombreImagen = Utils::Store();
            
            if (Utils::ProductRequest()) {
                
                Utils::Product('guardar',$nombreImagen);

            } else {

                $res['datos'][] = "error";
                $res['datos'][] = "Verifique los campos 🤔🤷‍♂️";
                echo json_encode($res);
            }
            
        }
        
    }

    public function listar(){
        $producto = new Producto();

        $productos = $producto->todos('producto');

        $res = Array("datos"=>Array());
        while ($row = $productos->fetch_object()) {
            $res["datos"][] = $row;
        }

        echo json_encode($res);
    }

    public function buscar(){
        if ($_POST["search"]) {
            $search = $_POST["search"];

            $producto = new Producto();
            $productos = $producto->buscar($search);

            $res = Array("datos"=>Array());
            while ($row = $productos->fetch_object()) {
                $res["datos"][] = $row;
            }

            echo json_encode($res);
        }
    }

    public function borrar(){
        if ($_POST["id"]) {
            $producto = new Producto();
            $producto->setId($_POST["id"]);

            $producto->borrar();

            header("Location:http://store.test/?c=producto&a=index");
        }
        else {
            header("Location:http://store.test/?c=producto&a=index");
        }
    }

    public function precio(){
        if ($_POST["id"]) {
            $id = $_POST["id"];

            $producto = new Producto();
            $producto->setId($id);
            $precio = $producto->precio();

            $res = Array("datos" => Array());

            while ($row = $precio->fetch_object()) {
                $res["datos"][] = $row;
            }

            echo json_encode($res);
        }
    }

    public function actualizar(){
        if ($_POST) {
            
            $imagen = $_FILES['imagen']; 
                    
            if ($imagen['name'] == '') {
                $p = new Producto();

                $id = (int) $_POST["id_prod"];
                $nombreImagen = $p->Image($id);

            }else {
                $nombreImagen = Utils::Store();
            }
            
            if (Utils::ProductRequest()) {
                Utils::Product('actualizar', $nombreImagen);

            } else {

                $res['datos'][] = "error";
                $res['datos'][] = "Verifique los campos 🤔🤷‍♂️";
                echo json_encode($res);
            }          

        }else {
            throw new Exception("Error Processing Request", 1);
            
        }

    }

    public function almacen(){
        require_once "views/producto/almacen.php";
    }

    public function selectOne(){
        if ($_POST) {
            $search =  $_POST["search"];

            $p = new Producto();
            $query = $p->selectOne($search);
            $res = Array("datos" => Array());

            while ($row = $query->fetch_object()) {
                $res["datos"][] = $row;
            }
            
            echo json_encode($res);
        }
    }

    public function abastecer(){
        if ($_POST) {
            $id = $_POST["id"];
            $pz = $_POST["pz"];

            $p = new Producto();
            $p->setId($id);
            $p->setStok($pz);
            
            echo $p->abastecer();
        }
    }

    public function desabasto(){
        // if ($_POST) {
            $p = new Producto();
            $prod = $p->onyShortage();
            $res = Array("datos" => Array());

            while ($r = $prod->fetch_object()) {
                $res["datos"][] = $r;
            }

            echo json_encode($res);
        // }
    }

    public function abastos(){
        if ($_POST) {
            $p = new Producto();
            $id = $_POST["id"];
            //$nombre = $_POST["nombre"];
            $stock = $_POST["pz"];

            $p->setId($id);
            //$p->setNombre($nombre);
            $p->setStok($stock);

            $p->abastos();
        }
    }

    public function history(){
        $p = new Producto();
        $history = $p->history();
        $res = Array("datos"=>Array());

        while($row = $history->fetch_object()){
            $res["datos"][] = $row;
        }
        
        echo json_encode($res);
    }

    public function historyPDF(){
        $p = new Producto();
        $p->toPDFHistory();
    }

    public function historyExcel(){
        $p = new Producto();
        $p->toExcelHistory();
    }
    
    public function listSurtir(){
        $p = new Producto();
        $result = $p->listSurtit();
        $res = Array("datos"=>Array());

        while($row = $result->fetch_object()){
            $res["datos"][] = $row;
        }

        echo json_encode($res);
    }

    public function SurtirPDF(){
        $p = new Producto();
        $p->SurtirPDF();
    }

    public function BackUP(){
        Utils::backUp();
    }

    public function store(){
        $p = new Producto();
        $p->store();
    }

    public function listarVendidos(){
        //Utils::isIdentity();

        $id = $_GET["id"];

        $p = new Producto();
        $products = $p->listarVendidos($id);
        $res = Array("datos"=>Array());

        while($row = $products->fetch_object()){
            $res["datos"][] = $row;
        }
        
        echo json_encode($res);
    }
}

?>