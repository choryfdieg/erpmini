<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Tipo_documentoFacade
*
* @author chory
*/
include_once('model/AbstractFacade.php');
require_once 'model/sistema/entity/Tipo_documento.php';

class Tipo_documentoFacade extends AbstractFacade{

   function Tipo_documentoFacade() {
       $this->motor = AbstractFacade::$MYSQL;
       $this->schema = 'erpmini';
       $this->entidad = 'tipo_documento';
       $this->idcolum = 'id';
   }

}

