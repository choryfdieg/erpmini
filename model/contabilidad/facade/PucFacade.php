<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of PucFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/contabilidad/entity/Puc.php';

class PucFacade extends AbstractFacade{

   function PucFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'puc';
       $this->idcolum = 'id';
   }

}

