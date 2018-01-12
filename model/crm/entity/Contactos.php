<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Contactos
*
* @author chory
* @date 2018-01-10 09:01:52
*/
require_once 'model/Entity.php';


class Contactos extends Entity{

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
   public $tercero_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $tercero_contacto_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $tipo_contacto_id;

   /**
   *
   * @type varchar(100)
   * @length (100)
   */
   public $cargo;

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



   function Contactos($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setTercero_id($tercero_id){
      $this->tercero_id = $tercero_id;
   }

   public function getTercero_id(){
       return $this->tercero_id;
   }


   public function setTercero_contacto_id($tercero_contacto_id){
      $this->tercero_contacto_id = $tercero_contacto_id;
   }

   public function getTercero_contacto_id(){
       return $this->tercero_contacto_id;
   }


   public function setTipo_contacto_id($tipo_contacto_id){
      $this->tipo_contacto_id = $tipo_contacto_id;
   }

   public function getTipo_contacto_id(){
       return $this->tipo_contacto_id;
   }


   public function setCargo($cargo){
      $this->cargo = $cargo;
   }

   public function getCargo(){
       return $this->cargo;
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

