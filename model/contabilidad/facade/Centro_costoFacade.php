<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Centro_costoFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/contabilidad/entity/Centro_costo.php';

class Centro_costoFacade extends AbstractFacade{

   function Centro_costoFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'centro_costo';
       $this->idcolum = 'id';
   }

}

