<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Caja_sucursal
*
* @author chory
* @date 2018-01-12 15:01:38
*/
require_once 'model/Entity.php';


class Caja_sucursal extends Entity{

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
   public $sucursal_id;

   /**
   *
   * @type varchar(4)
   * @length (4)
   */
   public $numero;

   /**
   *
   * @type varchar(100)
   * @length (100)
   */
   public $nombre;

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



   function Caja_sucursal($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setSucursal_id($sucursal_id){
      $this->sucursal_id = $sucursal_id;
   }

   public function getSucursal_id(){
       return $this->sucursal_id;
   }


   public function setNumero($numero){
      $this->numero = $numero;
   }

   public function getNumero(){
       return $this->numero;
   }


   public function setNombre($nombre){
      $this->nombre = $nombre;
   }

   public function getNombre(){
       return $this->nombre;
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

