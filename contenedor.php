<?php       
        include('model/ContenedorModel.php');
        $contenedor = new ContenedorModel();        
        
        $menuUrl = $contenedor->modulo . '/' . $contenedor->control;
        
        include('view/ContenedorView.php');