<?php 
require_once "models/modelobase.php";
require_once "lib/fpdf/fpdf.php";
require_once "lib/phpExcel/PHPExcel.php";

class Producto extends modeloBase{
    public $id;
    public $nombre;
    public $id_categoria;
    public $descripcion;
    public $precio;
    public $mayoreo;
    public $menudeo;
    public $imagen;
    public $stok;
    public $stockMin;

    public function __construct()
    {
        parent:: __construct();
    }

    public function getImagen()
    {
        return $this->menudeo;
    }
    
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getMenudeo()
    {
        return $this->menudeo;
    }
    
    public function setMenudeo($menudeo)
    {
        $this->menudeo = $menudeo;

        return $this;
    }

    public function getMayoreo()
    {
        return $this->mayoreo;
    }
    
    public function setMayoreo($mayoreo)
    {
        $this->mayoreo = $mayoreo;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getId_categoria()
    {
        return $this->id_categoria;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function getPrecio()
    {
        return $this->precio;
    }
    
    public function setStok($stok)
    {
        $this->stok = $stok;

        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    public function setId_categoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;

        return $this;
    }
    
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
    
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }
    
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    public function getStok()
    {
        return $this->stok;
    }

    public function getStockMin()
    {
        return $this->stockMin;
    }
    public function setStockMin($stockMin)
    {
        $this->stockMin = $stockMin;

        return $this;
    }

    public function succesMessage(){
        $emojy = array("🤞 😜","🤳 🙌","😍","😆","😃 ✨","✔", "🎉👏");
        return $emojy[rand(0, sizeof($emojy)-1)];
    }

    public function DB(){
        return $this->db;
    }

    public function entity(){
        $sql = "SELECT * FROM producto";
        $entity = $this->db->query($sql);
        $entity->fetch_object();

        return $entity;

    }

    public function totalProducts(){
        $sql = "SELECT COUNT(id) as 'total' FROM producto";
        $res = $this->db->query($sql);
        $total = $res->fetch_object()->total;

        return $total;
    }

    public function guardar(){
        Utils::isIdentity();

        $id_categoria = $this->id_categoria;
        $nombre = $this->nombre;
        $descripcion = $this->descripcion;
        $precio = $this->precio;
        $mayoreo = $this->mayoreo;
        $menudeo = $this->menudeo;
        $image = $this->imagen;
        $stok = $this->stok;
        $stockMin = $this->stockMin;

        $sql = "INSERT INTO producto (id_categoria, nombre, descripcion, precio, stok, min, precio_menudeo, precio_mayoreo, image) 
                VALUES (?,?,?,?,?,?,?,?,?)";
        
        $query = $this->db->prepare($sql);
        $query->bind_param('issiiisis',$id_categoria, $nombre, $descripcion, $precio, $stok, $stockMin, $menudeo, $mayoreo, $image);
        
        $res = Array("datos" => Array());

        if ($query->execute()) {
            $res["datos"][] = "success";
            $res["datos"][] = "Producto: $nombre, registrado correctamente ".$this->succesMessage();
        }else{
            $e = $this->db->error;
            $res["datos"][] = "error";
            $res["datos"][] = $e;
        }

        return json_encode($res);
    }

    public function buscar($search){
        //Utils::isIdentity();
        $sql = "SELECT * FROM producto WHERE
         id_categoria LIKE '%$search%' OR
         nombre LIKE '%$search%' OR 
         descripcion LIKE '%$search%' OR 
         precio LIKE '%$search%' OR 
         stok LIKE '%$search%' ";

        $result = $this->db->query($sql);
        return $result;
    }

    public function borrar(){
        //Utils::isIdentity();
        $id = $this->id;

        $sql = "UPDATE producto SET estatus=0 WHERE id = $id";
        $result = $this->db->query($sql);

        return $result;
    }

    public function precio(){
        //Utils::isIdentity();
        $id = $this->id;
        $sql = "select precio, stok from producto where id = $id";

        $result = $this->db->query($sql);

        return $result;
    }

    public function actualizar(){
        Utils::isIdentity();
        $res = Array("datos" => Array());
        $sql = "UPDATE producto SET
                id_categoria = ?, nombre = ?, descripcion = ?, precio = ?, stok = ?,
                min = ?, precio_menudeo = ?, precio_mayoreo = ?, image = ?
                WHERE id = ? ";
        $p = $this->db->prepare($sql);
        
        // echo 'issiiiiisi ', "$this->id_categoria, $this->nombre, $this->descripcion, $this->precio,
        // $this->stok, $this->stockMin, $this->menudeo, $this->mayoreo, $this->imagen, $this->id";
        
        $p->bind_param('issiiiiisi', $this->id_categoria, $this->nombre, $this->descripcion, $this->precio,
            $this->stok, $this->stockMin, $this->menudeo, $this->mayoreo, $this->imagen, $this->id);

        if ($p->execute()) {
            $res["datos"][] = "success";
            $res["datos"][] = "Producto: $this->nombre, actualizado 😁👌";
        }else {
            $res["datos"][] = "error";
            $res["datos"][] = $sql;
        }

        return json_encode($res);
    }

    public function byCategory($id){
        //Utils::isIdentity();
        $sql = "SELECT * FROM producto WHERE id_categoria=$id";
        $res = $this->db->query($sql);

        return $res;
    }

    public function selectOne($search){
        //Utils::isIdentity();
        $sql = "SELECT * FROM producto WHERE id LIKE '%$search%' OR nombre LIKE '%$search%' HAVING estatus=1 LIMIT 1";
        $query = $this->db->query($sql);

        // echo $this->db->error;
        // die();
        return $query;
    }

    public function find($id){
        Utils::isIdentity();

        $sql = "SELECT p.nombre, p.descripcion, p.precio, p.stok, p.min, p.precio_menudeo, p.precio_mayoreo, p.image, p.id, c.nombre AS 'caregory'
        FROM producto p 
        INNER JOIN categoria c ON  p.id_categoria = c.id
        WHERE p.id = $id";
       
        $entity = $this->db->query($sql);
        return $entity->fetch_object();
    }

    public function onyShortage(){
        //Utils::isIdentity();
        $sql = "SELECT * FROM producto WHERE min > stok HAVING estatus=1";
        $query = $this->db->query($sql);

        return $query;
    }

    public function abastecer(){
        Utils::isIdentity();
        $sql = "UPDATE producto SET stok = stok + {$this->stok} WHERE id = {$this->id}";
        $query = $this->db->query($sql);
        $res = Array("datos" => Array());

        if ($query) {
            $res["datos"][] = "success";
        } else {
            $res["datos"][] = "Error";
            $res["datos"][] = $this->db->error;;
        }

        return json_encode($res);
    }

    public function abastos(){
        Utils::isIdentity();
        $sql = "INSERT INTO abastos (id, id_prod, piezas, fecha) 
                VALUES (null, {$this->id}, '{$this->stok}', CURDATE())";

        $query = $this->db->query($sql);
        $res = Array("datos" => Array());

        if ($query) {
            $res["datos"][] = "success";
        } else {
            $res["datos"][] = "Error";
            $res["datos"][] = $this->db->error;;
        }

        return json_encode($res);
    }

    public function history(){
        Utils::isIdentity();
        $sql = "SELECT a.id, a.id_prod, a.piezas, a.fecha, p.nombre AS 'producto'
                FROM abastos a
                INNER JOIN producto p ON a.id_prod = p.id";
        // $sql = "SELECT * FROM abastos ORDER BY id DESC LIMIT 10";    
        $result = $this->db->query($sql);
        
        return $result;
    }

    public function listarVendidos($id_product){
        $sql = "SELECT * FROM compra WHERE id_prod = $id_product HAVING estatus = 1";
        $result = $this->db->query($sql);
        
        return $result;      
            
    }

    public function toPDFHistory(){
        //Utils::isIdentity();
        $fecha = date("d/m/Y");

        $pdf = new FPDF();
        
        $sql = "SELECT * FROM abastos ORDER BY id DESC";
        $result = $this->db->query($sql);

        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 16);
        $pdf->SetTextColor(255, 51, 51);
        $pdf->Cell(190, 10, 'Reporte de Abastos hasta el '.$fecha, 0, 0, 'C');

        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 10);

