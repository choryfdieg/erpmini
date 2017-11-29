<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mTerceroControl
 *
 * @author chory
 */

require_once 'model/crm/facade/TerceroFacade.php';

class mTerceroControl {
	
   function mTerceroControl(){
   }

   public function index(){        
       echo 'index';
   }

   public function listar(){        
       include_once 'view/maintenance/contabilidad/tercero/view.php';
   }
   
   public function getTerceros($request){        
       $terceroFacade = new TerceroFacade();
       $entities = $terceroFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
