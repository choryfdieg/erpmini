<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mFactura_productoControl
 *
 * @author chory
 */

require_once 'model/ingresos/facade/Factura_productoFacade.php';

class mFactura_productoControl {
	
   function mFactura_productoControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/ingresos/factura_producto/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getFactura_productos(){        
       $factura_productoFacade = new Factura_productoFacade();
       $entities = $factura_productoFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
