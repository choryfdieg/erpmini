<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Caja_sucursalFacade
*
* @author chory
* @date 2017-10-26 17:10:06
*/
include_once('model/AbstractFacade.php');
require_once 'model/negocio/entity/Caja_sucursal.php';

class Caja_sucursalFacade extends AbstractFacade{

   function Caja_sucursalFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'caja_sucursal';
       $this->idcolum = 'id';
   }

}

