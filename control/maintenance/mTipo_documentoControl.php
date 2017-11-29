<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mTipo_documentoControl
 *
 * @author chory
 */

require_once 'model/sistema/facade/Tipo_documentoFacade.php';

class mTipo_documentoControl {
	
   function mTipo_documentoControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/sistema/tipo_documento/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getTipo_documentos(){        
       $tipo_documentoFacade = new Tipo_documentoFacade();
       $entities = $tipo_documentoFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
