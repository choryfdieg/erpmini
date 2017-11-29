<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mFacturaControl
 *
 * @author chory
 */

require_once 'model/ingresos/facade/FacturaFacade.php';

class mFacturaControl {
	
   function mFacturaControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/ingresos/factura/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getFacturas(){        
       $facturaFacade = new FacturaFacade();
       $entities = $facturaFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
