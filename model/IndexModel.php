<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indexModel
 *
 * @author cirsisjgp
 */

class IndexModel {

    public $mensaje = '';
    
    function IndexModel() {
        session_start();        
    }

    function login($request) {

        if(!isset($request['ingresar'])){
            return false;
        }
        
        if($request['login'] == 'dfgarcia' && $request['password'] == '123'){            
            $_SESSION['login'] = $request['login'];
            
            return true;
        }
        
        $this->mensaje = 'Usuario o contraseña incorrectos';
        
        return false;        
        
    }        
    
}

?>
