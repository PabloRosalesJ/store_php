<?php 

require_once "modeloBase.php";

class Categoria extends modeloBase{
    public $id;
    public $nombre;

    public function __construct()
    {
        parent::__construct();
    }
     
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    } 

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
    
    public function crear(){

        $nombre = $this->nombre;
        $sql = "INSERT INTO categoria (id, nombre) values (null, '$nombre')";

        $result = $this->db->query($sql);

        echo $this->db->error;
        die();

        return $result;
    }

    public function buscar($search){
        $sql = "SELECT * FROM categoria WHERE nombre LIKE '%$search%'";

        $result = $this->db->query($sql);
        return $result;
    }

    public function eliminar($id){
        
        // $preSQL = "SELECT estatus FROM categoria WHERE id = $id";
        
        $sql = "UPDATE categoria SET estatus = 0 WHERE id = $id";
        $result = $this->db->query($sql);

        // $e = $res->fetch_object();
        // $estado = $e->estatus;

        // if ($estado == 1) {
        //     $sql = "UPDATE categoria SET estatus = 0 WHERE id = $id";
        // } else if($estado == 0) {
        //     $sql = "UPDATE categoria SET estatus = 1 WHERE id = $id";
        // }
        
        // $result = $this->db->query($sql);

        // echo $this->db->error;
        // die();
        return $result;
    }
}

?>  