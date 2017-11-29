<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pojo
 *
 * @author jduque
 */
class Pojo {
    
    function Pojo($fieldsValues = array(), $forceKey = false){        
        foreach($fieldsValues as $key=>$value){
            //para que funcione tambien en 400 porque saca los campos en mayúscula
            
            if($forceKey){
                $key = "pojo_".strtolower ($key);
            }
            
            if(stripos($key, "pojo_") === 0){
                $key        = lcfirst(preg_replace('/^pojo_/i', '', strtolower($key)));
                $this->$key = utf8_encode($value);
            }
        }  
    }
    
    public function __call($method, $args){
        if(strpos($method, "get") === 0){
            $method = lcfirst(preg_replace("/^get/", "", $method));
            if (isset($this->$method)) {
                return $this->$method;
            }
        }elseif(strpos($method, "set") === 0){
            $method = lcfirst(preg_replace("/^set/", "", $method));
            if (isset($this->$method)) {
                $this->$method = (isset ($args[0])) ? $args[0] : NULL;
            }
        }
    }    
}