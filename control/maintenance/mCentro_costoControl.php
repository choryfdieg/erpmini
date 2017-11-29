<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mCentro_costoControl
 *
 * @author chory
 */

require_once 'model/contabilidad/facade/Centro_costoFacade.php';

class mCentro_costoControl {
	
   function mCentro_costoControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/contabilidad/centro_costo/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getCentro_costos(){        
       $centro_costoFacade = new Centro_costoFacade();
       $entities = $centro_costoFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
