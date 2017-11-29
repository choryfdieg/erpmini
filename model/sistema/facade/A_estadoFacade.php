<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of A_estadoFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/sistema/entity/A_estado.php';

class A_estadoFacade extends AbstractFacade{

   function A_estadoFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'a_estado';
       $this->idcolum = 'id';
   }

}

