<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of ClienteControl
 *
 * @author chory
 */

require_once 'model/crm/facade/TerceroFacade.php';

class ClienteControl {
	
   function ClienteControl(){
   }

   public function index(){        
       include_once 'view/crm/cliente/view.php';
   }

   public function getClientes($request){        
       $terceroFacade = new TerceroFacade();
       $entities = $terceroFacade->setParams(array('likeArray' => true))->findEntities();
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
   public function getCliente($request){        
       $terceroFacade = new TerceroFacade();
       $entity = $terceroFacade->findById($request->id);
       echo json_encode($entity);       
   }
   
   public function postCliente($request){        
       
       $terceroFacade = new TerceroFacade();
       
       $tercero = new Tercero((array)$request);
       
       $terceroFacade->doEdit($tercero);
       
       echo json_encode(array('id' => $tercero->id));
   }
   
   public function putCliente($request){        
       
       $terceroFacade = new TerceroFacade();
       
       $tercero = $terceroFacade->findById($request->id);
       
       $tercero->merge((array)$request);
       
       $terceroFacade->doEdit($tercero); 
       
       echo json_encode(array('id' => $tercero->id));
   }
}
