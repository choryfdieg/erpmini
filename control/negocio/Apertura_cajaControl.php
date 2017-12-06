<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *//**
 * Description of Apertura_cajaControl
 *
 * @author chory
 * @date 2017-10-26 17:10:58
 */
require_once 'model/negocio/facade/Apertura_cajaFacade.php';
require_once 'model/negocio/entity/Apertura_caja.php';

class Apertura_cajaControl {

    function Apertura_cajaControl() {
        
    }

    public function index() {
        
    }

    public function view() {
        
    }
    
    public function create() {
        include_once 'view/negocio/apertura_caja/create.php';
    }

    /**
     * @api
     * @method GET
     */
    public function getApertura_cajas($request) {
        $apertura_cajaFacade = new Apertura_cajaFacade();
        $entities = $apertura_cajaFacade->setParams(array('likeArray' => true))->findEntities();
        $entitiesData = array();
        foreach ($entities as $entity) {
            $entitiesData[] = array_values($entity);
        }
        echo json_encode(array('data' => $entitiesData));
    }

    public function getApertura_caja($request) {
        $apertura_cajaFacade = new Apertura_cajaFacade();
        $entity = $apertura_cajaFacade->findById($request->id);
        echo json_encode($entity);
    }

    public function postApertura_caja($request) {

        $apertura_cajaFacade = new Apertura_cajaFacade();

        $apertura_caja = new Apertura_caja((array) $request);
        
        $apertura_caja->fecha_apertura = date("Y/m/d");
        $apertura_caja->a_estado_id = 1;

        $apertura_cajaFacade->doEdit($apertura_caja);
    }

    public function putApertura_caja($request) {

        $apertura_cajaFacade = new Apertura_cajaFacade();

        $apertura_caja = $apertura_cajaFacade->findById($request->id);
        $apertura_caja->merge((array) $request);

        $apertura_cajaFacade->doEdit($apertura_caja);
    }

}
