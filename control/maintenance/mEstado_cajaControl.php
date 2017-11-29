<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mEstado_cajaControl
 *
 * @author chory
* @date 2017-10-31 08:10:51
 */

require_once 'model/sistema/facade/Estado_cajaFacade.php';
require_once 'model/sistema/entity/Estado_caja.php';

class mEstado_cajaControl {
	
   function mEstado_cajaControl(){
   }

   public function index(){        
   }

   public function view(){        
       include_once 'view/maintenance/sistema/estado_caja/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getEstado_cajas($request){        
       $estado_cajaFacade = new Estado_cajaFacade();
       $entities = $estado_cajaFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }public function getEstado_caja($request){
	   $estado_cajaFacade = new Estado_cajaFacade();
	   $entity = $estado_cajaFacade->findById($request->id);
	   echo json_encode($entity);       
   }
   
   public function postEstado_caja($request){
	   
	   $estado_cajaFacade = new Estado_cajaFacade();
	   
	   $estado_caja = new Estado_caja((array)$request);
	   
	   $estado_cajaFacade->doEdit($estado_caja);
   }
   
   public function putEstado_caja($request){
	   
	   $estado_cajaFacade = new Estado_cajaFacade();
	   
	   $estado_caja = $estado_cajaFacade->findById($request->id);
	   	   $estado_caja->merge((array)$request);
	   
	   $estado_cajaFacade->doEdit($estado_caja);       
   }

}
