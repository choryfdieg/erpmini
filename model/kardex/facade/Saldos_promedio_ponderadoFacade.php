<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Saldos_promedio_ponderadoFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/kardex/entity/Saldos_promedio_ponderado.php';

class Saldos_promedio_ponderadoFacade extends AbstractFacade{

   function Saldos_promedio_ponderadoFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'saldos_promedio_ponderado';
       $this->idcolum = 'id';
   }

}

