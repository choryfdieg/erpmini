<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Sucursal
*
* @author chory
* @date 2018-01-10 09:01:52
*/
require_once 'model/Entity.php';


class Sucursal extends Entity{

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
   * @type varchar(500)
   * @length (500)
   */
   public $nombre;

   /**
   *
   * @type varchar(2000)
   * @length (2000)
   */
   public $descripcion;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $centro_costo_id;

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



   function Sucursal($fieldsValues = array()) {
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


   public function setDescripcion($descripcion){
      $this->descripcion = $descripcion;
   }

   public function getDescripcion(){
       return $this->descripcion;
   }


   public function setCentro_costo_id($centro_costo_id){
      $this->centro_costo_id = $centro_costo_id;
   }

   public function getCentro_costo_id(){
       return $this->centro_costo_id;
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

