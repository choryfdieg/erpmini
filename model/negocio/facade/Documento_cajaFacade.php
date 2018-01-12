<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Documento_cajaFacade
*
* @author chory
* @date 2018-01-12 15:01:25
*/
include_once('model/AbstractFacade.php');
require_once 'model/negocio/entity/Documento_caja.php';

class Documento_cajaFacade extends AbstractFacade{

   function Documento_cajaFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'documento_caja';
       $this->idcolum = 'id';
   }

}

