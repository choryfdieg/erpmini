<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Factura_productoFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/ingresos/entity/Factura_producto.php';

class Factura_productoFacade extends AbstractFacade{

    public static $INACTIVARPRODUCTOS = "inactivarproductos";
    public static $ACTUALIZARIMPUESTOPRODUCTOS = "actualizarimpuestoproductos";
    public static $ACTUALIZARIMPUESTOPRODUCTOSNOTACREDITO = "actualizarimpuestoproductosnotacredito";
    public static $NOTACREDITOPRODUCTOS = "notacreditoproductos";
    public static $INFOPRODUCTOIMPUESTO = "infoproductoimpuesto";
    public static $ESTADOACTIVO = 1;
    public static $ESTADOINACTIVO = 2;
    
    function Factura_productoFacade() {
        $this->motor = AbstractFacade::$MYSQL;
        $this->schema = 'erpmini';
        $this->entidad = 'factura_producto';
        $this->idcolum = 'id';
    }
    
    public function getNamedQuery($namequery){
        // ***
        $querys = array();
        
        $querys[self::$INACTIVARPRODUCTOS] = 'update erpmini.factura_producto set a_estado_id = ' . self::$ESTADOINACTIVO . ' where factura_id = :facturaId';
        $querys[self::$ACTUALIZARIMPUESTOPRODUCTOS] = 'update erpmini.factura_producto set valor_impuesto = round((valor_unitario * porcentaje_impuesto)/(100 + porcentaje_impuesto)) * cantidad where factura_id = :facturaId';
        $querys[self::$ACTUALIZARIMPUESTOPRODUCTOSNOTACREDITO] = 'update erpmini.factura_producto set cantidad = :cantidad, valor_impuesto = :impuesto where factura_id = :facturaId and id = :id';
        $querys[self::$NOTACREDITOPRODUCTOS] = 'SELECT 
                                                    a.id as nota_id, a.valor_unitario as nota_valor_unitario, a.factura_producto_id, 
                                                    a.producto, a.unidad_medida, a.impuesto, a.porcentaje_impuesto,
                                                    b.cantidad, b.valor_unitario, coalesce(b.descuento,0) as descuento, b.valor_total, b.valor_impuesto,
                                                    a.cantidad_devolucion
                                                    FROM factura_producto a
                                                    left join factura_producto b on b.id = a.factura_producto_id
                                                    where a.factura_id = :notaId';
        $querys[self::$INFOPRODUCTOIMPUESTO] = 'SELECT a.id as nota_producto_id, a.valor_total as nota_valor_total, 
                                                    (case when a.valor_total = b.valor_total then a.cantidad else 1 end) as cantidad,
                                                    (case when a.valor_total = b.valor_total then b.valor_impuesto else -1 end) as impuesto, 
                                                    b.cantidad as factura_cantidad, b.valor_unitario as factura_valor_unitario, 
                                                    b.porcentaje_impuesto as factura_porcentaje_impuesto, coalesce(b.descuento,0) as factura_descuento
                                                FROM erpmini.factura_producto a
                                                inner join erpmini.factura_producto b on a.factura_producto_id = b.id
                                                where a.factura_id = :facturaId';
        
        return $querys[$namequery];
    }

    /**
     * Se le pasan por parametro los ids de los procuto_factura activos para hacer un not in en el update
     * @param type $ids los que estan activos
     */
    function inactivarProductosFactura($facturaId, $ids){       
       
        $filters = array();
        $params = array();
        
        $params['facturaId'] = $facturaId;
        
        if(!empty($ids)){
            $filters[] = ' and id not in (' . implode(',', $ids) . ')';
        }
        
        $this->runSimpleNamedQuery(self::$INACTIVARPRODUCTOS, $filters, $params);
       
    }
    
    function actualizarImpuestosProductosFactura($facturaId){
        
        $filters = array();
        $params = array();
        
        $params['facturaId'] = $facturaId;

        $this->runSimpleNamedQuery(self::$ACTUALIZARIMPUESTOPRODUCTOS, $filters, $params);
    }
    
    function actualizarImpuestosProductosNotaCredito($facturaId){
        
        $notaProductos = $this->runNamedQueryArray(self::$INFOPRODUCTOIMPUESTO, array(), array('facturaId' => $facturaId));
        
        foreach ($notaProductos as $item) {
            
            $impuesto = $item['impuesto'];
            
            if($impuesto < 0){
                
                $porcentajeParticipacion = ($item['nota_valor_total'] * $item['factura_descuento']) / ($item['factura_valor_unitario'] * $item['factura_cantidad']);
                
                $valorCalculo = $item['nota_valor_total'] + $porcentajeParticipacion;
                
                $impuesto = round(($valorCalculo * $item['factura_porcentaje_impuesto'])/(100 + $item['factura_porcentaje_impuesto']));
                
            }
            
            $params = array();
            $params['facturaId'] = $facturaId;
            $params['id'] = $item['nota_producto_id'];
            $params['impuesto'] = $impuesto;
            $params['cantidad'] = $item['cantidad'];
            
            $this->runSimpleNamedQuery(self::$ACTUALIZARIMPUESTOPRODUCTOSNOTACREDITO, array(), $params);
            
        }
        
    }
    
    function getFacturaProductosParaNotaCredito($idFactura, $idNotaCredito){
        
        $facturaProductos = array();
         
        if($idNotaCredito > 0){
           $facturaProductos = $this->getNotaCreditoProductosEditar($idNotaCredito);
        }else{            
            $facturaProductos = $this->getNotaCreditoproductosNueva($idFactura);
        }
        
                                                                        
        return $facturaProductos;        
    }
    
    private function getNotaCreditoproductosNueva($idFactura){
        
        $select = array('id as factura_producto_id', 'cantidad', 'valor_unitario', 'coalesce(descuento,0) as descuento', 'valor_total', 'producto', 
                    'unidad_medida', 'impuesto', 'porcentaje_impuesto' ,'valor_impuesto');

        $estadoActivo = self::$ESTADOACTIVO;

        $facturaProductos = $this->setParams(array('likeArray' => true, 'select' => $select,'filters' => 
                                                                    array(" and a_estado_id = {$estadoActivo} ", 
                                                                            " and factura_id = {$idFactura} ")))->findEntities();
               
        $productosNotaCredito = array();                                                                            
                                  
        foreach ($facturaProductos as $item) {
            $productosNotaCredito[] = array('nota_producto' => array('id' => '', 'valor_unitario' => 0, 'cantidad_devolucion' => 0), 
                                    'factura_producto' => $item);
        }
                                                                            
        return $productosNotaCredito;
    }
    
    private function getNotaCreditoProductosEditar($idNotaCredito){
        
        $estadoActivo = self::$ESTADOACTIVO;
        
        $filters = array(" and a.a_estado_id = {$estadoActivo} ");
        
        $params = array('notaId' => $idNotaCredito);
        
        $facturaProductos = $this->runNamedQueryArray(self::$NOTACREDITOPRODUCTOS, $filters, $params);
        
        $productosNotaCredito = array();                                                                            
                                  
        foreach ($facturaProductos as $item) {
            $productosNotaCredito[] = array('nota_producto' => array('id' => $item['nota_id'], 'valor_unitario' => $item['nota_valor_unitario'], 
                                                                        'cantidad_devolucion' => $item['cantidad_devolucion']), 
                                    'factura_producto' => $item);
        }
                                                                            
        return $productosNotaCredito;
    }

}

