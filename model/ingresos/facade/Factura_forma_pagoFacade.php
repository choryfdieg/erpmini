<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Factura_forma_pagoFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/ingresos/entity/Factura_forma_pago.php';

class Factura_forma_pagoFacade extends AbstractFacade{

    public static $INACTIVARFORMASDEPAGO = "inactivarformasdepago";
    public static $ESTADOACTIVO = 1;
    public static $ESTADOINACTIVO = 2;
    
   function Factura_forma_pagoFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'factura_forma_pago';
       $this->idcolum = 'id';
   }
   
   public function getNamedQuery($namequery){
        // ***
        $querys = array();
        
        $querys[self::$INACTIVARFORMASDEPAGO] = 'update erpmini.factura_forma_pago set a_estado_id = ' . self::$ESTADOINACTIVO . ' where factura_id = :facturaId';
        
        return $querys[$namequery];
    }
   
   /**
     * Se le pasan por parametro los ids de las factura_forma_pago activas para hacer un not in en el update
     * @param type $ids los que estan activos
     */
    function inactivarFormasDePagoFactura($facturaId, $ids){       
       
        $filters = array();
        $params = array();
        
        $params['facturaId'] = $facturaId;
        
        if(!empty($ids)){
            $filters[] = ' and id not in (' . implode(',', $ids) . ')';
        }
        
        $this->runSimpleNamedQuery(self::$INACTIVARFORMASDEPAGO, $filters, $params);
       
    }

}

