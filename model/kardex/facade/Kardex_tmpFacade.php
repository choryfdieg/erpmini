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
require_once 'model/kardex/entity/Kardex_tmp.php';

class Kardex_tmpFacade extends AbstractFacade {

    public static $ENTRADA = 1;
    public static $SALIDA = 2;
    
    public static $CREARKARDEXTEMPORAL = 'crearkardextemporal';
    public static $BORRARKARDEXTEMPORAL = 'borrarkardextemporal';

    function Kardex_tmpFacade() {
        $this->motor = AbstractFacade::$MYSQL;
        $this->schema = 'erpmini';
        $this->entidad = 'kardex_tmp';
        $this->idcolum = 'id';
    }

    public function getNamedQuery($namequery) {
        // ***
        $querys = array();

        $querys[self::$CREARKARDEXTEMPORAL] = "insert into kardex_tmp (sucursal_id, factura_id, tarifa_id, cantidad, tipo_movimiento_kardex_id)
                        SELECT :sucursalId, factura_id, tarifa_id, cantidad, " . self::$ENTRADA . " FROM factura_producto a where a.a_estado_id = 1 and a.factura_id = :facturaId";
        
        $querys[self::$BORRARKARDEXTEMPORAL] = "delete FROM kardex_tmp where factura_id = :facturaId";
        
        $querys[FacturaFacade::$DATOSCAJA] = FacturaFacade::getNamedQuery(FacturaFacade::$DATOSCAJA);

        return $querys[$namequery];
    }
    
    // TODO: metodos quedan pendientes para analisis
    public function crearKardexTemporal($facturaId){
        
        $this->runSimpleNamedQuery(self::$BORRARKARDEXTEMPORAL, array(), array('facturaId' => $facturaId));
        
        $usuario = $_SESSION['login'];
        
        $datosCaja = $this->runNamedQueryArray(FacturaFacade::$DATOSCAJA, array(), array('usuario' => $usuario));
        
        $sucursalId = $datosCaja[0]['sucursal_id'];
        
        $this->runSimpleNamedQuery(self::$CREARKARDEXTEMPORAL, array(), array('sucursalId' => $sucursalId,'facturaId' => $facturaId));
        
    }
    
    // TODO: metodos quedan pendientes para analisis
    public function borrarKardexTemporal($facturaId){
        
        $this->runSimpleNamedQuery(self::$BORRARKARDEXTEMPORAL, array(), array('facturaId' => $facturaId));
        
    }

}
