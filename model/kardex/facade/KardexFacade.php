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

    public static $ESTADOACTIVO = 1;
    public static $ESTADOINACTIVO = 2;
    public static $ENTRADA = 1;
    public static $SALIDA = 2;
    
    public static $INACTIVARKARDEX = "inactivarkardex";
    public static $CREARKARDEXFACTURA = "crearkardexfactura";
    
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
        
        $querys[self::$CREARKARDEXFACTURA] = "insert into kardex (sucursal_id, factura_id, tarifa_id, fecha, cantidad, costo_unitario, tipo_movimiento_kardex_id)
                        SELECT :sucursalId, factura_id, tarifa_id, '" . date('Y-m-d') . "', cantidad, 0, :tipo_movimiento_kardex FROM factura_producto a where a.a_estado_id = 1 and a.factura_id = :facturaId";
        
        $querys[FacturaFacade::$DATOSCAJA] = FacturaFacade::getNamedQuery(FacturaFacade::$DATOSCAJA);
        
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
    
    public function crearKardex($factura){
        
        $tipoMovimientoKardex = self::$SALIDA;
        
        if($factura->tipo_factura_id == FacturaFacade::$TIPO_NOTA){
            $tipoMovimientoKardex = self::$ENTRADA;            
        }
        
        $usuario = $_SESSION['login'];
        
        $datosCaja = $this->runNamedQueryArray(FacturaFacade::$DATOSCAJA, array(), array('usuario' => $usuario, 'tipo_factura_id' => 1));
        
        $sucursalId = $datosCaja[0]['sucursal_id'];
        
        $this->runSimpleNamedQuery(self::$CREARKARDEXFACTURA, array(), array('tipo_movimiento_kardex' => $tipoMovimientoKardex, 'sucursalId' => $sucursalId,'facturaId' => $factura->id));
        
        return true;
        
    }

}

