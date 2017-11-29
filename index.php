<?php

    require_once 'model/Ambiente.php';
    require_once 'model/utilidades/Utilidades.php';
    require_once 'work/security/WorkSecurityUI.php';

    include('model/IndexModel.php');
    
    
    $index = new IndexModel();
    
    if(strpos($_SERVER['REQUEST_URI'], 'logout')){
        session_unset();
        session_destroy();
    }
    
    
    // si esta autenticado    
    if(isset($_SESSION["login"])){
        require_once 'contenedor.php';
        return;
    }
    
    // *** Si no esta autenticado
        
    // si requiere una url diferente a index se devuelve a index
    if($_SERVER["REQUEST_URI"] != $_SERVER["SCRIPT_NAME"]){
        header("Location: ".Utilidades::getApplicationUrl()."index.php");
        return;
    }
    
    $mensaje = '';
    
    if($index->login($_POST)){
        require_once 'contenedor.php';
    }else{
        $mensaje = $index->mensaje;
        include_once 'login.html';
    }