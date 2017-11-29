<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of CompaniaFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/contabilidad/entity/Compania.php';

class CompaniaFacade extends AbstractFacade{

   function CompaniaFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'compania';
       $this->idcolum = 'id';
   }

}

