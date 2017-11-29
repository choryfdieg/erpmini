<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mImpuestoControl
 *
 * @author chory
 */

require_once 'model/negocio/facade/ImpuestoFacade.php';

class mImpuestoControl {
	
   function mImpuestoControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/negocio/impuesto/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getImpuestos(){        
       $impuestoFacade = new ImpuestoFacade();
       $entities = $impuestoFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
