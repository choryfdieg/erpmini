<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Tarifa
*
* @author chory
* @date 2017-11-02 15:11:26
*/
require_once 'model/Entity.php';


class Tarifa extends Entity{

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
   public $producto_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $unidad_medida_id;

   /**
   *
   * @type decimal(15,0)
   * @length (15,0)
   */
   public $costo_unitario;

   /**
   *
   * @type decimal(15,0)
   * @length (15,0)
   */
   public $valor_unitario;

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



   function Tarifa($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setProducto_id($producto_id){
      $this->producto_id = $producto_id;
   }

   public function getProducto_id(){
       return $this->producto_id;
   }


   public function setUnidad_medida_id($unidad_medida_id){
      $this->unidad_medida_id = $unidad_medida_id;
   }

   public function getUnidad_medida_id(){
       return $this->unidad_medida_id;
   }


   public function setCosto_unitario($costo_unitario){
      $this->costo_unitario = $costo_unitario;
   }

   public function getCosto_unitario(){
       return $this->costo_unitario;
   }


   public function setValor_unitario($valor_unitario){
      $this->valor_unitario = $valor_unitario;
   }

   public function getValor_unitario(){
       return $this->valor_unitario;
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

