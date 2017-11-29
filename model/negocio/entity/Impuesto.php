<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Impuesto
*
* @author chory
* @date 2017-11-02 15:11:26
*/
require_once 'model/Entity.php';


class Impuesto extends Entity{

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
   * @type varchar(200)
   * @length (200)
   */
   public $nombre;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $porcentaje_impuesto;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $puc_debito_id;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $puc_credito_id;

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



   function Impuesto($fieldsValues = array()) {
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


   public function setPorcentaje_impuesto($porcentaje_impuesto){
      $this->porcentaje_impuesto = $porcentaje_impuesto;
   }

   public function getPorcentaje_impuesto(){
       return $this->porcentaje_impuesto;
   }


   public function setPuc_debito_id($puc_debito_id){
      $this->puc_debito_id = $puc_debito_id;
   }

   public function getPuc_debito_id(){
       return $this->puc_debito_id;
   }


   public function setPuc_credito_id($puc_credito_id){
      $this->puc_credito_id = $puc_credito_id;
   }

   public function getPuc_credito_id(){
       return $this->puc_credito_id;
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

