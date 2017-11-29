<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExampleControl
 *
 * @author cirsisdfg
 */

include 'work/httpful.phar';

class ExampleControl {
    
    public function iniciar(){        
        include_once 'view/moduleExample/example/example.php';
    }
    
    public function listar(){        
    
        $uri = 'http://adminitest.phptest.comfamiliar.com/controlAjax.php/compras/Tbpedido/getApi';
        
        $response = \Httpful\Request::get($uri)->expectsJson()->send();
        
        var_dump($response->body->nombre);
        
//        include_once 'view/moduleExample/example/example.php';
    }
    
}
