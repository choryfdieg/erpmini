<?php

require('work/fpdf/fpdf.php');

class FacturaPDF extends FPDF {

    var $B;
    var $I;
    var $U;
    var $HREF;
    var $currentFontSize;

    public $facturaCabecera;
    public $facturaProductos;
    public $facturaFormasPago;
    
    function __construct($fontSize) {
        parent::__construct();
        $this->currentFontSize = $fontSize;
    }

//    function Header() {
//        
//    }
//
//    function Footer() {
//    }

    // Tabla coloreada
    function FancyTable($header, $data, $fontSize) {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(150, 150, 150);
        $this->SetTextColor(255);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B', $fontSize);
        // Cabecera
        $w = array();
        foreach ($header as $value) {
            $w[] = $value['width'];
        }
        
        // ***
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 6, $header[$i]['value'], 1, 0, 'C', true);
        if(!empty ($header))
            $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->SetFontSize($fontSize);
        // Datos
        $fill = false;

        foreach ($data as $rows) {
            
            $index = 0;
            
            foreach ($rows as $key => $row) {

                $this->Cell($w[$index], 5, $row, 'LR', 0, 'L', $fill);

                $this->SetFontSize($fontSize);

                $index +=1;
            }

            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
    
    public function generar(){
        
        ob_get_clean();
        
        $tipoDocumento = 'Factura de venta';
        
        if($this->facturaCabecera['tipo_factura_id'] == 2){
            $tipoDocumento = 'Nota credito';            
        }
        
        $this->AddPage();
        $this->SetFont('Arial','B',16);
        
        $this->Cell(40, 10, $tipoDocumento);
        
        $this->Ln(15);

        $this->Cell(40,10,'Fecha Factura: ' . $this->facturaCabecera['fecha_apertura'],0,1);
        $this->Cell(40,10,'Numero Factura: ' . $this->facturaCabecera['prefijo'] . '-' . $this->facturaCabecera['numero'],0,1);
        $this->Cell(40,10,$this->facturaCabecera['texto_numeracion'],0,1);
        $this->Cell(40,10,$this->facturaCabecera['texto_resolucion'],0,1);
        $this->Cell(40,10,'Cliente: ' . $this->facturaCabecera['nombre'] . '(' . $this->facturaCabecera['sigla'] . ':' . $this->facturaCabecera['documento'] . ')',0,1);
        
        $this->Ln(15);
        
        $header = array();
        
        $header[] = array('width' => 20, 'value' => 'producto');
        $header[] = array('width' => 25, 'value' => 'unidad_medida');
        $header[] = array('width' => 20, 'value' => 'impuesto');
        $header[] = array('width' => 20, 'value' => 'cantidad');
        $header[] = array('width' => 20, 'value' => 'valor_unitario');
        $header[] = array('width' => 20, 'value' => 'descuento');
        $header[] = array('width' => 20, 'value' => 'valor_total');
        $header[] = array('width' => 25, 'value' => 'valor_impuesto');
        
        $this->FancyTable($header, $this->facturaProductos, 8);
        
        $this->Ln(15);
        
        $header = array();
        
        $header[] = array('width' => 20, 'value' => 'forma pago');
        $header[] = array('width' => 20, 'value' => 'Valor');
        
        $this->FancyTable($header, $this->facturaFormasPago, 8);
        
        $this->Ln(15);
        
        $this->Cell(40,10,'Cajero: ' . $this->facturaCabecera['cajero'],0,1);
        
        $this->Output('F', 'factura.pdf');
        
        $file = base64_encode(file_get_contents('factura.pdf'));
        
        return $file;
        
    }
    

}