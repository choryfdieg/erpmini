<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of SucursalControl
 *
 * @author chory
 */

require_once 'model/negocio/facade/SucursalFacade.php';

class SucursalControl {
	
   function SucursalControl(){
   }

   public function index(){        
       include_once 'view/moduleExample/example/example.php';
   }

   public function getSucursals(){
       $sucursalFacade = new SucursalFacade();
       $entities = $sucursalFacade->setParams(array('likeArray' => true))->findEntities();
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
   public function getSucursal($request){        
       $sucursalFacade = new SucursalFacade();
       $entity = $sucursalFacade->findById($request->id);
       
       echo json_encode($entity);       
   }
   
   public function postSucursal($request){        
       
       $sucursalFacade = new SucursalFacade();
       
       $sucursal = new Sucursal((array)$request);
       
       $sucursalFacade->doEdit($sucursal);
   }
   
   public function putSucursal($request){        
       
       $sucursalFacade = new SucursalFacade();
       
       $sucursal = $sucursalFacade->findById($request->id);
       
       $sucursal->merge((array)$request);
       
       $sucursalFacade->doEdit($sucursal);       
   }
   
   public function getSucursalsForSelect(){
       $sucursalFacade = new SucursalFacade();
       $entities = $sucursalFacade->setParams(array('select' => array('id', 'nombre')))->findEntities();
       echo json_encode($entities);       
   }
}
