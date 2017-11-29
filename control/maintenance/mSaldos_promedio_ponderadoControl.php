<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mSaldos_promedio_ponderadoControl
 *
 * @author chory
 */

require_once 'model/kardex/facade/Saldos_promedio_ponderadoFacade.php';

class mSaldos_promedio_ponderadoControl {
	
   function mSaldos_promedio_ponderadoControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/kardex/saldos_promedio_ponderado/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getSaldos_promedio_ponderados(){        
       $saldos_promedio_ponderadoFacade = new Saldos_promedio_ponderadoFacade();
       $entities = $saldos_promedio_ponderadoFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
