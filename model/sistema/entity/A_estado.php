<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of A_estado
*
* @author chory
* @date 2018-01-10 09:01:52
*/
require_once 'model/Entity.php';


class A_estado extends Entity{

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
   public $tabla;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $descripcion_corta;

   /**
   *
   * @type varchar(2000)
   * @length (2000)
   */
   public $descripcion_larga;



   function A_estado($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setTabla($tabla){
      $this->tabla = $tabla;
   }

   public function getTabla(){
       return $this->tabla;
   }


   public function setDescripcion_corta($descripcion_corta){
      $this->descripcion_corta = $descripcion_corta;
   }

   public function getDescripcion_corta(){
       return $this->descripcion_corta;
   }


   public function setDescripcion_larga($descripcion_larga){
      $this->descripcion_larga = $descripcion_larga;
   }

   public function getDescripcion_larga(){
       return $this->descripcion_larga;
   }


}

