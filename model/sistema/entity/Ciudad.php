<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Ciudad
*
* @author chory
* @date 2018-01-10 09:01:52
*/
require_once 'model/Entity.php';


class Ciudad extends Entity{

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
   * @type int(11)
   * @length (11)
   */
   public $region_id;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $sigla;

   /**
   *
   * @type varchar(100)
   * @length (100)
   */
   public $descripcion;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $a_usuario_id;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $a_ip;

   /**
   *
   * @type datetime
   * @length 
   */
   public $a_fecha;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $a_estado_id;



   function Ciudad($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setRegion_id($region_id){
      $this->region_id = $region_id;
   }

   public function getRegion_id(){
       return $this->region_id;
   }


   public function setSigla($sigla){
      $this->sigla = $sigla;
   }

   public function getSigla(){
       return $this->sigla;
   }


   public function setDescripcion($descripcion){
      $this->descripcion = $descripcion;
   }

   public function getDescripcion(){
       return $this->descripcion;
   }


   public function setA_usuario_id($a_usuario_id){
      $this->a_usuario_id = $a_usuario_id;
   }

   public function getA_usuario_id(){
       return $this->a_usuario_id;
   }


   public function setA_ip($a_ip){
      $this->a_ip = $a_ip;
   }

   public function getA_ip(){
       return $this->a_ip;
   }


   public function setA_fecha($a_fecha){
      $this->a_fecha = $a_fecha;
   }

   public function getA_fecha(){
       return $this->a_fecha;
   }


   public function setA_estado_id($a_estado_id){
      $this->a_estado_id = $a_estado_id;
   }

   public function getA_estado_id(){
       return $this->a_estado_id;
   }


}

