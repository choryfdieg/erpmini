<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mKardexControl
 *
 * @author chory
 */

require_once 'model/kardex/facade/KardexFacade.php';

class mKardexControl {
	
   function mKardexControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/kardex/kardex/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getKardexs(){        
       $kardexFacade = new KardexFacade();
       $entities = $kardexFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
