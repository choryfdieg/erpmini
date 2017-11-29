<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mFactura_forma_pagoControl
 *
 * @author chory
 */

require_once 'model/ingresos/facade/Factura_forma_pagoFacade.php';

class mFactura_forma_pagoControl {
	
   function mFactura_forma_pagoControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/ingresos/factura_forma_pago/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getFactura_forma_pagos(){        
       $factura_forma_pagoFacade = new Factura_forma_pagoFacade();
       $entities = $factura_forma_pagoFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
