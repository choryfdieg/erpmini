<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mTipo_facturaControl
 *
 * @author chory
 */

require_once 'model/sistema/facade/Tipo_facturaFacade.php';

class mTipo_facturaControl {
	
   function mTipo_facturaControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/sistema/tipo_factura/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getTipo_facturas(){        
       $tipo_facturaFacade = new Tipo_facturaFacade();
       $entities = $tipo_facturaFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
