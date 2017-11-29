<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of TarifaFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/negocio/entity/Tarifa.php';

class TarifaFacade extends AbstractFacade{

    public static $DATOSPARAFACTURAPRODUCTO = 'datosparafacturaproducto';
    
   function TarifaFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'tarifa';
       $this->idcolum = 'id';
   }
   
   public function getNamedQuery($namequery){
        // ***
        $querys = array();
        
        $querys[self::$DATOSPARAFACTURAPRODUCTO] = "SELECT a.valor_unitario as valor_unitario, b.nombre as producto, c.porcentaje_impuesto as porcentaje_impuesto, 
                                                        d.descripcion as unidad_medida, c.nombre as impuesto 
                                                        FROM erpmini.tarifa a 
                                                        inner join erpmini.producto b on b.id = a.producto_id
                                                        inner join erpmini.impuesto c on c.id = b.impuesto_id
                                                        inner join erpmini.unidad_medida d on d.id = a.unidad_medida_id
                                                        where a.id = :id";
        
        return $querys[$namequery];
    }

    function getDatosParaFacturaProducto($tarifaId){       
       
        $params = array('id' => $tarifaId);
        
        $result = $this->runNamedQueryArray(self::$DATOSPARAFACTURAPRODUCTO, array(), $params);
        
        return (isset($result[0]) ? $result[0] : array());
       
    }

}

