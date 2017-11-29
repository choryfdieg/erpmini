<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mPucControl
 *
 * @author chory
 */

require_once 'model/contabilidad/facade/PucFacade.php';
require_once 'model/contabilidad/entity/Puc.php';

class mPucControl {
	
   function mPucControl(){
   }

   public function index(){        
   }

   public function view(){        
       include_once 'view/maintenance/contabilidad/puc/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getPucs($request){        
       $pucFacade = new PucFacade();
       $entities = $pucFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }public function getPuc($request){
	   $pucFacade = new PucFacade();
	   $entity = $pucFacade->findById($request->id);
	   echo json_encode($entity);       
   }
   
   public function postPuc($request){
	   
	   $pucFacade = new PucFacade();
	   
	   $puc = new Puc((array)$request);
	   
	   $pucFacade->doEdit($puc);
   }
   
   public function putPuc($request){
	   
	   $pucFacade = new PucFacade();
	   
	   $puc = $pucFacade->findById($request->id);
	   	   $puc->merge((array)$request);
	   
	   $pucFacade->doEdit($puc);       
   }

}
