<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of ProductoFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/negocio/entity/Producto.php';
require_once 'model/utilidades/Pojo.php';

class ProductoFacade extends AbstractFacade{

    public static $PRODUCTOSPARAFACTURA = "productosparafactura";
    
    function ProductoFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'producto';
       $this->idcolum = 'id';
    }
   
    public function getNamedQuery($namequery){
        // ***
        $querys = array();
        
        $querys[self::$PRODUCTOSPARAFACTURA] = "SELECT a.id as pojo_id, b.nombre as pojo_producto, 
                                                    c.descripcion as pojo_unidad_medida, a.valor_unitario as pojo_valor_unitario, 
                                                    d.nombre as pojo_impuesto,
                                                    d.porcentaje_impuesto as pojo_porcentaje_impuesto
                                                FROM tarifa a
                                                inner join producto b on b.id = a.producto_id
                                                inner join unidad_medida c on c.id = a.unidad_medida_id
                                                inner join impuesto d on d.id = b.impuesto_id";
        
        return $querys[$namequery];
    }

    function getProductosParaFactura(){       
       
        $result = $this->runNamedQueryArray(self::$PRODUCTOSPARAFACTURA);
        
        $productos = array();
        
        foreach ($result as $value) {
            $value['pojo_unidad_medida'] = utf8_encode($value['pojo_unidad_medida']);
            $value['id'] = $value['pojo_id'];
            $value['text'] = $value['pojo_producto'];
            $productos[] = new Pojo($value);
        }
       
        return $productos;
       
    }
   
}

