<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Tipo_facturaFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/sistema/entity/Tipo_factura.php';

class Tipo_facturaFacade extends AbstractFacade{

   function Tipo_facturaFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'tipo_factura';
       $this->idcolum = 'id';
   }

}

