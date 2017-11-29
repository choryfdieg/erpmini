<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Forma_pagoFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/ingresos/entity/Forma_pago.php';

class Forma_pagoFacade extends AbstractFacade{

   function Forma_pagoFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'forma_pago';
       $this->idcolum = 'id';
   }

}

