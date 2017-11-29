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

class FacturaFacade extends AbstractFacade{

    public static $TIPO_FACTURA = 1;
    public static $TIPO_NOTA = 2;
    public static $ESTADOACTIVO = 1;
    
    function FacturaFacade() {
        $this->motor = AbstractFacade::$MYSQL;
        $this->schema = 'erpmini';
        $this->entidad = 'factura';
        $this->idcolum = 'id';
    }

}

