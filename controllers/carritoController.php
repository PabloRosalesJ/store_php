<?php 
require_once 'models/carrito.php';
Utils::isIdentity();

class carritoController{
    public function index() {
        echo "Carrito";
    }

    public function agregar(){
        if ($_POST) {

            $carrito = new Carrito();

            $carrito->setId_user($_POST["id_user"]);
            $carrito->setId_prod($_POST["id_prod"]);
            $carrito->setNombre($_POST["nombre"]);
            $carrito->setProducto($_POST["producto"]);
            $carrito->setCantidad($_POST["cantidad"]);
            $carrito->setTotal($_POST["total"]);
            $carrito->setNota($_POST["nota"]);
            $carrito->setFecha($_POST["fecha"]);
            $carrito->setPrecio($_POST["precio"]);
            echo $carrito->agregar();

        }else {
            echo "<h1>Bad request </h1>";
        }
    }

    function listarCarrito(){
        $carrito = new Carrito();
        echo $carrito->all();
    }

    public function deleteBy(){
        if ($_POST) {
            $id = $_POST["id"];

            $carrito = new Carrito();
            $carrito->delatepz($id);
        }
    }

    public function endSales(){
        $c = new Carrito();
        echo $c->endSales();
    }
}
?>