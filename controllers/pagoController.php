<?php 
require_once "models/pago.php";
Utils::isIdentity();

class pagoController{

    public function index(){
        echo "funciona";
    }

    public function pago(){
        if ($_POST) {
            
            $id_cliente = (int)$_POST["id_cliente"];
            $monto = $_POST["monto"];
            $fecha = $_POST["fecha"];
            $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
          
            $pago = new Pago();

            $pago->setId_cliente($id_cliente);
            $pago->setMonto($monto);
            $pago->setFecha($fecha);
            $pago->setDescripcion($descripcion);

            $pago->pago();
        }
    }

    public function pagos(){
        $id = $_POST["id_cliente"];
        
        $pago = new Pago();

        $pago->setId($id);
        $pagos = $pago->listaPagos();

        $res = Array("datos"=>Array());
        while($row = $pagos->fetch_object()){
            $res["datos"][] = $row;
        }

        echo json_encode($res);
    }

    public function borrar(){
        $id = $_POST["id"];

        $pago = new Pago();
        $pago->setId($id);

        $pago->borrar();
    }

    public function buscar(){
        $id = $_POST["id_cliente"];
        $search = $_POST["search"];

        $pago = new Pago();
        $pago->setId($id);

        $items = $pago->buscar($search);
        $res = Array("datos" => Array());

        while($row = $items->fetch_object()){
            $res["datos"][] = $row;
        }

        echo json_encode($res);
    }

    public function totalPagos(){
        if ($_GET) {
            $id = $_GET["id"];

            $pago = new Pago();
            $total = $pago->totalPagos($id);

            $res = array('datos' => array());
            while($row = $total->fetch_object()){
                $res['datos'][] = $row;
            }

            echo json_encode($res);

        }
    }
}

?>
 