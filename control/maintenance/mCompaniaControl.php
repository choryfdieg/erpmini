<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mCompaniaControl
 *
 * @author chory
 */

require_once 'model/contabilidad/facade/CompaniaFacade.php';
require_once 'model/contabilidad/entity/Compania.php';

class mCompaniaControl {
	
   function mCompaniaControl(){
   }

   public function index(){        
   }

   public function view(){        
       include_once 'view/maintenance/contabilidad/compania/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getCompanias($request){        
       $companiaFacade = new CompaniaFacade();
       $entities = $companiaFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }public function getCompania($request){
	   $companiaFacade = new CompaniaFacade();
	   $entity = $companiaFacade->findById($request->id);
	   echo json_encode($entity);       
   }
   
   public function postCompania($request){
	   
	   $companiaFacade = new CompaniaFacade();
	   
	   $compania = new Compania((array)$request);
	   
	   $companiaFacade->doEdit($compania);
   }
   
   public function putCompania($request){
	   
	   $companiaFacade = new CompaniaFacade();
	   
	   $compania = $companiaFacade->findById($request->id);
	   	   $compania->merge((array)$request);
	   
	   $companiaFacade->doEdit($compania);       
   }

}
