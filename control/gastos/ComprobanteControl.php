<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of ComprobanteControl
 *
 * @author chory
 */
require_once 'control/ingresos/FacturaCommonControl.php';

class ComprobanteControl extends FacturaCommonControl{

    function ComprobanteControl() {
        $this->tipo_factura_id = FacturaFacade::$TIPO_COMPROBANTE_EGRESO;
        $this->validarTarifa = false;
        $this->esProveedor = true;
    }

    public function index() {
        include_once 'view/gastos/comprobante/view/view.php';
    }

    public function create() {
        $factura = new Factura();
        $apertura_cajaFacade = new Apertura_cajaFacade();
       
        $apertura_caja = $apertura_cajaFacade->getCajaAbiertaUsuario();
        
        $factura->fechaGeneracion = $apertura_caja->fecha_apertura;
        
        include_once 'view/gastos/comprobante/edit/create.php';
    }

    public function edit($request) {

        $facturaFacade = new FacturaFacade();
        $apertura_cajaFacade = new Apertura_cajaFacade();
       
        $apertura_caja = $apertura_cajaFacade->getCajaAbiertaUsuario();        

        $factura = $facturaFacade->findById($request->id);
        
        $factura->fechaGeneracion = $apertura_caja->fecha_apertura;

        include_once 'view/gastos/comprobante/edit/create.php';
    }
    
    public function getComprobantes($request){        
       $facturaFacade = new FacturaFacade();
       $entities = $facturaFacade->setParams(array('filters' => array('and tipo_factura_id = ' . FacturaFacade::$TIPO_COMPROBANTE_EGRESO), 
                                                    'orderBy' => 'id asc','likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
   
    

    
}
