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
                                                    d.porcentaje_impuesto as pojo_porcentaje_impuesto,
                                                    (select sum(cantidad) from kardex k where k.sucursal_id = :sucursalId and k.tarifa_id = a.id) as pojo_existencias
                                                  FROM tarifa a
                                                  inner join producto b on b.id = a.producto_id
                                                  inner join unidad_medida c on c.id = a.unidad_medida_id
                                                  inner join impuesto d on d.id = b.impuesto_id
                                                  inner join kardex e on e.tarifa_id = a.id
                                                  where e.sucursal_id = :sucursalId";
        
        $querys[FacturaFacade::$DATOSCAJA] = FacturaFacade::getNamedQuery(FacturaFacade::$DATOSCAJA);
        
        return $querys[$namequery];
    }

    function getProductosParaFactura($tipoFacturaId = '1'){       
        
        $usuario = $_SESSION['login'];
        
        $datosCaja = $this->runNamedQueryArray(FacturaFacade::$DATOSCAJA, array(), array('usuario' => $usuario, 'tipo_factura_id' => $tipoFacturaId));
        
        // Carga por defecto los articulos de la sucursal principal si es una compra de articulos del inventario
        if($tipoFacturaId == '3'){
            $sucursalId = 1;
        }else{
            $sucursalId = $datosCaja[0]['sucursal_id'];
        }
        
        $result = $this->runNamedQueryArray(self::$PRODUCTOSPARAFACTURA, array(), array('sucursalId' => $sucursalId));
        
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

