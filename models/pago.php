
<?php 
require_once "models/modeloBase.php";

class Pago extends modeloBase{
    public $id; 
    public $id_cliente; 
    public $monto; 
    public $fecha; 
    public $descripcion; 

    public function __construct()
    {
        parent::__construct();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getId_cliente()
    {
        return $this->id_cliente;
    }
    
    public function getMonto()
    {
        return $this->monto;
    }
    
    public function getFecha()
    {
        return $this->fecha;
    }
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    public function setId_cliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }
    
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }
    
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }
    
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function pago(){

        $id_cliente = $this->id_cliente;
        $monto = $this->monto;
        $fecha = $this->fecha;
        $descripcion = $this->descripcion;
        
        $sql = "INSERT INTO pagos (id, id_cliente, monto, fecha, descripcion) 
                VALUES (null, '$id_cliente', '$monto', '$fecha', '$descripcion')";

        $result = $this->db->query($sql);
        
        return $result;

    }

    public function listaPagos(){
        $id = $this->id;

        $sql = " SELECT * FROM pagos WHERE id_cliente = $id ORDER BY id DESC";

        $result = $this->db->query($sql);
        
        return $result;
    }

    public function borrar(){
        $id = $this->id;

        $sql = "DELETE FROM pagos WHERE id = $id";

        $result = $this->db->query($sql);

        return $result;
    }

    public function buscar($search){
        // SELECT * FROM pagos WHERE fecha LIKE '%oll%' OR descripcion LIKE '%oll%' OR monto LIKE '%oll%' AND id_cliente =2 ;
        $id = $this->id;
        $sql = "SELECT * FROM pagos WHERE fecha LIKE '%$search%' OR descripcion LIKE '%$search%' OR monto LIKE '%$search%' HAVING id_cliente = $id";
        
        $result = $this->db->query($sql);

        return $result;
    }

    public function lastFive(){
        // $sql = "SELECT * FROM pagos WHERE id = $id LIMIT 5 ORDER BY id DESC";
    }

    public function totalPagos($id){
        $sql = "select sum(monto) AS Total from credito where id_cliente = $id";
        $result = $this->db->query($sql);

        return $result;
    }

    
}

?>
