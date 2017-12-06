<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mCaja_sucursalControl
 *
 * @author chory
* @date 2017-11-30 17:11:47
 */

require_once 'model/negocio/facade/Caja_sucursalFacade.php';
require_once 'model/negocio/entity/Caja_sucursal.php';

class mCaja_sucursalControl {
	
   function mCaja_sucursalControl(){
   }

   public function index(){        
   }

   public function view(){        
       include_once 'view/maintenance/negocio/caja_sucursal/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getCaja_sucursals($request){        
       $caja_sucursalFacade = new Caja_sucursalFacade();
       $entities = $caja_sucursalFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }public function getCaja_sucursal($request){
	   $caja_sucursalFacade = new Caja_sucursalFacade();
	   $entity = $caja_sucursalFacade->findById($request->id);
	   echo json_encode($entity);       
   }
   
   public function postCaja_sucursal($request){
	   
	   $caja_sucursalFacade = new Caja_sucursalFacade();
	   
	   $caja_sucursal = new Caja_sucursal((array)$request);
	   
	   $caja_sucursalFacade->doEdit($caja_sucursal);
   }
   
   public function putCaja_sucursal($request){
	   
	   $caja_sucursalFacade = new Caja_sucursalFacade();
	   
	   $caja_sucursal = $caja_sucursalFacade->findById($request->id);
	   	   $caja_sucursal->merge((array)$request);
	   
	   $caja_sucursalFacade->doEdit($caja_sucursal);       
   }

}
