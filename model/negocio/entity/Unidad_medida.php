<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Unidad_medida
*
* @author chory
* @date 2017-11-02 15:11:26
*/
require_once 'model/Entity.php';


class Unidad_medida extends Entity{

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
   * @id id
   * @autoincrement true
   * @type int(11)
   * @length (11)
   */
   public $grupo_unidad_medida_id;

   /**
   *
   * @type varchar(10)
   * @length (10)
   */
   public $simbolo;

   /**
   *
   * @type varchar(100)
   * @length (100)
   */
   public $descripcion;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $a_usuario;

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



   function Unidad_medida($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setGrupo_unidad_medida_id($grupo_unidad_medida_id){
      $this->grupo_unidad_medida_id = $grupo_unidad_medida_id;
   }

   public function getGrupo_unidad_medida_id(){
       return $this->grupo_unidad_medida_id;
   }


   public function setSimbolo($simbolo){
      $this->simbolo = $simbolo;
   }

   public function getSimbolo(){
       return $this->simbolo;
   }


   public function setDescripcion($descripcion){
      $this->descripcion = $descripcion;
   }

   public function getDescripcion(){
       return $this->descripcion;
   }


   public function setA_usuario($a_usuario){
      $this->a_usuario = $a_usuario;
   }

   public function getA_usuario(){
       return $this->a_usuario;
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

