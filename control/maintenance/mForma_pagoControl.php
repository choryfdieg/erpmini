<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of mForma_pagoControl
 *
 * @author chory
 */

require_once 'model/ingresos/facade/Forma_pagoFacade.php';

class mForma_pagoControl {
	
   function mForma_pagoControl(){
   }

   public function index(){        
   }

   public function listar(){        
       include_once 'view/maintenance/ingresos/forma_pago/view.php';
   }

   /**
   * @api
   * @method GET
   */
   public function getForma_pagos(){        
       $forma_pagoFacade = new Forma_pagoFacade();
       $entities = $forma_pagoFacade->setParams(array('likeArray' => true))->findEntities();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
}
