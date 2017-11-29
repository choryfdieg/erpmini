<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mProductoControl
 *
 * @author chory
 */

require_once 'model/negocio/facade/ProductoFacade.php';

class mProductoControl {
	
   function mProductoControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/negocio/producto/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getProductos(){        
       $productoFacade = new ProductoFacade();
       $entities = $productoFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
