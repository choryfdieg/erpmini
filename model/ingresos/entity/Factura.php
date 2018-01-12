<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Factura
*
* @author chory
* @date 2018-01-10 09:01:52
*/
require_once 'model/Entity.php';


class Factura extends Entity{

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
   public $apertura_caja_id;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $prefijo;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $numero;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $tipo_factura_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $tercero_id;

   /**
   *
   * @type bigint(15)
   * @length (15)
   */
   public $factura_id;

   /**
   *
   * @type varchar(2000)
   * @length (2000)
   */
   public $observacion;

   /**
   *
   * @type varchar(2000)
   * @length (2000)
   */
   public $nota;

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



   function Factura($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setApertura_caja_id($apertura_caja_id){
      $this->apertura_caja_id = $apertura_caja_id;
   }

   public function getApertura_caja_id(){
       return $this->apertura_caja_id;
   }


   public function setPrefijo($prefijo){
      $this->prefijo = $prefijo;
   }

   public function getPrefijo(){
       return $this->prefijo;
   }


   public function setNumero($numero){
      $this->numero = $numero;
   }

   public function getNumero(){
       return $this->numero;
   }


   public function setTipo_factura_id($tipo_factura_id){
      $this->tipo_factura_id = $tipo_factura_id;
   }

   public function getTipo_factura_id(){
       return $this->tipo_factura_id;
   }


   public function setTercero_id($tercero_id){
      $this->tercero_id = $tercero_id;
   }

   public function getTercero_id(){
       return $this->tercero_id;
   }


   public function setFactura_id($factura_id){
      $this->factura_id = $factura_id;
   }

   public function getFactura_id(){
       return $this->factura_id;
   }


   public function setObservacion($observacion){
      $this->observacion = $observacion;
   }

   public function getObservacion(){
       return $this->observacion;
   }


   public function setNota($nota){
      $this->nota = $nota;
   }

   public function getNota(){
       return $this->nota;
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

