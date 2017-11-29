<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of Unidad_medidaControl
 *
 * @author chory
 */

require_once 'model/negocio/facade/Unidad_medidaFacade.php';
require_once 'model/negocio/facade/Grupo_unidad_medidaFacade.php';

class Unidad_medidaControl {
	
   function Unidad_medidaControl(){
   }

   public function index(){        
   }

   public function getUnidad_medidas(){        
       $unidad_medidaFacade = new Unidad_medidaFacade();
       $entities = $unidad_medidaFacade->getLstaUnidadesDeMedida();
       $entitiesData = array();
       foreach ($entities as $entity) {
           $entitiesData[] = array_values($entity);
       }
       echo json_encode(array('data' => $entitiesData));       
   }
   
    /**
    * 
    * @param id
    */
   public function getUnidad_medida($request){               
       $unidad_medidaFacade = new Unidad_medidaFacade();
       $entity = $unidad_medidaFacade->setParams(array('joins' => array(array('schema' => 'erpmini','alias' => 'b','table' => 'grupo_unidad_medida'))))->findById($request->id);
       
       echo json_encode($entity);       
   }
   
   public function postUnidad_medida($request){        
       
       $unidad_medidaFacade = new Unidad_medidaFacade();
       
       $unidad_medida = new Unidad_medida((array)$request);
       
       $unidad_medidaFacade->doEdit($unidad_medida);
   }
   
   public function putUnidad_medida($request){        
       
       $unidad_medidaFacade = new Unidad_medidaFacade();
       
       $unidad_medida = $unidad_medidaFacade->findById($request->id);
       
       $unidad_medida->merge((array)$request);
       
       $unidad_medidaFacade->doEdit($unidad_medida);       
   }
   
   public function getGrupo_unidad_medidas(){                      
       $grupo_unidad_medidaFacade = new Grupo_unidad_medidaFacade();
       $entities = $grupo_unidad_medidaFacade->setParams(array('select' => array('id', 'nombre')))->findEntities();
       echo json_encode($entities);       
   }
   
   public function getUnidadesMedidaForSelect(){
       $unidad_medidaFacade = new Unidad_medidaFacade();
       $entities = $unidad_medidaFacade->setParams(array(   'likeArray' => true, 
                                                            'alias' => 'a', 
                                                            'joins' => array(array(
                                                                'schema' => 'erpmini',
                                                                'alias' => 'b',
                                                                'table' => 'grupo_unidad_medida')), 
                                                            'select' => array(
                                                                'a.id', 
                                                                'a.descripcion', 
                                                                "coalesce(a.simbolo, '.') as simbolo",
                                                                'b.nombre as grupo')))->findEntities();
       echo json_encode($entities);       
   }
   
}
