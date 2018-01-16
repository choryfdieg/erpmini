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
    public static $TIPO_COMPROBANTE_EGRESO = 3;
    public static $ESTADOACTIVO = 1;
    public static $ESTADOINACTIVO = 2;
    
    public static $DATOSCAJA = "datoscaja";
    public static $ACTUALIZARCONSECUTIVOCAJA = "actualizarconsecutivocaja";
    public static $ACTUALIZARNUMERODOCUMENTOFACTURA = "actualizarnumerodocumentofactura";
    public static $PRODUCTOSFACTURAIMPRESION = "productosfacturaimpresion";
    public static $FORMASPAGOFACTURAIMPRESION = "formaspagofacturaimpresion";
    public static $INFOFACTURAIMPRESION = "infofacturaimpresion";
    public static $INACTIVARFACTURA = "inactivarfactura";
    public static $INACTIVARFACTURAPRODUCTO = "inactivarfacturaproducto";
    public static $INACTIVARFACTURAFORMAPAGO = "inactivarfacturaformapago";
    
    function FacturaFacade() {
        $this->motor = AbstractFacade::$MYSQL;
        $this->schema = 'erpmini';
        $this->entidad = 'factura';
        $this->idcolum = 'id';
    }
    
    public static function getNamedQuery($namequery){
        
        $querys = array();
        
        $querys[self::$DATOSCAJA] = "SELECT b.id, d.prefijo, d.numero_actual, b.sucursal_id FROM apertura_caja a
                                        inner join caja_sucursal b on a.caja_sucursal_id = b.id
                                        inner join a_usuario c on c.id = a.a_usuario_id
                                        inner join documento_caja d on b.id = d.caja_sucursal_id 
                                        where a.estado_caja_id = 1 and c.user = ':usuario' and d.tipo_factura_id = :tipo_factura_id";
        
        $querys[self::$ACTUALIZARCONSECUTIVOCAJA] = "update documento_caja set numero_actual = numero_actual + 1 where caja_sucursal_id = :caja_sucursal_id
                                                        and tipo_factura_id = :tipo_factura_id and a_estado_id = 1";
        
        $querys[self::$ACTUALIZARNUMERODOCUMENTOFACTURA] = "update factura set prefijo = ':prefijo', numero = :numero where id = :id";
        
        $querys[self::$PRODUCTOSFACTURAIMPRESION] = "SELECT b.producto, b.unidad_medida, b.impuesto, b.cantidad, b.valor_unitario, coalesce(b.descuento,0) as descuento, b.valor_total, b.valor_impuesto FROM factura a
                                                        inner join factura_producto b on a.id = b.factura_id
                                                        where b.a_estado_id = 1
                                                        and a.id = :facturaId";
        
        $querys[self::$FORMASPAGOFACTURAIMPRESION] = "SELECT c.nombre, sum(b.valor) as valor FROM factura a
                                                        inner join factura_forma_pago b on a.id = b.factura_id
                                                        inner join forma_pago c on c.id = b.forma_pago_id
                                                        where b.a_estado_id = 1
                                                        and a.id = :facturaId
                                                        group by c.nombre order by c.nombre desc";
        
        $querys[self::$INFOFACTURAIMPRESION] = "SELECT a.tipo_factura_id, date(d.fecha_apertura) as fecha_apertura, a.prefijo, a.numero, 
                                                        a.observacion, c.sigla, b.documento, b.nombre, f.nombre as cajero, 
                                                        g.texto_numeracion, g.texto_resolucion 
                                                    FROM factura a
                                                    inner join tercero b on a.tercero_id = b.id
                                                    inner join tipo_documento c on c.id = b.tipo_documento_id
                                                    inner join apertura_caja d on d.id = a.apertura_caja_id
                                                    inner join caja_sucursal e on e.id = d.caja_sucursal_id
                                                    inner join a_usuario f on f.id = d.a_usuario_id
                                                    inner join documento_caja g on g.caja_sucursal_id = e.id
                                                    where a.id = :facturaId";
        
        $querys[self::$INACTIVARFACTURA] = "update factura set a_estado_id = " . self::$ESTADOINACTIVO . " where id = :facturaId";
        $querys[self::$INACTIVARFACTURAPRODUCTO] = "update factura_producto set a_estado_id = " . self::$ESTADOINACTIVO . " where factura_id = :facturaId";
        $querys[self::$INACTIVARFACTURAFORMAPAGO] = "update factura_forma_pago set a_estado_id = " . self::$ESTADOINACTIVO . " where factura_id = :facturaId";
        
        return $querys[$namequery];
    }
    
    public function getDatosCaja(){
        
        $usuario = $_SESSION['login'];
        
        // seleccion de los datos de la caja abierta
        $result = $this->runNamedQueryArray(self::$DATOSCAJA, array(), array('usuario' => $usuario, 'tipo_factura_id' => 1));
        
        $datosCaja = array();
        
        if(!empty($result)){
            $datosCaja = $result[0];
        }
            
        return $datosCaja;
        
    }

    public function actualizarNumeracionFactura($factura){
        
        $usuario = $_SESSION['login'];
        
        // seleccion de los datos de la caja abierta
        $datosCaja = $this->runNamedQueryArray(self::$DATOSCAJA, array(), array('usuario' => $usuario, 'tipo_factura_id' => $factura->tipo_factura_id));
        
        if(empty($datosCaja)){
            return false;
        }
        
        $cajaSucursalId = $datosCaja[0]['id'];
        $prefijo = $datosCaja[0]['prefijo'];
        // Se le suma 1 al numero actual de la caja
        $numeroSiguiente = ((int)$datosCaja[0]['numero_actual']) + 1;
        
        // se actualiza el nuevo numero de consecutivo de la caja
        $this->runSimpleNamedQuery(self::$ACTUALIZARCONSECUTIVOCAJA, array(), array('caja_sucursal_id' => $cajaSucursalId, 'tipo_factura_id' => $factura->tipo_factura_id));
        // se actualiza el prefijo y numero de caja
        $this->runSimpleNamedQuery(self::$ACTUALIZARNUMERODOCUMENTOFACTURA, array(), array('id' => $factura->id, 'prefijo' => $prefijo, 'numero' => $numeroSiguiente));
                                  
        return true;
    }    
    
    public function imprimirFactura($factura){
        
        ob_get_clean();
        
        $facturaCabecera = $this->runNamedQueryArray(self::$INFOFACTURAIMPRESION, array(), array('facturaId' => $factura->id));
        $facturaProductos = $this->runNamedQueryArray(self::$PRODUCTOSFACTURAIMPRESION, array(), array('facturaId' => $factura->id));
        $facturaFormasPago = $this->runNamedQueryArray(self::$FORMASPAGOFACTURAIMPRESION, array(), array('facturaId' => $factura->id));
        
        $facturaPdf = new FacturaPDF('12');
        
        $facturaPdf->facturaCabecera = $facturaCabecera[0];
        $facturaPdf->facturaProductos = $facturaProductos;
        $facturaPdf->facturaFormasPago = $facturaFormasPago;
        
        return $facturaPdf->generar();
    }
    
    public function descartarFactura($facturaId){
        $this->runSimpleNamedQuery(self::$INACTIVARFACTURA, array(), array('facturaId' => $facturaId));
        $this->runSimpleNamedQuery(self::$INACTIVARFACTURAPRODUCTO, array(), array('facturaId' => $facturaId));
        $this->runSimpleNamedQuery(self::$INACTIVARFACTURAFORMAPAGO, array(), array('facturaId' => $facturaId));
        return true;
    }
}

