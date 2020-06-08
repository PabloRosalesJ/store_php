<?php
require_once "models/usuario.php";

class usuarioController{
    
    public function __construct()
    {

    }

    public function admin(){
        Utils::isIdentity();

       require_once "views/usuario/admin.php";

    }

    public function index(){
        Utils::isIdentity();

        // $user = new Usuario();
        // $usuarios = $user->todos('user');

        require_once "views/usuario/listar.php";
    }

    public function listar(){
        Utils::isIdentity();

        $pagina = (int) $_GET["p"];
        $p = 30;
        $ls = $pagina * $p;
        $li = $ls - $p;

        $user = new Usuario();
        $usuarios = $user->all($li, $ls);
        
        $t = $user->count();
        $total = ceil($t/$p);

        $res = Array( "datos" => Array() );
        
        while ($row = $usuarios->fetch_object()) {
            $res["datos"][] = $row;
        }

        $res["total"][] = $total;
        echo json_encode($res);
    }

    public function crear(){
        Utils::isIdentity();

        require_once "views/usuario/crear.php";
    }

    public function ver(){
        Utils::isIdentity();

        if ($_GET) {
            $id_usario = $_GET["id"];
            if (is_numeric($id_usario)) {
                $usario = new Usuario();
        
                $usario->setId($id_usario);
                $user = $usario->ver();
                
                require_once "views/usuario/ver.php";
            }else {
                echo "<h1>Bad Request</h1><h2>Client not found ...</h2>";
            }
        }

    }

    public function guardar(){
        Utils::isIdentity();

        if ($_POST) {

            $usuario = new Usuario();

            $errores = 0;

            $nombre = (isset($_POST["nombre"]) && ($_POST["nombre"] != "" && !preg_match("/[0-9]/",$_POST["nombre"]))) ? trim($_POST["nombre"]) : $errores++;
            // echo $errores."<bh>";
            
            $apellidos = (isset($_POST["apellidos"]) && ($_POST["apellidos"] != "" && !preg_match("/[0-9]/",$_POST["apellidos"]))) ? trim($_POST["apellidos"]) : $errores++;
            // echo $errores."<bh>";

            $direccion = (isset($_POST["direccion"]) && ($_POST["direccion"] != "" && !preg_match("/[0-9]/",$_POST["direccion"]))) ? trim($_POST["direccion"]) : $errores++;
            // echo $errores."<bh>";

            $telefono = (isset($_POST["telefono"]) && ($_POST["telefono"] != "" && preg_match("/[0-9]/",$_POST["telefono"]))) ? trim($_POST["telefono"]) : $errores++;
            // echo $errores."<bh>";

            if ($errores == 0) {
                echo "1";
                $usuario->setNombre(strtolower($nombre));
                $usuario->setApellidos(strtolower($apellidos));
                $usuario->setDireccion(strtolower($direccion));
                $usuario->setTelefono($telefono);
                echo "2";

                $usuario->crear();
                echo "3";

                header("Location:http://store.test/?c=usuario&a=index");
            } else {
                header("Location:http://store.test/?c=usuario&a=crear");
            }
            
        }
    }

    public function eliminar(){
        Utils::isIdentity();

        if (isset($_POST)) {
            $usario = new Usuario();

            $usario->setId($_POST["id"]);
            $usario->eliminar();

        }
        header("Location:http://store.test/?c=usuario&a=index");
    }

    public function buscar(){
        Utils::isIdentity();

        $user = new Usuario();
        $search = $_POST["search"];

        $usuarios = $user->buscar($search);

        $res = Array( "datos" => Array() );
        
        while ($row = $usuarios->fetch_object()) {
            $res["datos"][] = $row;
        }
        echo json_encode($res);
    }

    public function changeEstado(){
        Utils::isIdentity();

        if ($_GET) {

            $id = $_GET["id"];
            
            $user = new Usuario();
            $user->setId($id);
            
            $user = $user->estado();
            
            header("Location:http://store.test/?c=usuario&a=ver&id=$id");

        }
    }

