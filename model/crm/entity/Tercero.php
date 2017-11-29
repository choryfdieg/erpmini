<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Tercero
*
* @author chory
* @date 2017-11-02 15:11:26
*/
require_once 'model/Entity.php';


class Tercero extends Entity{

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
   public $tipo_documento_id;

   /**
   *
   * @type varchar(45)
   * @length (45)
   */
   public $documento;

   /**
   *
   * @type char(1)
   * @length (1)
   */
   public $esproveedor;

   /**
   *
   * @type varchar(300)
   * @length (300)
   */
   public $nombre;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $apelativo_id;

   /**
   *
   * @type date
   * @length 
   */
   public $fecha_nacimiento;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $pais_id;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $ciudad_id;

   /**
   *
   * @type varchar(200)
   * @length (200)
   */
   public $direccion;

   /**
   *
   * @type varchar(200)
   * @length (200)
   */
   public $telefonos;

   /**
   *
   * @type varchar(500)
   * @length (500)
   */
   public $correos_electronicos;

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



   function Tercero($fieldsValues = array()) {
       parent::__construct($fieldsValues);
   }

   public function setId($id){
      $this->id = $id;
   }

   public function getId(){
       return $this->id;
   }


   public function setTipo_documento_id($tipo_documento_id){
      $this->tipo_documento_id = $tipo_documento_id;
   }

   public function getTipo_documento_id(){
       return $this->tipo_documento_id;
   }


   public function setDocumento($documento){
      $this->documento = $documento;
   }

   public function getDocumento(){
       return $this->documento;
   }


   public function setEsproveedor($esproveedor){
      $this->esproveedor = $esproveedor;
   }

   public function getEsproveedor(){
       return $this->esproveedor;
   }


   public function setNombre($nombre){
      $this->nombre = $nombre;
   }

   public function getNombre(){
       return $this->nombre;
   }


   public function setApelativo_id($apelativo_id){
      $this->apelativo_id = $apelativo_id;
   }

   public function getApelativo_id(){
       return $this->apelativo_id;
   }


   public function setFecha_nacimiento($fecha_nacimiento){
      $this->fecha_nacimiento = $fecha_nacimiento;
   }

   public function getFecha_nacimiento(){
       return $this->fecha_nacimiento;
   }


   public function setPais_id($pais_id){
      $this->pais_id = $pais_id;
   }

   public function getPais_id(){
       return $this->pais_id;
   }


   public function setCiudad_id($ciudad_id){
      $this->ciudad_id = $ciudad_id;
   }

   public function getCiudad_id(){
       return $this->ciudad_id;
   }


   public function setDireccion($direccion){
      $this->direccion = $direccion;
   }

   public function getDireccion(){
       return $this->direccion;
   }


   public function setTelefonos($telefonos){
      $this->telefonos = $telefonos;
   }

   public function getTelefonos(){
       return $this->telefonos;
   }


   public function setCorreos_electronicos($correos_electronicos){
      $this->correos_electronicos = $correos_electronicos;
   }

   public function getCorreos_electronicos(){
       return $this->correos_electronicos;
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

