<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of FacturaControl
 *
 * @author chory
 */
require_once 'control/ingresos/FacturaCommonControl.php';

class FacturaControl extends FacturaCommonControl{

    function FacturaControl() {
        $this->tipo_factura_id = FacturaFacade::$TIPO_FACTURA;
    }

    public function index() {
        include_once 'view/ingresos/factura/view/view.php';
    }

    public function create() {
        $factura = new Factura();
        $apertura_cajaFacade = new Apertura_cajaFacade();
       
        $apertura_caja = $apertura_cajaFacade->getCajaAbiertaUsuario();
        
        $factura->fechaGeneracion = $apertura_caja->fecha_apertura;
        
        include_once 'view/ingresos/factura/edit/create.php';
    }

    public function edit($request) {

        $facturaFacade = new FacturaFacade();
        $apertura_cajaFacade = new Apertura_cajaFacade();
       
        $apertura_caja = $apertura_cajaFacade->getCajaAbiertaUsuario();        

        $factura = $facturaFacade->findById($request->id);
        
        $factura->fechaGeneracion = $apertura_caja->fecha_apertura;

        include_once 'view/ingresos/factura/edit/create.php';
    }
    
    public function getFacturas($request){        
       $facturaFacade = new FacturaFacade();
       $entities = $facturaFacade->setParams(array('filters' => array('and tipo_factura_id = ' . FacturaFacade::$TIPO_FACTURA), 
                                                    'orderBy' => 'id asc','likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }

    public function getExistenciasProducto($request){        
        
        $kardexFacade = new KardexFacade();
        $facturaFacade = new FacturaFacade();
        
        $datosCaja = $facturaFacade->getDatosCaja();
        
        $sucursalId = $datosCaja['sucursal_id'];
        
        
        $result = $kardexFacade->setParams(array('likeArray' => true, 'singleResult' => true, 'select' => array('sum(cantidad) as cantidad'), 
                                        'filters' => array(" and sucursal_id = $sucursalId", 
                                                            " and tarifa_id = $request->tarifaId")))->findEntities();
        
        $existencias = $result[0]['cantidad'];
        
        echo json_encode(array('existencias' => $existencias));       
   }

}
