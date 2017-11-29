<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Producto
*
* @author chory
* @date 2017-11-02 15:11:26
*/
require_once 'model/Entity.php';


class Producto extends Entity{

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
   * @type varchar(1000)
   * @length (1000)
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
   public $impuesto_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $puc_credito_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $puc_debito_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $puc_cartera_id;

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



   function Producto($fieldsValues = array()) {
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


   public function setImpuesto_id($impuesto_id){
      $this->impuesto_id = $impuesto_id;
   }

   public function getImpuesto_id(){
       return $this->impuesto_id;
   }


   public function setPuc_credito_id($puc_credito_id){
      $this->puc_credito_id = $puc_credito_id;
   }

   public function getPuc_credito_id(){
       return $this->puc_credito_id;
   }


   public function setPuc_debito_id($puc_debito_id){
      $this->puc_debito_id = $puc_debito_id;
   }

   public function getPuc_debito_id(){
       return $this->puc_debito_id;
   }


   public function setPuc_cartera_id($puc_cartera_id){
      $this->puc_cartera_id = $puc_cartera_id;
   }

   public function getPuc_cartera_id(){
       return $this->puc_cartera_id;
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

