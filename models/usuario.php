<?php
require_once "models/modelobase.php";

class Usuario extends modeloBase{
    public $id;
    public $nombre;
    public $apellidos;
    public $direccion;
    public $telefono;
    public $estatus;
    public $password;
    public $username;

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

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
  
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    } 

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    } 

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }
        
    public function getPassword(){
        return $this->password;
    }
    
    public function setPassword($password){
        $this->password = $password;

        return $this;
    }

    public function getUsername(){
        return $this->username;
    }
    
    public function setUsername($username){
        $this->username = $username;

        return $this;
    }
    
    public function crear(){
        
        $sql = "INSERT INTO user(nombre, apellidos, direccion, telefono, estatus) values ('{$this->nombre}', '{$this->apellidos}', '{$this->direccion}', '{$this->telefono}', true)";

        $guardado = $this->db->query($sql);

        // --imprime los errores de mysql--
        // echo $this->db->error;
        // die();

        if ($guardado) {
            return $guardado;
        }else {
            return $this->db->error;
        }
    }

    public function ver(){
        $id = $this->id;
        $sql = "SELECT * FROM user WHERE id = $id";

        $user = $this->db->query($sql);
        return $user;
    }

    public function actualizar(){
        $res = Array('datos'=>Array());
        $sql = "UPDATE user SET
                nombre = '{$this->nombre}',
                apellidos = '{$this->apellidos}',
                direccion = '{$this->direccion}',
                telefono = '{$this->telefono}'
                
                WHERE id = {$this->id}";

        $result = $this->db->query($sql);
        
        if ($result) {
            $res['datos'][] = "succes";
        }else {
            $res['datos'][] = "error";

            $error = $this->db->error;
            $res['datos'][] = "$error";}

        return json_encode($res);
    }

    public function eliminar(){
        $id = $this->id;
        $sql = "UPDATE user SET estatus=0 WHERE id = $id;";

        $this->db->query($sql);
    }

    public function buscar($search){
        
        $sql = "SELECT * FROM user WHERE id LIKE '%$search%' OR nombre LIKE '%$search%' OR apellidos LIKE '%$search%' OR direccion LIKE '%$search%' OR telefono LIKE '%$search%' HAVING estatus = 1";

        $res = $this->db->query($sql);
        
        // Imprime errores de consulta
        // echo $this->db->error;
        // die();
        return $res;
    }

    public function estado(){
        $id = $this->id;
        $sql = "SELECT estatus FROM user WHERE id = $id";

        $user = $this->db->query($sql);
        
        $info = $user->fetch_object();
        $oldestatus = $info->estatus;
        // return $oldestatus;

        if ($oldestatus == 1) {
            $estatus = 0;
        } elseif ($oldestatus == 0) {
            $estatus = 1;
        }
        
        $nsql = "update user set estatus = $estatus where id = $id ";
        $ok = $this->db->query($nsql);

        // echo $this->db->error;
        // die();

        return $ok;
        // $sql = "update user set estatus = 0 where id = 6;";
    }

    public function selectUno($search){

        $sql = "SELECT * FROM user WHERE id LIKE '%$search%' OR nombre LIKE '%$search%' OR apellidos  LIKE '%$search%' LIMIT 1";
        
        $result = $this->db->query($sql);
        // echo $this->db->error;
        // die();
        return $result;
    }

    public function userWhitCredit(){
        $sql = "SELECT id, CONCAT(nombre, ' ',apellidos) AS Nombre FROM user WHERE id IN (SELECT id_cliente FROM credito)";

        $result = $this->db->query($sql);

        return $result;
    }

    public function createAdmin(){
        $username = trim($this->username);
        // var_dump($username);
        // die();
        $password = password_hash($this->password, PASSWORD_BCRYPT, ['cost'=>4]);

        $sql = "INSERT INTO admin (username, nombre, apellidos, telefono, password) VALUES (?,?,?,?,?)";
        $p = $this->db->prepare($sql);
        $p->bind_param('sssss', $username, $this->nombre, $this->apellidos, $this->telefono, $password);
                
        $res = Array("datos"=>Array());

        if ($p->execute()) {
            $res["datos"][] = "success";
            $res["datos"][] = "Admin Registrado";
        }else{
            $e = $this->db->error;
            $res["datos"][] = "error";
            $res["datos"][] = $e;
        }

        return json_encode($res);
    }

    public function listAdmin(){
        $sql = "SELECT id, username, CONCAT(nombre,' ',apellidos) AS nombre, telefono FROM admin WHERE estatus = 1 ORDER BY id DESC";
        $this->db->query("SET NAMES 'utf8'");
        $res = $this->db->query($sql);

        return $res;
    }

    public function borrarAdmin(){
        $sql = "update admin set estatus = 0 where id = {$this->id}";
        $result = $this->db->query($sql);
        $res = Array("datos"=>Array());

        if ($result) {
            $res["datos"][] = "success";
            $res["datos"][] = "Admin Borrado !!!";
        }else{
            $e = $this->db->error;
            $res["datos"][] = "error";
            $res["datos"][] = $e;
        }
        return json_encode($res);
    }

    public function login(){
        $result = false;
        $sql = "SELECT * FROM admin WHERE username = '{$this->username}' HAVING estatus = 1";
        $login = $this->db->query($sql);

        if($login && $login->num_rows == 1){
            $usario = $login->fetch_object();
            $verify = password_verify($this->password, $usario->password);

            if ($verify) {
                $result = $usario;
            }

        }
        return $result;
    }

    public function count(){
        $sql = "SELECT COUNT(id) AS ID FROM user";
        $n = $this->db->query($sql);
        $num = $n->fetch_object();

        return $num->ID;
        
    }

    public function all($li, $ls){
        $sql = "SELECT * FROM user WHERE id>= $li AND id <= $ls HAVING estatus = 1";
        $result = $this->db->query($sql);

        return $result;
    }

}


?>