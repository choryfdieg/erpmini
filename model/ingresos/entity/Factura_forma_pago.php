<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Factura_forma_pago
*
* @author chory
* @date 2017-11-02 15:11:26
*/
require_once 'model/Entity.php';


class Factura_forma_pago extends Entity{

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
   public $factura_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $forma_pago_id;

   /**
   *
   * @type decimal(15,0)
   * @length (15,0)
   */
   public $valor;

   /**
   *
   * @type varchar(100)
   * @length (100)
   */
   public $referencia;

   /**
   *
   * @type varchar(100)
   * @length (100)
   */
   public $voucher_tarjeta;

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



   function Factura_forma_pago($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setFactura_id($factura_id){
      $this->factura_id = $factura_id;
   }

   public function getFactura_id(){
       return $this->factura_id;
   }


   public function setForma_pago_id($forma_pago_id){
      $this->forma_pago_id = $forma_pago_id;
   }

   public function getForma_pago_id(){
       return $this->forma_pago_id;
   }


   public function setValor($valor){
      $this->valor = $valor;
   }

   public function getValor(){
       return $this->valor;
   }


   public function setReferencia($referencia){
      $this->referencia = $referencia;
   }

   public function getReferencia(){
       return $this->referencia;
   }


   public function setVoucher_tarjeta($voucher_tarjeta){
      $this->voucher_tarjeta = $voucher_tarjeta;
   }

   public function getVoucher_tarjeta(){
       return $this->voucher_tarjeta;
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

