<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Clasificador_ficha_tecnica
*
* @author chory
* @date 2018-01-10 09:01:52
*/
require_once 'model/Entity.php';


class Clasificador_ficha_tecnica extends Entity{

   /**
   *
   * @id id
   * @autoincrement true
   * @type int(11)
   * @length (11)
   */
   public $id;

   /**
   *
   * @type varchar(100)
   * @length (100)
   */
   public $nombre;



   function Clasificador_ficha_tecnica($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setNombre($nombre){
      $this->nombre = $nombre;
   }

   public function getNombre(){
       return $this->nombre;
   }


}

