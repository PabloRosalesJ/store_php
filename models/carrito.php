<?php 
require_once 'models/modeloBase.php';

class Carrito extends modeloBase{
    public $id_user;
    public $id_prod;
    public $nombre;
    public $producto;
    public $cantidad;
    public $total;
    public $nota;
    public $fecha;
    public $precio;

    public function __construct(){
        parent::__construct();
    }
    
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }
    
    public function setId_prod($id_prod)
    {
        $this->id_prod = $id_prod;

        return $this;
    }
    
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
    
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }
    
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }
    
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }
    
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }
    
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }
        
    public function setPrecio($precio){
        $this->precio = $precio;

        return $this;
    }

    public function agregar(){
        $id_user = $this->id_user;
        $id_prod = $this->id_prod;
        $nombre = $this->nombre;
        $producto = $this->producto;
        $cantidad = $this->cantidad;
        $total = $this->total;
        $nota = $this->nota;
        $fecha = $this->fecha;
        $precio = $this->precio;
        $res = Array("datos"=>Array());

        // checar productos de carrito
        $prodCarrito = Array();
        $sqlin = "SELECT id_prod FROM carrito";
        $resSet = $this->db->query($sqlin);
        while ($r = $resSet->fetch_object()) {
            $prodCarrito[] = $r->id_prod;
        }

        if (in_array($id_prod, $prodCarrito)) {
            $sqlCar = "UPDATE carrito SET cantidad = (cantidad + $cantidad) WHERE id_prod = $id_prod";
            $result = $this->db->query($sqlCar);

            if ($result) {
                $res["datos"][] = "success";
                $res["datos"][] = "success";

                $sqlProd = "UPDATE producto    
                SET stok = stok - $cantidad
                WHERE id = $id_prod";

                $this->db->query($sqlProd);
            }else{
                $error = $this->db->error;
                $res["datos"][] = "error";
                $res["datos"][] = $error;
            }
            echo json_encode($res);
            // die();
        }else {
            // restar en stock
        $sqlProd = "UPDATE producto    
        SET stok = stok - $cantidad
        WHERE id = $id_prod";

        $this->db->query($sqlProd);
            
            // insertar en carrito

        $sql = "INSERT INTO carrito (id_user, id_prod, cantidad, total, nota, fecha, nombre, producto, precio) VALUES (?,?,?,?,?,?,?,?,?)";

        $p = $this->db->prepare($sql);
        $p->bind_param('iiiissssi',$id_user, $id_prod, $cantidad, $total, $nota, $fecha, $nombre, $producto,$precio);
        $insert = $p->execute();

        if ($insert) {
        $res["datos"][] = "success";
        $res["datos"][] = "success";
        }else{
        $error = $this->db->error;
        $res["datos"][] = "error";
        $res["datos"][] = $error;
        }

        return json_encode($res);
        }
    }

    public function all(){
        $sql = "select * from carrito";
        $query = $this->db->query($sql);

        $res = Array("datos" => Array());
        
        while ($row = $query->fetch_object()) {
            $res["datos"][] = $row;
        }

        return json_encode($res);
    }

    public function delatepz($id){
        $sql = "DELETE FROM carrito WHERE id_prod=$id";
        $res = $this->db->query($sql);

        return $res;
    }

    public function endSales(){
        $carrito = "SELECT * FROM carrito";
        $resCarrito = $this->db->query($carrito);
        $sql = "";
        $res = Array("datos" => Array());
        while ($r = $resCarrito->fetch_object()) {
            $sql = "INSERT INTO compra(id_user, id_prod, cantidad, total, nota, fecha, nombre, producto, estatus) values($r->id_user, $r->id_prod, $r->cantidad, $r->total, '$r->nota', '$r->fecha', '$r->nombre', '$r->producto', 1)";

            $r = $this->db->query($sql);
            if ($r) {
                $res["datos"][] = "success";
            } else{
                $error = $this->db->error;
                $res["datos"][] = "error";
                $res["datos"][] = $error;
            }
            
        }

        $deleteCarrito = "truncate table carrito";
        $endquery = $this->db->query($deleteCarrito);
        
        return json_encode($res);
            
    }

}
?>
