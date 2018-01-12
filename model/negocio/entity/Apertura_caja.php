<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Apertura_caja
*
* @author chory
* @date 2018-01-10 09:01:52
*/
require_once 'model/Entity.php';


class Apertura_caja extends Entity{

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
   public $caja_sucursal_id;

   /**
   *
   * @type datetime
   * @length 
   */
   public $fecha_apertura;

   /**
   *
   * @type datetime
   * @length 
   */
   public $fecha_cierre;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $estado_caja_id;

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



   function Apertura_caja($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setCaja_sucursal_id($caja_sucursal_id){
      $this->caja_sucursal_id = $caja_sucursal_id;
   }

   public function getCaja_sucursal_id(){
       return $this->caja_sucursal_id;
   }


   public function setFecha_apertura($fecha_apertura){
      $this->fecha_apertura = $fecha_apertura;
   }

   public function getFecha_apertura(){
       return $this->fecha_apertura;
   }


   public function setFecha_cierre($fecha_cierre){
      $this->fecha_cierre = $fecha_cierre;
   }

   public function getFecha_cierre(){
       return $this->fecha_cierre;
   }


   public function setEstado_caja_id($estado_caja_id){
      $this->estado_caja_id = $estado_caja_id;
   }

   public function getEstado_caja_id(){
       return $this->estado_caja_id;
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