        $pdf->SetFillColor(255, 150, 150);
        $pdf->Cell(15, 6, '#', 1, 0, 'C', true);
        $pdf->Cell(15, 6, 'id prod.', 1, 0, 'C', true);
        $pdf->Cell(80, 6, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(50, 6, 'Piezas ingesadas', 1, 0, 'C', true);
        $pdf->Cell(30, 6, 'Fecha', 1, 0, 'C', true);
        
        $pdf->Ln();

        while ($p = $result->fetch_object()) {

            $pdf->Cell(15, 6, $p->id, 1, 0, 'C');
            $pdf->Cell(15, 6, $p->id_prod, 1, 0, 'C');
            $pdf->Cell(80, 6, $p->nombre, 1, 0, 'C');
            $pdf->Cell(50, 6, $p->piezas, 1, 0, 'C');
            $pdf->Cell(30, 6, $p->fecha, 1, 0, 'C');

            $pdf->Ln();
        }

        $pdf->Output();
    }

    public function toExcelHistory(){
        //Utils::isIdentity();
        $fecha = date("d/m/Y");

        $e = new PHPExcel();
        $e->getActiveSheet()->setCellValue("A1", "Todas los abastos hasta el: " . $fecha);

        //$sql = "SELECT * FROM abastos ORDER BY id DESC";
        $sql = "SELECT a.id, a.id_prod, a.piezas, a.fecha, p.nombre AS 'producto'
                FROM abastos a
                INNER JOIN producto p ON a.id_prod = p.id";
        $RESULT_SET = $this->db->query($sql);

        $e->getActiveSheet()->setCellValue("A3", "");
        $e->getActiveSheet()->setCellValue("B3", utf8_decode("id Producto"));
        $e->getActiveSheet()->setCellValue("C3", utf8_decode("Nombre"));
        $e->getActiveSheet()->setCellValue("D3", utf8_decode("Pz"));
        $e->getActiveSheet()->setCellValue("E3", utf8_decode("Fecha"));

        $c = 4;

        while ($r = $RESULT_SET->fetch_object()) {
            $e->getActiveSheet()->setCellValue("A".$c, $r->id);
            $e->getActiveSheet()->setCellValue("B".$c, $r->id_prod);
            $e->getActiveSheet()->setCellValue("C".$c, $r->producto);
            $e->getActiveSheet()->setCellValue("D".$c, $r->piezas);
            $e->getActiveSheet()->setCellValue("E".$c, $r->fecha);
            $c++;
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ReporteDeAbastos.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        ob_end_clean();
        
        $objWriter = PHPExcel_IOFactory::createWriter($e, 'Excel5');
        $objWriter->save('php://output');
    }

    public function listSurtit(){
        //Utils::isIdentity();
        $sql = "SELECT id, nombre, (min-stok) AS faltantes FROM producto WHERE (stok < min) AND estatus = 1 ORDER BY faltantes DESC LIMIT 10";
        $result = $this->db->query($sql);

        if($result){
            return $result;
        }else{
            return $this->db->error;
        }
        
    }

    public function SurtirPDF(){
       // Utils::isIdentity();
        $fecha = date("d/m/Y");

        $pdf = new FPDF();
        
        $sql = "SELECT id, nombre, (min-stok) AS faltantes FROM producto WHERE (stok < min) AND estatus = 1 ORDER BY faltantes DESC";
        $result = $this->db->query($sql);

        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 24);
        $pdf->SetTextColor(255, 51, 51);
        $pdf->Cell(190, 10, 'Piezas para surtir '.$fecha, 0, 0, 'C');

        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 10);

