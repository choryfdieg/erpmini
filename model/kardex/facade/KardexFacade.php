<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of KardexFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/kardex/entity/Kardex.php';

class KardexFacade extends AbstractFacade{

    public static $INACTIVARKARDEX = "inactivarkardex";
    public static $ESTADOACTIVO = 1;
    public static $ESTADOINACTIVO = 2;
    public static $ENTRADA = 1;
    public static $SALIDA = 2;
    
   function KardexFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'kardex';
       $this->idcolum = 'id';
   }
   
   public function getNamedQuery($namequery){
        // ***
        $querys = array();
        
        $querys[self::$INACTIVARKARDEX] = 'update erpmini.kardex set a_estado_id = ' . self::$ESTADOINACTIVO . ' where tarifa_id = :tarifaId';
        
        return $querys[$namequery];
    }
    
    /**
     * Se le pasan por parametro los ids de los kardex activos para hacer un not in en el update
     * @param type $ids los que estan activos
     */
    function inactivarKardexProducto($tarifaId, $ids){       
       
        $filters = array();
        $params = array();
        
        $params['tarifaId'] = $tarifaId;
        
        if(!empty($ids)){
            $filters[] = ' and id not in (' . implode(',', $ids) . ')';
        }
        
        $this->runSimpleNamedQuery(self::$INACTIVARKARDEX, $filters, $params);
       
    }

}

