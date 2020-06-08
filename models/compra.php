<?php
require_once "models/modeloBase.php";
require_once "lib/phpExcel/PHPExcel.php";
require_once "lib/fpdf/fpdf.php";


class Compra extends modeloBase
{
    public $id;
    public $id_user;
    public $id_prod;
    public $cantidad;
    public $total;
    public $nota;
    public $fecha;
    public $nombre;
    public $producto;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getId_user()
    {
        return $this->id_user;
    }

    public function getId_prod()
    {
        return $this->id_prod;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getNota()
    {
        return $this->nota;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    public function compra()
    {

        $id_user = $this->id_user;
        $id_prod = $this->id_prod;
        $cantidad = $this->cantidad;
        $total = $this->total;
        $nota  = $this->nota;
        $nombre = $this->nombre;
        $producto = $this->producto;

        $sqlProd = "UPDATE producto    
                    SET stok = stok - $cantidad
                    WHERE id = $id_prod";
        
        $prd = $this->db->query($sqlProd);

        $sql = "INSERT INTO compra (id, id_user, id_prod, cantidad, total, nota, fecha, nombre, producto) VALUES(null, $id_user, $id_prod, $cantidad, $total, '$nota', CURDATE(), '$nombre', '$producto' )";

        $result = $this->db->query($sql);

        return array($result, $prd);
    }

    public function todosVE()
    {
        $sql = "SELECT id, id_user, cantidad, total, nota, fecha, nombre, producto FROM compra ORDER BY id DESC";
        $result = $this->db->query($sql);

        return $result;
    }

    public function SchTodosVE($search)
    {

        $sql = "SELECT * FROM compra WHERE 
        producto LIKE '%$search%' or 
        nombre LIKE '%$search%' or 
        id_user like '%$search%' or
        fecha like '%$search%'  or
        total like '%$search%' or   
        nota like '%$search%' ORDER BY id DESC";

        $result = $this->db->query($sql);

        // echo $this->db->error;
        // die();

        return $result;
    }

    public function excel()
    {
        $fecha = date("d/m/Y");

        $e = new PHPExcel();
        $e->getActiveSheet()->setCellValue("A1", "Todas las compras hasta el: " . $fecha);

        $sql = "SELECT * FROM compra ORDER BY id DESC";
        $result = $this->db->query($sql);
        // $sql = "SELECT * FROM compra WHERE 
        // producto LIKE '%$search%' or 
        // nombre LIKE '%$search%' or 
        // id_user like '%$search%' or
        // fecha like '%$search%'  or
        // total like '%$search%' or   
        // nota like '%$search%'    ";

        // $result = $this->db->query($sql);

        $e->getActiveSheet()->setCellValue("A3", "# de compra");
        $e->getActiveSheet()->setCellValue("B3", "fecha");
        $e->getActiveSheet()->setCellValue("C3", "id_user");
        $e->getActiveSheet()->setCellValue("D3", "nombre");
        $e->getActiveSheet()->setCellValue("E3", "id_prod");
        $e->getActiveSheet()->setCellValue("F3", "producto");
        $e->getActiveSheet()->setCellValue("G3", "pz");
        $e->getActiveSheet()->setCellValue("H3", "total");
        $e->getActiveSheet()->setCellValue("I3", "nota");

        $c = 4;

        while ($r = $result->fetch_object()) {
            $e->getActiveSheet()->setCellValue("A" . $c, $r->id);
            $e->getActiveSheet()->setCellValue("B" . $c, $r->fecha);
            $e->getActiveSheet()->setCellValue("C" . $c, $r->id_user);
            $e->getActiveSheet()->setCellValue("D" . $c, $r->nombre);
            $e->getActiveSheet()->setCellValue("E" . $c, $r->id_prod);
            $e->getActiveSheet()->setCellValue("F" . $c, $r->producto);
            $e->getActiveSheet()->setCellValue("G" . $c, $r->cantidad);
            $e->getActiveSheet()->setCellValue("H" . $c, $r->total);
            $e->getActiveSheet()->setCellValue("I" . $c, $r->nota);

            $c++;
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ReporteDeVentas' . $fecha . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($e, 'Excel5');
        $objWriter->save('php://output');
    }

    public function PDF()
    {
        $fecha = date("d/m/Y");

        $pdf = new FPDF();
        
        $sql = "SELECT * FROM compra ORDER BY id DESC";
        $result = $this->db->query($sql);

        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 16);
        $pdf->SetTextColor(255, 51, 51);
        $pdf->Cell(190, 10, 'Reporte de Ventas hasta el '.$fecha, 0, 0, 'C');

        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 10);

        $pdf->SetFillColor(255, 150, 150);
        $pdf->Cell(5, 6, '#', 1, 0, 'C', true);
        $pdf->Cell(26, 6, 'fecha', 1, 0, 'C', true);
        $pdf->Cell(10, 6, '#Clte', 1, 0, 'C', true);
        $pdf->Cell(36, 6, 'Cliente', 1, 0, 'C', true);
        $pdf->Cell(10, 6, '#prod', 1, 0, 'C', true);
        $pdf->Cell(41, 6, 'producto', 1, 0, 'C', true);
        $pdf->Cell(10, 6, 'Pz', 1, 0, 'C', true);
        $pdf->Cell(21, 6, 'total', 1, 0, 'C', true);
        $pdf->Cell(31, 6, 'nota', 1, 0, 'C', true);
        $pdf->Ln();

        while ($c = $result->fetch_object()) {

            $pdf->Cell(5, 6, $c->id, 1, 0, 'C');
            $pdf->Cell(26, 6, $c->fecha, 1, 0, 'C');
            $pdf->Cell(10, 6, $c->id_user, 1, 0, 'C');
            $pdf->Cell(36, 6, $c->nombre, 1, 0, 'C');
            $pdf->Cell(10, 6, $c->id_prod, 1, 0, 'C');
            $pdf->Cell(41, 6, $c->producto, 1, 0, 'C');
            $pdf->Cell(10, 6, $c->cantidad, 1, 0, 'C');
            $pdf->Cell(21, 6, '$'.$c->total, 1, 0, 'C');
            $pdf->Cell(31, 6, $c->nota, 1, 0, 'C');

            $pdf->Ln();
        }

        $pdf->Output();
    }

    public function ventaLibre(){
        $id_cliente = $this->id_user;
        $nombre_cliente = $this->nombre;
        $monto = $this->total;
        $nota = $this->nota;

        $sql = "INSERT INTO credito (id, id_cliente, monto, nota, fecha, nombre_cliente)
                VALUES(null, '$id_cliente', '$monto', '$nota', CURDATE(), '$nombre_cliente')";

        $result = $this->db->query($sql);

        // echo $this->db->error;
        // die();
        return $result;
    }

    public function buscarVL($s){

        $search = $this->db->real_escape_string($s);

        $sql = "SELECT * FROM credito WHERE 
                id_cliente LIKE '%$search%' OR 
                monto LIKE '%$search%' OR
                nota LIKE '%$search%' OR
                fecha LIKE '%$search%' OR
                nombre_cliente LIKE '%$search%' ORDER BY id DESC";

        $result = $this->db->query($sql);

        // echo $this->db->error;
        // die();
        return $result;
    }

    public function freeSalesbyUser(){
        $sql = "SELECT * FROM credito WHERE id_cliente = $this->id_user";
        $result = $this->db->query($sql);

        return $result;
    }
}
