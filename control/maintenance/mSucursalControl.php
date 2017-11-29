<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mSucursalControl
 *
 * @author chory
 */

require_once 'model/negocio/facade/SucursalFacade.php';

class mSucursalControl {
	
   function mSucursalControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/negocio/sucursal/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getSucursals(){        
       $sucursalFacade = new SucursalFacade();
       $entities = $sucursalFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
