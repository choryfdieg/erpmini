<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mUnidad_medidaControl
 *
 * @author chory
 */

require_once 'model/negocio/facade/Unidad_medidaFacade.php';

class mUnidad_medidaControl {
	
   function mUnidad_medidaControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/negocio/unidad_medida/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getUnidad_medidas(){        
       $unidad_medidaFacade = new Unidad_medidaFacade();
       $entities = $unidad_medidaFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