    public function select(){
        Utils::isIdentity();

        if ($_POST["search"]) {

            $search = $_POST["search"];

            $usario = new Usuario();
            $user = $usario->selectUno($search);

            $res = Array("datos" => Array());

            while ($row = $user->fetch_object()) {
                
                if ($row->estatus == 0) {
                     $res["datos"][] = false;
                } elseif ($row->estatus == 1){
                    $res["datos"][] = $row;
                }
            }
            echo json_encode($res);

            
        }
    }

    public function update(){
        Utils::isIdentity();

        if ($_POST) {
            $res = Array('datos'=>Array());

            $id = $_POST["id"];
            $nombre = isset($_POST["nombre"]) && $_POST["nombre"] != '' ? $_POST["nombre"] : false;
            $apellidos = isset($_POST["apellidos"]) && $_POST["apellidos"] !='' ? $_POST["apellidos"]:false;
            $direccion = isset($_POST["direccion"]) && $_POST["direccion"] !='' ? $_POST["direccion"]:false;
            $telefono = isset($_POST["telefono"]) && is_numeric($_POST["telefono"]) ? $_POST["telefono"]:false;

            if ($nombre && $apellidos && $direccion && $telefono) {
                $usario = new Usuario();
                $usario->setId($id);
                $usario->setNombre($nombre);
                $usario->setApellidos($apellidos);
                $usario->setDireccion($direccion);
                $usario->setTelefono($telefono);

                $res = $usario->actualizar();
                echo $res;
            }else {
                $res['datos'][] = "error";
                echo json_encode($res);
            }
            
        }
        else {
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function userWhitCredit(){
        Utils::isIdentity();

        $u = new Usuario();
        $user = $u->userWhitCredit();

        $res = Array("datos" => Array());

        while ($row = $user->fetch_object()) {
            $res["datos"][] = $row;
        }
        echo json_encode($res);

    }

    public function createAdmin(){
        Utils::isIdentity();

        if ($_POST) {
            $p = $_POST["password"];
            $pc = $_POST["passwordConfirm"];
            
            if((strcmp($p, $pc) === 0) && strlen($p)>4){
                if (empty($_POST["username"] && $_POST["nombre"] && $_POST["apellidos"] && $_POST["telefono"])) {
                    $res = Array("datos"=>Array());
                    $res["datos"][] = "error";
                    $res["datos"][] = "Llena todos los campos";
    
                    echo json_encode($res);
                } else {
                    $u = new Usuario();
                    $u->setUsername($_POST["username"]);
                    $u->setNombre($_POST["nombre"]);
                    $u->setApellidos($_POST["apellidos"]);
                    $u->setTelefono($_POST["telefono"]);
                    $u->setPassword($_POST["password"]);
                    echo $u->createAdmin();
                }
            } else{

                $res = Array("datos"=>Array());
                $res["datos"][] = "error";
                $res["datos"][] = "Paswords not match or meny long!";

                echo json_encode($res);
            }            

        }else {

            echo "<h1>Bad request</h1>";

        }
        
    }

    public function listAdmin(){
        Utils::isIdentity();

        $u = new Usuario();
        $result = $u->listAdmin();
        $res = Array("datos" => Array());

        while($row = $result->fetch_object()){
            $res["datos"][] = $row;
        }

        echo json_encode($res);
    }

    public function borrarAdmin(){
        Utils::isIdentity();

        if ($_POST) {
            $u = new Usuario();
            $u->setId($_POST["id"]);
            echo $u->borrarAdmin();
        }
        else{
            echo "<h1> 404 Not Found :( </h1>";
        }
    }

    public function login(){    
        require_once "views/usuario/login.php";
    }

    public function log_in(){
        if($_POST){
            $u = new Usuario();
            $u->setUsername($_POST["username"]);
            $u->setPassword($_POST["password"]);
            $identity = $u->login();
            
            if ($identity && is_object($identity)) {
                $_SESSION['identity'] = $identity;
                header("location:http://store.test/?c=dashboard&a=index");
            }else {
                $_SESSION['Auth_Error'] = Array("username" => $_POST["username"]);

                header("location:http://store.test/?c=usuario&a=login");
            }
        } else {
            echo "404 not found";
        }

    }

    public function logout(){
        unset($_SESSION['identity']);
        header("Location:http://store.test/?c=usuario&a=login");
    }
}