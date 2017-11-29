<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Factura_producto
*
* @author chory
* @date 2017-11-02 15:11:26
*/
require_once 'model/Entity.php';


class Factura_producto extends Entity{

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
   * @type bigint(15)
   * @length (15)
   */
   public $factura_producto_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $tarifa_id;

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
   public $valor_unitario;

   /**
   *
   * @type decimal(15,0)
   * @length (15,0)
   */
   public $descuento;

   /**
   *
   * @type decimal(15,0)
   * @length (15,0)
   */
   public $valor_total;

   /**
   *
   * @type decimal(15,0)
   * @length (15,0)
   */
   public $valor_impuesto;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $cantidad_devolucion;
   
   /**
   *
   * @type varchar(1000)
   * @length (1000)
   */
   public $producto;
   
   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $unidad_medida;

   /**
   *
   * @type varchar(200)
   * @length (200)
   */
   public $impuesto;

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



   function Factura_producto($fieldsValues = array()) {
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
   
   function getFactura_producto_id() {
       return $this->factura_producto_id;
   }

   function setFactura_producto_id($factura_producto_id) {
       $this->factura_producto_id = $factura_producto_id;
   }
   
   public function setTarifa_id($tarifa_id){
      $this->tarifa_id = $tarifa_id;
   }

   public function getTarifa_id(){
       return $this->tarifa_id;
   }


   public function setCantidad($cantidad){
      $this->cantidad = $cantidad;
   }

   public function getCantidad(){
       return $this->cantidad;
   }


   public function setValor_unitario($valor_unitario){
      $this->valor_unitario = $valor_unitario;
   }

   public function getValor_unitario(){
       return $this->valor_unitario;
   }


   public function setDescuento($descuento){
      $this->descuento = $descuento;
   }

   public function getDescuento(){
       return $this->descuento;
   }


   public function setValor_total($valor_total){
      $this->valor_total = $valor_total;
   }

   public function getValor_total(){
       return $this->valor_total;
   }
   
   
   function getProducto() {
       return $this->producto;
   }

   function setProducto($producto) {
       $this->producto = $producto;
   }

   function getCantidad_devolucion() {
       return $this->cantidad_devolucion;
   }

   function setCantidad_devolucion($cantidad_devolucion) {
       $this->cantidad_devolucion = $cantidad_devolucion;
   }

    public function setValor_impuesto($valor_impuesto){
      $this->valor_impuesto = $valor_impuesto;
   }

   public function getValor_impuesto(){
       return $this->valor_impuesto;
   }


   public function setUnidad_medida($unidad_medida){
      $this->unidad_medida = $unidad_medida;
   }

   public function getUnidad_medida(){
       return $this->unidad_medida;
   }


   public function setImpuesto($impuesto){
      $this->impuesto = $impuesto;
   }

   public function getImpuesto(){
       return $this->impuesto;
   }


   public function setPorcentaje_impuesto($porcentaje_impuesto){
      $this->porcentaje_impuesto = $porcentaje_impuesto;
   }

   public function getPorcentaje_impuesto(){
       return $this->porcentaje_impuesto;
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

