<?php

    require_once 'model/Ambiente.php';
    require_once 'model/utilidades/Utilidades.php';

    require_once 'model/ContenedorModel.php';
    
    $contenedor = new ContenedorModel();
    $contenedor->ejecutarControl();