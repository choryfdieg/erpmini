<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of ProductoControl
 *
 * @author chory
 */
require_once 'model/negocio/facade/ProductoFacade.php';
require_once 'model/negocio/entity/Producto.php';
require_once 'model/negocio/facade/TarifaFacade.php';
require_once 'model/negocio/entity/Tarifa.php';
require_once 'model/kardex/facade/KardexFacade.php';
require_once 'model/kardex/entity/Kardex.php';
require_once 'model/negocio/facade/ImpuestoFacade.php';

class ProductoControl {

    function ProductoControl() {
        
    }

    public function index() {
        include_once 'view/negocio/producto/view.php';
    }

    public function add() {
        
        $producto = new Producto();
        
        include_once 'view/negocio/producto/create.php';
    }

    public function edit($request) {
        $productoFacade = new ProductoFacade();

        $producto = $productoFacade->findById($request->id);
        
        include_once 'view/negocio/producto/create.php';
    }

    public function getProductos() {
        $productoFacade = new ProductoFacade();
        $entities = $productoFacade->setParams(array('likeArray' => true))->findEntities();
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
    public function getProducto($request) {
        $productoFacade = new ProductoFacade();
        $entity = $productoFacade->findById($request->id);

        echo json_encode($entity);
    }

    public function postProducto($request) {

        $productoFacade = new ProductoFacade();

        $producto = new Producto((array) $request);

        $productoFacade->doEdit($producto);
        
        echo json_encode(array('id' => $producto->id));
    }

    public function putProducto($request) {

        $productoFacade = new ProductoFacade();

        $producto = $productoFacade->findById($request->id);

        $producto->merge((array) $request);

        $productoFacade->doEdit($producto);
        
        echo json_encode(array('id' => $producto->id));
    }
    
    // *** CONTROL TARIFAS
    
    public function getTarifasProducto($request) {        
        $tarifaFacade = new TarifaFacade();
        $entities = $tarifaFacade->setParams(array('filters' => array(" and producto_id = {$request->producto_id}"), 'likeArray' => true))->findEntities();
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
    public function getTarifa($request) {        
        $tarifaFacade = new TarifaFacade();
        $kardexFacade = new KardexFacade();
        
        $entity = $tarifaFacade->findById($request->id);

        $kardexArray = $kardexFacade->setParams(array('filters' => array(' and a_estado_id = ' . KardexFacade::$ESTADOACTIVO," and tarifa_id = {$entity->id}")))->findEntities();
        
        $entity->kardexArray = $kardexArray;
        
        echo json_encode(array('tarifa' => $entity));
    }

    public function postTarifa($request) {

        $tarifaKardexArray = (isset($request->kardex)) ? $request->kardex : array();
        
        $tarifaFacade = new TarifaFacade();

        $tarifa = new Tarifa($request->tarifa);

        $tarifaFacade->doEdit($tarifa);
        
        $this->saveKardex($tarifaKardexArray, $tarifa->costo_unitario, $tarifa->id);
        
        echo json_encode(array('id' => $tarifa->id));
    }

    public function putTarifa($request) {
        
        $tarifaKardexArray = (isset($request->kardex)) ? $request->kardex : array();
        
        $tarifaFacade = new TarifaFacade();

        $tarifa = $tarifaFacade->findById($request->tarifa['id']);

        $tarifa->merge($request->tarifa);

        $tarifaFacade->doEdit($tarifa);
        
        $this->saveKardex($tarifaKardexArray, $tarifa->costo_unitario, $tarifa->id);
        
        echo json_encode(array('id' => $tarifa->id));
    }
    
    public function saveKardex($tarifaKardexArray, $costoUnitario, $tarifaId){
        
        $kardexFacade = new KardexFacade();
        
        $kardexActivos = array();
        
        foreach ($tarifaKardexArray as $tarifaKardex) {
            
            if($tarifaKardex['id'] > 0){
                $kardex = $kardexFacade->findById($tarifaKardex['id']);
            }else{
                $kardex = new Kardex();
            }
            
            $kardex->fecha = date('Ymd');
            $kardex->tipo_movimiento_kardex_id = KardexFacade::$ENTRADA;
            $kardex->a_estado_id = KardexFacade::$ESTADOACTIVO;
            $kardex->tarifa_id = $tarifaId;
            $kardex->costo_unitario = $costoUnitario;
            
            $kardex->merge($tarifaKardex);
            
            $kardexFacade->doEdit($kardex);
        
            $kardexActivos[] = $kardex->id;
        }
        
        $kardexFacade->inactivarKardexProducto($tarifaId, $kardexActivos);
        
    }
    
    // *** END CONTROL TARIFAS
    
    public function getImpuestosForSelect(){        
       $impuestoFacade = new ImpuestoFacade();
       $entities = $impuestoFacade->setParams(array('select' => array('id', 'nombre')))->findEntities();       
       return $entities;       
   }

}
