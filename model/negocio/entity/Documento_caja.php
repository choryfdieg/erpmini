<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Documento_caja
*
* @author chory
* @date 2018-01-12 15:01:25
*/
require_once 'model/Entity.php';


class Documento_caja extends Entity{

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
   * @type int(11)
   * @length (11)
   */
   public $tipo_factura_id;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $prefijo;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $numero_inicial;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $numero_final;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $numero_actual;

   /**
   *
   * @type varchar(500)
   * @length (500)
   */
   public $texto_numeracion;

   /**
   *
   * @type varchar(500)
   * @length (500)
   */
   public $texto_resolucion;

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



   function Documento_caja($fieldsValues = array()) {
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


   public function setTipo_factura_id($tipo_factura_id){
      $this->tipo_factura_id = $tipo_factura_id;
   }

   public function getTipo_factura_id(){
       return $this->tipo_factura_id;
   }


   public function setPrefijo($prefijo){
      $this->prefijo = $prefijo;
   }

   public function getPrefijo(){
       return $this->prefijo;
   }


   public function setNumero_inicial($numero_inicial){
      $this->numero_inicial = $numero_inicial;
   }

   public function getNumero_inicial(){
       return $this->numero_inicial;
   }


   public function setNumero_final($numero_final){
      $this->numero_final = $numero_final;
   }

   public function getNumero_final(){
       return $this->numero_final;
   }


   public function setNumero_actual($numero_actual){
      $this->numero_actual = $numero_actual;
   }

   public function getNumero_actual(){
       return $this->numero_actual;
   }


   public function setTexto_numeracion($texto_numeracion){
      $this->texto_numeracion = $texto_numeracion;
   }

   public function getTexto_numeracion(){
       return $this->texto_numeracion;
   }


   public function setTexto_resolucion($texto_resolucion){
      $this->texto_resolucion = $texto_resolucion;
   }

   public function getTexto_resolucion(){
       return $this->texto_resolucion;
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

