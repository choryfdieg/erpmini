<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Grupo_unidad_medidaFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/negocio/entity/Grupo_unidad_medida.php';

class Grupo_unidad_medidaFacade extends AbstractFacade{

   function Grupo_unidad_medidaFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'grupo_unidad_medida';
       $this->idcolum = 'id';
   }

}

