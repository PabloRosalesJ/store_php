<?php 

require_once "models/modelobase.php";

class Utils extends modeloBase{

    public function __construct()
    {
        parent:: __construct();
    }

    public static function isIdentity(){
        if (!$_SESSION["identity"]) {
            header("Location:http://store.test/?c=usuario&a=login");
        }
    }

    public function publicPath(){
        return '';
    }

    public function backUp(){
        
        $time = time();
        $fecha = date('Y-m-d', $time);

        // Database configuration
        $host = "localhost";
        $username = "root";
        $password = "";
        $database_name = "store";

        // Get connection object and set the charset
        $conn = mysqli_connect($host, $username, $password, $database_name);
        $conn->set_charset("utf8");


        // Get All Table Names From the Database
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        $sqlScript = "";
        foreach ($tables as $table) {
            
            // Prepare SQLscript for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);
            
            $sqlScript .= "\n\n" . $row[1] . ";\n\n";
            
            
            $query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $query);
            
            $columnCount = mysqli_num_fields($result);
            
            // Prepare SQLscript for dumping data for each table
            for ($i = 0; $i < $columnCount; $i ++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sqlScript .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j ++) {
                        $row[$j] = $row[$j];
                        
                        if (isset($row[$j])) {
                            $sqlScript .= '"' . $row[$j] . '"';
                        } else {
                            $sqlScript .= '""';
                        }
                        if ($j < ($columnCount - 1)) {
                            $sqlScript .= ',';
                        }
                    }
                    $sqlScript .= ");\n";
                }
            }
            
            $sqlScript .= "\n"; 
        }

        if(!empty($sqlScript))
        {   
            // Save the SQL script to a backup file
            $backup_file_name = $database_name . '_backup_' . $fecha . '.sql';
            $fileHandler = fopen($backup_file_name, 'w+');
            $number_of_lines = fwrite($fileHandler, $sqlScript);
            fclose($fileHandler); 

            // Download the SQL backup file to the browser
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backup_file_name));
            ob_clean();
            flush();
            readfile($backup_file_name);
            exec('rm ' . $backup_file_name); 
        }
    }

    public static function ProductRequest(){
       
        $id_categoria = (is_numeric($_POST["id_categoria"]) && $_POST["id_categoria"] != '' && $_POST["id_categoria"]>0) ? $_POST["id_categoria"] : false;
        $nombre = $_POST["nombre"] != '' ? $_POST["nombre"] : false;
        $descripcion = $_POST["descripcion"] != '' ? $_POST["descripcion"] : false;
        $precio = (is_numeric($_POST["precio"]) && $_POST["precio"] != '' && $_POST["precio"]>0) ? $_POST["precio"] : false;
        $mayoreo = (is_numeric($_POST["mayoreo"]) && $_POST["mayoreo"] != '' && $_POST["mayoreo"]>0) ? $_POST["mayoreo"] : false;
        $menudeo = (is_numeric($_POST["menudeo"]) && $_POST["menudeo"] != '' && $_POST["menudeo"]>0) ? $_POST["menudeo"] : false;
        $stock = (is_numeric($_POST["stock"]) && $_POST["stock"] != '' && $_POST["stock"]>0) ? $_POST["stock"] : false;
        $stockMin = (is_numeric($_POST["stock_min"]) && $_POST["stock_min"] != ''  && $_POST["stock_min"]>0) ? $_POST["stock_min"] : false;
        
        if ($id_categoria && $nombre && $descripcion && $precio && $mayoreo && $menudeo && $stock && $stockMin) {

            return true;
        }

        return false;
    }

    public static function Store(){
        
        $res = Array("datos" => Array());
            
            $imagen = $_FILES['imagen'];
            
            $nombreImagen = $imagen['name'];
            $nombreImagen = str_shuffle($nombreImagen).str_replace(' ', '', $nombreImagen);

            if (trim($nombreImagen) == '') {
                
                $nombreImagen = "product.png"; 

            }else {
                
                $type = $imagen['type'];
    
                if ($type  == "image/png" || $type  == "image/jpeg" || $type  == "image/jpg") {
    
                    if(!is_dir('img')){
    
                        mkdir('img', 0777);
                    }
    
                    move_uploaded_file($imagen['tmp_name'], 'img/'.$nombreImagen);
    
                } else{
                    $res['datos'][] = "error";
                    $res['datos'][] = "El formato de la imagen es incorrectro 🤔";
                    echo json_encode($res); 
                }
            }

            return $nombreImagen;
    }

    public static function Product($action, $image){
        
        $producto = new Producto();
        
        if (isset($_POST['id_prod'])){
            $id = (int) $_POST["id_prod"];
            $producto->setId($id);
        }
        
        $producto->setId_categoria($_POST["id_categoria"]);
        $producto->setNombre(strtolower($_POST["nombre"]));
        $producto->setDescripcion(strtolower($_POST["descripcion"]));
        $producto->setPrecio($_POST["precio"]);
        $producto->setMayoreo($_POST["mayoreo"]);
        $producto->setMenudeo($_POST["menudeo"]);
        $producto->setImagen($image);
        $producto->setStok($_POST["stock"]);
        $producto->setStockMin($_POST["stock_min"]);
        
        echo $producto->$action();
    }

    
}

?>