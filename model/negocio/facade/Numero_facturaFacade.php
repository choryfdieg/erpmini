<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Numero_facturaFacade
*
* @author chory
* @date 2017-10-26 17:10:39
*/
include_once('model/AbstractFacade.php');
require_once 'model/negocio/entity/Numero_factura.php';

class Numero_facturaFacade extends AbstractFacade{

   function Numero_facturaFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'numero_factura';
       $this->idcolum = 'id';
   }

}

