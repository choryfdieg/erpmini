<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mGrupo_unidad_medidaControl
 *
 * @author chory
 */

require_once 'model/negocio/facade/Grupo_unidad_medidaFacade.php';

class mGrupo_unidad_medidaControl {
	
   function mGrupo_unidad_medidaControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/negocio/grupo_unidad_medida/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getGrupo_unidad_medidas(){        
       $grupo_unidad_medidaFacade = new Grupo_unidad_medidaFacade();
       $entities = $grupo_unidad_medidaFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
