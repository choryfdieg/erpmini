<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of ImpuestoFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/negocio/entity/Impuesto.php';

class ImpuestoFacade extends AbstractFacade{

   function ImpuestoFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'impuesto';
       $this->idcolum = 'id';
   }

}

