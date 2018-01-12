<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Factura
 *
 * @author cirsisdfg
 */

require_once 'model/ingresos/facade/FacturaFacade.php';
require_once 'model/kardex/facade/KardexFacade.php';

class FacturaCommonControl {
    
    public function getImprimirFactura($request){
        
        ob_get_clean();
        
        $facturaId = $request->factura_id;
        
        $facturaFacade = new FacturaFacade();
        $kardexFacade = new KardexFacade();
        
        $factura = $facturaFacade->findById($facturaId);
        
        $actualizado = $facturaFacade->actualizarNumeracionFactura($factura);
        
        $mensaje = '';
        
        if($actualizado == false){
            $mensaje = 'Error. No se pudo actualizar la numeracion de la factura';
            echo json_encode(array('actualizado' => $actualizado, 'mensaje' => $mensaje));
            die;
        }
        
//        TODO: validar la creacion del movimiento del inventario
        $actualizado = $kardexFacade->crearKardex($factura);
        
        echo json_encode(array('factura' => $facturaFacade->imprimirFactura($factura)));
    }
    
}
