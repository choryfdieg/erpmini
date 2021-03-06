<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Kardex
*
* @author chory
* @date 2018-01-10 09:01:52
*/
require_once 'model/Entity.php';


class Kardex extends Entity{

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
   public $sucursal_id;

   /**
   *
   * @type bigint(15)
   * @length (15)
   */
   public $factura_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $tarifa_id;

   /**
   *
   * @type date
   * @length 
   */
   public $fecha;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $cantidad;

   /**
   *
   * @type decimal(15,0)
   * @length (15,0)
   */
   public $costo_unitario;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $tipo_movimiento_kardex_id;

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



   function Kardex($fieldsValues = array()) {
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


   public function setFactura_id($factura_id){
      $this->factura_id = $factura_id;
   }

   public function getFactura_id(){
       return $this->factura_id;
   }


   public function setTarifa_id($tarifa_id){
      $this->tarifa_id = $tarifa_id;
   }

   public function getTarifa_id(){
       return $this->tarifa_id;
   }


   public function setFecha($fecha){
      $this->fecha = $fecha;
   }

   public function getFecha(){
       return $this->fecha;
   }


   public function setCantidad($cantidad){
      $this->cantidad = $cantidad;
   }

   public function getCantidad(){
       return $this->cantidad;
   }


   public function setCosto_unitario($costo_unitario){
      $this->costo_unitario = $costo_unitario;
   }

   public function getCosto_unitario(){
       return $this->costo_unitario;
   }


   public function setTipo_movimiento_kardex_id($tipo_movimiento_kardex_id){
      $this->tipo_movimiento_kardex_id = $tipo_movimiento_kardex_id;
   }

   public function getTipo_movimiento_kardex_id(){
       return $this->tipo_movimiento_kardex_id;
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

