<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Puc
*
* @author chory
* @date 2018-01-10 09:01:52
*/
require_once 'model/Entity.php';


class Puc extends Entity{

   /**
   *
   * @id id
   * @autoincrement true
   * @type bigint(15)
   * @length (15)
   */
   public $id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $compania_id;

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
   public $tipo_cuenta_id;

   /**
   *
   * @type varchar(100)
   * @length (100)
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
   * @type varchar(45)
   * @length (45)
   */
   public $cuenta_objecto;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $sub_cuenta;

   /**
   *
   * @type varchar(100)
   * @length (100)
   */
   public $cuenta_detalle;

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



   function Puc($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setCompania_id($compania_id){
      $this->compania_id = $compania_id;
   }

   public function getCompania_id(){
       return $this->compania_id;
   }


   public function setCentro_costo_id($centro_costo_id){
      $this->centro_costo_id = $centro_costo_id;
   }

   public function getCentro_costo_id(){
       return $this->centro_costo_id;
   }


   public function setTipo_cuenta_id($tipo_cuenta_id){
      $this->tipo_cuenta_id = $tipo_cuenta_id;
   }

   public function getTipo_cuenta_id(){
       return $this->tipo_cuenta_id;
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


   public function setCuenta_objecto($cuenta_objecto){
      $this->cuenta_objecto = $cuenta_objecto;
   }

   public function getCuenta_objecto(){
       return $this->cuenta_objecto;
   }


   public function setSub_cuenta($sub_cuenta){
      $this->sub_cuenta = $sub_cuenta;
   }

   public function getSub_cuenta(){
       return $this->sub_cuenta;
   }


   public function setCuenta_detalle($cuenta_detalle){
      $this->cuenta_detalle = $cuenta_detalle;
   }

   public function getCuenta_detalle(){
       return $this->cuenta_detalle;
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

