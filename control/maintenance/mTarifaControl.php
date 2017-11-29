<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mTarifaControl
 *
 * @author chory
 */

require_once 'model/negocio/facade/TarifaFacade.php';

class mTarifaControl {
	
   function mTarifaControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/negocio/tarifa/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getTarifas(){        
       $tarifaFacade = new TarifaFacade();
       $entities = $tarifaFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
