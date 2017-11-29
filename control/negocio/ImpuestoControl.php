<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of ImpuestoControl
 *
 * @author chory
 */

require_once 'model/negocio/facade/ImpuestoFacade.php';

class ImpuestoControl {
	
   function ImpuestoControl(){
   }

   public function index(){        
   }

   public function getImpuestos(){        
       $impuestoFacade = new ImpuestoFacade();
       $entities = $impuestoFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
   
    /**
    * 
    * @param id
    */
   public function getImpuesto($request){        
       $impuestoFacade = new ImpuestoFacade();
       $entity = $impuestoFacade->findById($request->id);
       echo json_encode($entity);       
   }
   
   public function postImpuesto($request){        
       
       $impuestoFacade = new ImpuestoFacade();
       
       $impuesto = new Impuesto((array)$request);
       
       $impuestoFacade->doEdit($impuesto);
   }
   
   public function putImpuesto($request){        
       
       $impuestoFacade = new ImpuestoFacade();
       
       $impuesto = $impuestoFacade->findById($request->id);
       
       $impuesto->merge((array)$request);
       
       $impuestoFacade->doEdit($impuesto);       
   }
}
