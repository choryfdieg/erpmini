<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mA_estadoControl
 *
 * @author chory
 */

require_once 'model/sistema/facade/A_estadoFacade.php';

class mA_estadoControl {
	
   function mA_estadoControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/sistema/a_estado/view.php';
   }

   public function getA_estados($request){        
       $a_estadoFacade = new A_estadoFacade();
       $entities = $a_estadoFacade->setParams(array('likeArray' => true))->findEntities();
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
   public function getA_estado($request){        
       $a_estadoFacade = new A_estadoFacade();
       $entity = $a_estadoFacade->findById($request->id);
       echo json_encode($entity);       
   }
   
   public function postA_estado($request){        
       
       $a_estadoFacade = new A_estadoFacade();
       
       $a_estado = new A_estado((array)$request);
       
       $a_estadoFacade->doEdit($a_estado);
   }
   
   public function putA_estado($request){        
       
       $a_estadoFacade = new A_estadoFacade();
       
       $a_estado = $a_estadoFacade->findById($request->id);
       
       $a_estado->merge((array)$request);
       
       $a_estadoFacade->doEdit($a_estado);       
   }
   
   public function deleteA_estado($request){        
       
       $a_estadoFacade = new A_estadoFacade();
       
       $a_estadoFacade->remove($request->id);
   }

   public function guardar($request){       
       var_dump($request);
   }
   
}