        $pdf->SetFillColor(255, 150, 150);
        $pdf->Cell(15, 6, '#', 1, 0, 'C', true);
        $pdf->Cell(15, 6, 'id prod.', 1, 0, 'C', true);
        $pdf->Cell(100, 6, 'Nombre del producto', 1, 0, 'C', true);
        $pdf->Cell(50, 6, 'Piezas faltantes', 1, 0, 'C', true);
        $pdf->Cell(10, 6, 'Check', 1, 0, 'C', true);
        
        $pdf->Ln();
        $n = 1;
        while ($p = $result->fetch_object()) {

            $pdf->Cell(15, 6, $n, 1, 0, 'C');
            $pdf->Cell(15, 6, $p->id, 1, 0, 'C');
            $pdf->Cell(100, 6, $p->nombre, 1, 0, 'C');
            $pdf->Cell(50, 6, $p->faltantes, 1, 0, 'C');
            $pdf->Cell(10, 6, '', 1, 0, 'C');

            $n ++;

            $pdf->Ln();
        }

        $pdf->Output();
    }

    public function store(){
        //Utils::isIdentity();
        $fecha = date("d/m/Y");
        $titleFile = "ReporteDelAlmacén_$fecha.xls";

        $e = new PHPExcel();
        $e->getActiveSheet()->setCellValue("A1", "Estado actual del almacén: " . $fecha);

        $sql = "SELECT * FROM producto WHERE estatus = 1 ORDER BY id DESC ";
        $RESULT_SET = $this->db->query($sql);

        $e->getActiveSheet()->setCellValue("A3", "");
        $e->getActiveSheet()->setCellValue("B3","id Producto");
        $e->getActiveSheet()->setCellValue("C3","id Cat.");
        $e->getActiveSheet()->setCellValue("D3","Nombre");
        $e->getActiveSheet()->setCellValue("E3","Pz");
        $e->getActiveSheet()->setCellValue("F3","Desc.");
        $e->getActiveSheet()->setCellValue("G3","Precio");
        $e->getActiveSheet()->setCellValue("H3","Precio menudeo");
        $e->getActiveSheet()->setCellValue("I3","Precio mayoreo");
        $e->getActiveSheet()->setCellValue("J3","Stock");
        $e->getActiveSheet()->setCellValue("K3","StockMin");

        $c = 4;

        while ($r = $RESULT_SET->fetch_object()) {
            $e->getActiveSheet()->setCellValue("B".$c, $r->id);
            $e->getActiveSheet()->setCellValue("C".$c, $r->id_categoria);
            $e->getActiveSheet()->setCellValue("D".$c, $r->nombre);
            $e->getActiveSheet()->setCellValue("E".$c, $r->stok);
            $e->getActiveSheet()->setCellValue("F".$c, $r->descripcion);
            $e->getActiveSheet()->setCellValue("G".$c, $r->precio);
            $e->getActiveSheet()->setCellValue("H".$c, $r->precio_menudeo);
            $e->getActiveSheet()->setCellValue("I".$c, $r->precio_mayoreo);
            $e->getActiveSheet()->setCellValue("J".$c, $r->stok);
            $e->getActiveSheet()->setCellValue("K".$c, $r->min);
            $c++;
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$titleFile");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        ob_end_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($e, 'Excel5');
        $objWriter->save('php://output');
    }


    public function Image($id){
        $sql = "SELECT image from producto WHERE id = $id";
        $img = $this->db->query($sql);
        $nombreImagen = $img->fetch_object()->image;
        return $nombreImagen;
    }
}
?>