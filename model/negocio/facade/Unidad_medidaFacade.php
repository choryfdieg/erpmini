<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Unidad_medidaFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/negocio/entity/Unidad_medida.php';

class Unidad_medidaFacade extends AbstractFacade{

    public static $LISTAUNIDADESDEMEDIDA = "listaunidadesdemedida";
    
   function Unidad_medidaFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'unidad_medida';
       $this->idcolum = 'id';
   }
   
   public function getNamedQuery($namequery){
        // ***
        $querys = array();
        
        $querys[self::$LISTAUNIDADESDEMEDIDA] = "SELECT a.id, b.nombre, a.simbolo, a.descripcion FROM erpmini.unidad_medida a left join erpmini.grupo_unidad_medida b on b.id = a.grupo_unidad_medida_id where 1 = 1";
        
        return $querys[$namequery];
    }

    function getLstaUnidadesDeMedida(){       
       
        $result = $this->runNamedQueryArray(self::$LISTAUNIDADESDEMEDIDA);
        
        return $result;
       
    }

}

