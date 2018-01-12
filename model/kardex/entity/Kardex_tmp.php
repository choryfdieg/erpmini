<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of Kardex_tmp
*
* @author chory
* @date 2018-01-10 15:01:07
*/
require_once 'model/Entity.php';


class Kardex_tmp extends Entity{

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
   * @type int(11)
   * @length (11)
   */
   public $cantidad;

   /**
   *
   * @type int(11)
   * @length (11)
   */
   public $tipo_movimiento_kardex_id;



   function Kardex_tmp($fieldsValues = array()) {
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


   public function setCantidad($cantidad){
      $this->cantidad = $cantidad;
   }

   public function getCantidad(){
       return $this->cantidad;
   }


   public function setTipo_movimiento_kardex_id($tipo_movimiento_kardex_id){
      $this->tipo_movimiento_kardex_id = $tipo_movimiento_kardex_id;
   }

   public function getTipo_movimiento_kardex_id(){
       return $this->tipo_movimiento_kardex_id;
   }


}

