<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Factura_producto_saldo_detalle
*
* @author chory
* @date 2017-11-02 15:11:26
*/
require_once 'model/Entity.php';


class Factura_producto_saldo_detalle extends Entity{

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
   * @type bigint(15)
   * @length (15)
   */
   public $factura_producto_saldo_id;

   /**
   *
   * @type bigint(15)
   * @length (15)
   */
   public $factura_id;

   /**
   *
   * @type bigint(15)
   * @length (15)
   */
   public $factura_producto_id;

   /**
   *
   * @type decimal(25,15)
   * @length (25,15)
   */
   public $valor;

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



   function Factura_producto_saldo_detalle($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setFactura_producto_saldo_id($factura_producto_saldo_id){
      $this->factura_producto_saldo_id = $factura_producto_saldo_id;
   }

   public function getFactura_producto_saldo_id(){
       return $this->factura_producto_saldo_id;
   }


   public function setFactura_id($factura_id){
      $this->factura_id = $factura_id;
   }

   public function getFactura_id(){
       return $this->factura_id;
   }


   public function setFactura_producto_id($factura_producto_id){
      $this->factura_producto_id = $factura_producto_id;
   }

   public function getFactura_producto_id(){
       return $this->factura_producto_id;
   }


   public function setValor($valor){
      $this->valor = $valor;
   }

   public function getValor(){
       return $this->valor;
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

