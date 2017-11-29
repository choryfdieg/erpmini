<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Inspection
 *
 * @author cirsisdfg
 */
abstract class Inspection {
    
    protected $a_usuario;
    protected $a_ip;
    protected $a_fecha;

    function __construct() {        
    }

    
    public function buildInspectionData(){
        $time = time();
        $currentDate = date("Y-m-d H:i:s", $time);
        
        $this->a_usuario = $_SESSION['login'];
        $this->a_ip = $_SERVER['REMOTE_ADDR'];
        $this->a_fecha = $currentDate;
        
    }
    
}
