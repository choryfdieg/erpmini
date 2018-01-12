<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Apertura_cajaFacade
 *
 * @author chory
 * @date 2017-10-26 17:10:58
 */
include_once('model/AbstractFacade.php');
require_once 'model/negocio/entity/Apertura_caja.php';

class Apertura_cajaFacade extends AbstractFacade {

    function Apertura_cajaFacade() {
        $this->motor = AbstractFacade::$MYSQL;
        $this->schema = 'erpmini';
        $this->entidad = 'apertura_caja';
        $this->idcolum = 'id';
    }

    function getCajaAbiertaUsuario() {
        
        $usuario = $_SESSION['login'];
        
        $aperturaCaja = $this->setParams(array('select' => array('a.id, a.fecha_apertura'), 'singleResult' => true,
                                                'alias' => 'a',
                                                'joins' => array(array(
                                                    'schema' => 'erpmini',
                                                    'alias' => 'b',
                                                    'table' => 'a_usuario')), 
                                                'filters' => array(" and estado_caja_id = 1 and b.user = '{$usuario}'")))
                                                    ->findEntities();
        
        return $aperturaCaja;
    }

}
