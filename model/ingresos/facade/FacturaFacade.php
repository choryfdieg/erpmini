<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of FacturaFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/ingresos/entity/Factura.php';
require_once 'model/ingresos/facade/FacturaPDF.php';

class FacturaFacade extends AbstractFacade{

    public static $TIPO_FACTURA = 1;
    public static $TIPO_NOTA = 2;
    public static $ESTADOACTIVO = 1;
    
    public static $DATOSCAJA = "datoscaja";
    public static $ACTUALIZARCONSECUTIVOCAJA = "actualizarconsecutivocaja";
    public static $ACTUALIZARNUMERODOCUMENTOFACTURA = "actualizarnumerodocumentofactura";
    public static $PRODUCTOSFACTURAIMPRESION = "productosfacturaimpresion";
    
    function FacturaFacade() {
        $this->motor = AbstractFacade::$MYSQL;
        $this->schema = 'erpmini';
        $this->entidad = 'factura';
        $this->idcolum = 'id';
    }
    
    public function getNamedQuery($namequery){
        
        $querys = array();
        
        $querys[self::$DATOSCAJA] = "SELECT b.id, b.prefijo, b.numero_actual FROM apertura_caja a
                                        inner join caja_sucursal b on a.caja_sucursal_id = b.id
                                        where a.estado_caja_id = 1 and a.a_usuario = ':usuario'";
        
        $querys[self::$ACTUALIZARCONSECUTIVOCAJA] = "update caja_sucursal set numero_actual = numero_actual + 1 where id = :id";
        
        $querys[self::$ACTUALIZARNUMERODOCUMENTOFACTURA] = "update factura set prefijo = ':prefijo', numero = :numero where id = :id";
        
        $querys[self::$PRODUCTOSFACTURAIMPRESION] = "SELECT b.producto, b.unidad_medida, b.impuesto, b.cantidad, b.valor_unitario, coalesce(b.descuento,0) as descuento, b.valor_total, b.valor_impuesto FROM factura a
                                                        inner join factura_producto b on a.id = b.factura_id
                                                        where b.a_estado_id = 1
                                                        and a.id = :facturaId";
        
        return $querys[$namequery];
    }

    public function actualizarNumeracionFactura($facturaId){
        
        $usuario = $_SESSION['login'];
        
        // seleccion de los datos de la caja abierta
        $datosCaja = $this->runNamedQueryArray(self::$DATOSCAJA, array(), array('usuario' => $usuario));
        
        if(empty($datosCaja)){
            return false;
        }
        
        $cajaSucursalId = $datosCaja[0]['id'];
        $prefijo = $datosCaja[0]['prefijo'];
        // Se le suma 1 al numero actual de la caja
        $numeroSiguiente = ((int)$datosCaja[0]['numero_actual']) + 1;
        
        // se actualiza el nuevo numero de consecutivo de la caja
        $this->runSimpleNamedQuery(self::$ACTUALIZARCONSECUTIVOCAJA, array(), array('id' => $cajaSucursalId));
        // se actualiza el prefijo y numero de caja
        $this->runSimpleNamedQuery(self::$ACTUALIZARNUMERODOCUMENTOFACTURA, array(), array('id' => $facturaId, 'prefijo' => $prefijo, 'numero' => $numeroSiguiente));
                                  
        return true;
    }    
    
    public function imprimirFactura($facturaId){
        
        ob_get_clean();
        
        $facturaProductos = $this->runNamedQueryArray(self::$PRODUCTOSFACTURAIMPRESION, array(), array('facturaId' => $facturaId));
        
        $facturaPdf = new FacturaPDF('12');
        
        $facturaPdf->facturaProductos = $facturaProductos;
        
        return $facturaPdf->generar();
    }
}

