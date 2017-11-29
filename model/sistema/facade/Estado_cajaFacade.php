<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Estado_cajaFacade
*
* @author chory
* @date 2017-10-31 08:10:51
*/
include_once('model/AbstractFacade.php');
require_once 'model/sistema/entity/Estado_caja.php';

class Estado_cajaFacade extends AbstractFacade{

   function Estado_cajaFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'estado_caja';
       $this->idcolum = 'id';
   }

}

