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
require_once 'model/crm/facade/TerceroFacade.php';
require_once 'model/kardex/facade/KardexFacade.php';
require_once 'model/ingresos/facade/Factura_productoFacade.php';
require_once 'model/ingresos/facade/Factura_forma_pagoFacade.php';
require_once 'model/ingresos/facade/Forma_pagoFacade.php';
require_once 'model/negocio/facade/ProductoFacade.php';
require_once 'model/negocio/facade/TarifaFacade.php';
require_once 'model/ingresos/entity/Factura_producto.php';
require_once 'model/ingresos/entity/Factura.php';
require_once 'model/negocio/facade/Apertura_cajaFacade.php';

class FacturaCommonControl {
    
    public $tipo_factura_id;
    public $validarTarifa = true;
    public $esProveedor = false;
    
    function __construct() {
    }
    
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
    
    public function putDescartarFactura($request){
        
        $facturaId = $request->factura_id;
        
        $facturaFacade = new FacturaFacade();
        
        $facturaFacade->descartarFactura($facturaId);
        
        echo json_encode(array('id' => $facturaId));
        
    }
    
    public function getFormasDePago() {

        $forma_pagoFacade = new Forma_pagoFacade();

        $formasDePago = $forma_pagoFacade->setParams(array('select' => array('id', 'nombre')))->findEntities();

        echo json_encode($formasDePago);
    }

    public function getFacturaFormasDePago($request) {

        $facturaFormasDePago = array();

        if ($request->factura_id > 0) {
            $factura_forma_pagoFacade = new Factura_forma_pagoFacade();

            $estadoActivo = FacturaFacade::$ESTADOACTIVO;

            $facturaFormasDePago = $factura_forma_pagoFacade->setParams(array('select' => array('id', 'forma_pago_id', 'valor', 'referencia', 'voucher_tarjeta'), 'filters' => array(" and a_estado_id = {$estadoActivo} ", " and factura_id = {$request->factura_id} ")))->findEntities();
        }

        echo json_encode($facturaFormasDePago);
    } 
    
    public function postSave($request) {

        $facturaProductoRequest = $request->factura_producto;
        $facturaFormasDePagoRequest = $request->factura_forma_pago;

        $facturaFacade = new FacturaFacade();
        $apertura_cajaFacade = new Apertura_cajaFacade();
       
        $apertura_caja = $apertura_cajaFacade->getCajaAbiertaUsuario();

        $factura = new Factura();

        $factura->apertura_caja_id = $apertura_caja->id;

        $factura->tipo_factura_id = $this->tipo_factura_id;
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
        $apertura_cajaFacade = new Apertura_cajaFacade();
       
        $apertura_caja = $apertura_cajaFacade->getCajaAbiertaUsuario();
        
        $factura = $facturaFacade->findById($facturaRequest->id);

        $factura->merge($request->factura);

        $factura->apertura_caja_id = $apertura_caja->id;
        
        $facturaFacade->doEdit($factura);

        $this->saveProductos($factura->id, $facturaProductoRequest);
        $this->saveFormasDePago($factura->id, $facturaFormasDePagoRequest);

        echo json_encode(array('id' => $factura->id));
    }

    private function saveProductos($factura_id, $facturaProductos) {

        $factura_productoFacade = new Factura_productoFacade();
        $tarifaFacade = new TarifaFacade();

        $productosActivos = array();

        foreach ($facturaProductos as $facturaProductoRequest) {

            if ($facturaProductoRequest['tarifa_id'] == '') {
                continue;
            }

            $tarifa = $tarifaFacade->getDatosParaFacturaProducto($facturaProductoRequest['tarifa_id']);

            if ($facturaProductoRequest['id'] > 0) {
                $factura_producto = $factura_productoFacade->findById($facturaProductoRequest['id']);
            } else {
                $factura_producto = new Factura_producto();
            }

            // valida si se modifica la tarifa sin permiso
            if(!$this->validarTarifa){
                unset($tarifa['valor_unitario']);
            }
            
            $factura_producto->merge($facturaProductoRequest);
            $factura_producto->merge($tarifa);

            if($factura_producto->descuento == ''){
                $factura_producto->descuento = 0;
            }
            
            $factura_producto->valor_total = ($factura_producto->valor_unitario * $factura_producto->cantidad) - $factura_producto->descuento ;
            $factura_producto->factura_id = $factura_id;
            $factura_producto->a_estado_id = FacturaFacade::$ESTADOACTIVO;

            // valida si se modifica la tarifa sin permiso
            if($this->validarTarifa){
                // si las tarifas son diferentes, no guarda el registro de factura_producto
                if ($tarifa['valor_unitario'] <> $facturaProductoRequest['valor_unitario']){
                    continue;
                }            
            }

            $factura_productoFacade->doEdit($factura_producto);

            $productosActivos[] = $factura_producto->id;
        }

        $factura_productoFacade->inactivarProductosFactura($factura_id, $productosActivos);
        $factura_productoFacade->actualizarImpuestosProductosFactura($factura_id);
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
    
    public function getProductos() {
        $productoFacade = new ProductoFacade();

        $productos = $productoFacade->getProductosParaFactura($this->tipo_factura_id);

        echo json_encode($productos);
    }

    public function getFacturaProductos($request) {

        $facturaProductos = array();

        if ($request->factura_id > 0) {
            $factura_productoFacade = new Factura_productoFacade();

            $estadoActivo = FacturaFacade::$ESTADOACTIVO;

            $facturaProductos = $factura_productoFacade->setParams(array('filters' => 
                                                                    array(" and a_estado_id = {$estadoActivo} ", 
                                                                            " and factura_id = {$request->factura_id} ")))->findEntities();
        }

        echo json_encode($facturaProductos);
    }
    
    public function tercerosForSelect() {
        $terceroFacade = new TerceroFacade();
        $filters = array();
        if($this->esProveedor){
            $filters[] = " and esproveedor = 'S'";
        }
        $entities = $terceroFacade->setParams(array('select' => array('id', 'documento', 'nombre'), 'filters' => $filters))->findEntities();
        return $entities;
    }
    
}
