<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of TerceroFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/crm/entity/Tercero.php';

class TerceroFacade extends AbstractFacade{

   function TerceroFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'tercero';
       $this->idcolum = 'id';
   }

}

