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
require_once 'model/crm/facade/TerceroFacade.php';
require_once 'model/ingresos/facade/FacturaFacade.php';
require_once 'model/ingresos/facade/Factura_productoFacade.php';
require_once 'model/ingresos/facade/Factura_forma_pagoFacade.php';
require_once 'model/ingresos/facade/Forma_pagoFacade.php';
require_once 'model/negocio/facade/ProductoFacade.php';
require_once 'model/negocio/facade/TarifaFacade.php';
require_once 'model/ingresos/entity/Factura_producto.php';
require_once 'model/ingresos/entity/Factura.php';

class NotaControl {

    function NotaControl() {
        
    }

    public function index() {
        include_once 'view/ingresos/nota/view.php';
    }

    public function create($request) {
        
        $facturaFacade = new FacturaFacade();
        
        $factura = $facturaFacade->findById($request->factura);
        
        // consecutivo de la nota credito
        $factura->id = '';
        // consecutivo de la factura original
        $factura->factura_id = $request->factura;
        
        include_once 'view/ingresos/nota/create.php';
    }

    public function edit($request) {

        $facturaFacade = new FacturaFacade();

        $factura = $facturaFacade->findById($request->id);

        include_once 'view/ingresos/nota/create.php';
    }

    public function getNotas($request){        
       $facturaFacade = new FacturaFacade();
       $entities = $facturaFacade->setParams(array('filters' => array('and tipo_factura_id = ' . FacturaFacade::$TIPO_NOTA), 'orderBy' => 'id asc','likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   } 
    
    public function postSave($request) {

        $facturaProductoRequest = $request->factura_producto;
        $facturaFormasDePagoRequest = $request->factura_forma_pago;

        $facturaFacade = new FacturaFacade();
        $apertura_cajaFacade = new Apertura_cajaFacade();
       
        $apertura_caja = $apertura_cajaFacade->getCajaAbiertaUsuario();

        $factura = new Factura();

        $factura->apertura_caja_id = $apertura_caja->id;
        
        $factura->tipo_factura_id = FacturaFacade::$TIPO_NOTA;
        $factura->a_estado_id = FacturaFacade::$ESTADOACTIVO;

        $factura->merge($request->factura);

        $facturaFacade->doEdit($factura);

        $this->saveProductos($factura->id, $facturaProductoRequest);
        $this->saveFormasDePago($factura->id, $facturaFormasDePagoRequest);

        echo json_encode(array('id' => $factura->id));
    }

    public function putSave($request) {

        $facturaRequest = (object) $request->factura;
        $facturaProductoRequest = (isset($request->factura_producto)) ? $request->factura_producto : array();
        $facturaFormasDePagoRequest = (isset($request->factura_forma_pago)) ? $request->factura_forma_pago : array();

        $facturaFacade = new FacturaFacade();

        $factura = $facturaFacade->findById($facturaRequest->id);

        $factura->merge($request->factura);

        $facturaFacade->doEdit($factura);

        $this->saveProductos($factura->id, $facturaProductoRequest);
        $this->saveFormasDePago($factura->id, $facturaFormasDePagoRequest);

        echo json_encode(array('id' => $factura->id));
    }

    private function saveProductos($factura_id, $facturaProductos) {
        
        $factura_productoFacade = new Factura_productoFacade();

        foreach ($facturaProductos as $facturaProductoRequest) {

            if ($facturaProductoRequest['factura_producto_id'] == '') {
                continue;
            }

            $factura_producto_original = $factura_productoFacade->findById($facturaProductoRequest['factura_producto_id']);
            // para que en el merge no lo ponga, y se genere un id nuevo
            unset($factura_producto_original->id);

            if ($facturaProductoRequest['id'] > 0) {
                $factura_producto = $factura_productoFacade->findById($facturaProductoRequest['id']);
            } else {
                $factura_producto = new Factura_producto();
            }

            $factura_producto->merge((array)$factura_producto_original);
            $factura_producto->merge($facturaProductoRequest);

            $factura_producto->descuento = 0;                        
            
            $factura_producto->valor_total = $factura_producto->valor_unitario;
            
            $factura_producto->factura_id = $factura_id;
            $factura_producto->a_estado_id = FacturaFacade::$ESTADOACTIVO;

            $factura_productoFacade->doEdit($factura_producto);

        }

        $factura_productoFacade->actualizarImpuestosProductosNotaCredito($factura_id);
    }

    private function saveFormasDePago($factura_id, $facturaFormasDePago) {

        $factura_forma_pagoFacade = new Factura_forma_pagoFacade();

        $formasDePagoActivas = array();

        foreach ($facturaFormasDePago as $facturaFormaDePagoRequest) {

            if ($facturaFormaDePagoRequest['forma_pago_id'] == '') {
                continue;
            }

            if ($facturaFormaDePagoRequest['id'] > 0) {
                $factura_forma_pago = $factura_forma_pagoFacade->findById($facturaFormaDePagoRequest['id']);
            } else {
                $factura_forma_pago = new Factura_forma_pago();
            }

            $factura_forma_pago->merge($facturaFormaDePagoRequest);

            $factura_forma_pago->factura_id = $factura_id;
            $factura_forma_pago->a_estado_id = FacturaFacade::$ESTADOACTIVO;

            $factura_forma_pagoFacade->doEdit($factura_forma_pago);

            $formasDePagoActivas[] = $factura_forma_pago->id;
        }

        $factura_forma_pagoFacade->inactivarFormasDePagoFactura($factura_id, $formasDePagoActivas);
    }

    private function tercerosForSelect() {
        $terceroFacade = new TerceroFacade();
        $entities = $terceroFacade->setParams(array('select' => array('id', 'documento', 'nombre')))->findEntities();
        return $entities;
    }

    public function getFacturaProductos($request) {

        $factura_productoFacade = new Factura_productoFacade();

        $facturaProductos = $factura_productoFacade->getFacturaProductosParaNotaCredito($request->factura_original_id, $request->factura_id);        

        echo json_encode($facturaProductos);
    }

    public function getFormasDePago() {

        $forma_pagoFacade = new Forma_pagoFacade();

        $formasDePago = $forma_pagoFacade->setParams(array('select' => array('id', 'nombre')))->findEntities();

        echo json_encode($formasDePago);
    }

    public function getFacturaFormasDePago($request) {

        $facturaFormasDePago = array();

        $select = array();
        
        if($request->factura_id > 0){
            $select = array('id', 'forma_pago_id', 'valor', 'referencia', 'voucher_tarjeta');
        }else{
            $select = array("'' as id", 'forma_pago_id', 'valor', 'referencia', 'voucher_tarjeta');
            $request->factura_id = $request->factura_original_id;            
        }
        
        if ($request->factura_id > 0) {
            $factura_forma_pagoFacade = new Factura_forma_pagoFacade();

            $estadoActivo = FacturaFacade::$ESTADOACTIVO;

            $facturaFormasDePago = $factura_forma_pagoFacade->setParams(array('select' => $select, 'filters' => array(" and a_estado_id = {$estadoActivo} ", " and factura_id = {$request->factura_id} ")))->findEntities();
        }

        echo json_encode($facturaFormasDePago);
    }

}
