<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mNumero_facturaControl
 *
 * @author chory
* @date 2017-10-26 17:10:39
 */

require_once 'model/negocio/facade/Numero_facturaFacade.php';
require_once 'model/negocio/entity/Numero_factura.php';

class mNumero_facturaControl {
	
   function mNumero_facturaControl(){
   }

   public function index(){        
   }

   public function view(){        
       include_once 'view/maintenance/negocio/numero_factura/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getNumero_facturas($request){        
       $numero_facturaFacade = new Numero_facturaFacade();
       $entities = $numero_facturaFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }public function getNumero_factura($request){
	   $numero_facturaFacade = new Numero_facturaFacade();
	   $entity = $numero_facturaFacade->findById($request->id);
	   echo json_encode($entity);       
   }
   
   public function postNumero_factura($request){
	   
	   $numero_facturaFacade = new Numero_facturaFacade();
	   
	   $numero_factura = new Numero_factura((array)$request);
	   
	   $numero_facturaFacade->doEdit($numero_factura);
   }
   
   public function putNumero_factura($request){
	   
	   $numero_facturaFacade = new Numero_facturaFacade();
	   
	   $numero_factura = $numero_facturaFacade->findById($request->id);
	   	   $numero_factura->merge((array)$request);
	   
	   $numero_facturaFacade->doEdit($numero_factura);       
   }

}
