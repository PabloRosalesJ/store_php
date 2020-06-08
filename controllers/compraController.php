<?php 
require_once "models/compra.php";
require_once "models/producto.php";
Utils::isIdentity();

class compraController{
    public function index(){
        $product = new Producto();
        $productos = $product->todos('producto');
        
        require_once "views/compra/index.php";
    }

    public function compra(){

        if ($_POST) {
            $compra = new Compra();

            $id_user = $_POST["id_user"];
            $id_prod = $_POST["id_prod"];
            $cantidad = $_POST["cantidad"];
            $total = $_POST["total"];
            $nota  = $_POST["nota"];
            $nombre = $_POST["nombre"];
            $producto = $_POST["producto"];

            $compra->setId_user($id_user);
            $compra->setId_prod($id_prod);
            $compra->setCantidad($cantidad);
            $compra->setTotal($total);
            $compra->setNota($nota);
            $compra->setNombre($nombre);
            $compra->setProducto($producto);

            $res = $compra->compra();

            if ($res) {
                header("Location:http://store.test/?c=compra&a=index");
            }
            else {
                echo 'error';
                die();
            }
        } else {
            echo "error de integridad";
        }
        
    }

    public function listar(){
        $compra = new Compra();
        $compras = $compra->todosVE();
        require_once "views/compra/listar.php";
    }

    public function todosVE(){
        $compra = new Compra();
        $compras = $compra->todosVE();

        $result = Array("datos"=> Array());

        while($row = $compras->fetch_object()){
            $result["datos"][] = $row;
        }

        echo json_encode($result);

    }

    public function SchTodosVE(){
        if ($_GET) {
            $search = $_GET["search"];

            $compra = new Compra();
            $datos = $compra->SchTodosVE($search);

            // echo $datos;
            $res = Array("datos" => Array());

            while($row = $datos->fetch_object()){
                $res["datos"][] = $row;
            }

            echo json_encode($res);
        }
    }
    public function ventaLibre(){
        require_once "views/compra/ventaLibre.php";
    }
    public function excel(){
        // if($_POST){
        //     $search = $_POST["search"];
            $compra = new Compra();
            $compra->excel();
        // }
    }

    public function PDF(){
        $compra = new Compra();
        $compra->PDF();
    }

    public function doFreeSale(){
        if ($_POST) {

            $id_cliente = isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : null;
            $nombre_cliente = isset($_POST["cliente"]) ? $_POST["cliente"] : null;
            $monto = isset($_POST["monto"]) && is_numeric($_POST["monto"]) && $_POST["monto"] > 0 ? $_POST["monto"] : null;
            $nota = isset($_POST["nota"]) ? $_POST["nota"] : null;

            $res = Array("datos"=>Array());

            if($id_cliente != null && $nombre_cliente != null && $monto != null && $nota != null){
                $compra = new Compra();
                
                $compra->setId_user($id_cliente);
                $compra->setNombre($nombre_cliente);
                $compra->setTotal($monto);
                $compra->setNota($nota);

                $resC = $compra->ventaLibre();
                if ($resC) {

                    $res["datos"][] = "success";
                    $res["datos"][] = "Registro Completo";

                    echo json_encode($res);
                }
                else {
                    $res["datos"][] = "error";
                    $res["datos"][] = "Hubo un error y no se ha generado su registro";

                    echo json_encode($res);
                }
            }
            else{
                $res["datos"][] = "error";
                $res["datos"][] = "Error en los campos";

                echo json_encode($res);
            }

        }else {
             throw new Exception("404 Not found !!!", 1);
        }
    }

    public function allFreeSAles(){
        $compra = new Compra();
        $data = $compra->todos('credito');

        $res = Array("datos" => Array());

        while($row = $data->fetch_object()){
            $res["datos"][] = $row;
        }

        echo json_encode($res);
    }

    public function buscarVL(){
        if ($_POST) {

            $search = isset($_POST["search"]) && $_POST["search"] != '' ? $_POST["search"] : null;

            if ($search != null) {
                $compra = new Compra();
                $datos = $compra->buscarVL($search);

                $res = Array("datos" => Array());

                while($row = $datos->fetch_object()){
                    $res["datos"][] = $row;
                }
            }
            else{
                $res["datos"][] = "Bad Request";
            }

            echo json_encode($res);
        }
        else{
            throw new Exception("Bad Request", 0);
            
        }
    }

    public function freeSalesbyUser(){
        if ($_POST) {
            $c = new Compra();
            $c->setId_user($_POST["id"]);
            $result = $c->freeSalesbyUser();
            $res = Array("datos" => Array());

            while($row = $result->fetch_object()){
                $res["datos"][] = $row;
            }

            echo json_encode($res);
        }
    }

}


?>