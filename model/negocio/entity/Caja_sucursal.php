<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Caja_sucursal
*
* @author chory
* @date 2017-11-30 17:11:47
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
   * @id id
   * @autoincrement true
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

