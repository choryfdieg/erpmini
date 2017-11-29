<!DOCTYPE html>
<html>
    
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <base href="<?php echo Utilidades::getApplicationUrl();?>"/>
        
        <link type="text/css"  href="resources/css/erpmini.css" rel="stylesheet">
        
        <!-- Bootstrap Core CSS -->
        <link type="text/css"  href="resources/bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link type="text/css" href="resources/bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link type="text/css" href="resources/bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        
        <!-- MetisMenu CSS -->
        <link type="text/css" href="resources/bootstrap/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
        
        <?php $contenedor->getCssModulo();?>
    </head>
    
    <body>       
        
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo Utilidades::getBaseUrl()?>">SB Admin v2.0</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">                    
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="index.php/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">                            
                            <li>
                                <a href="index.php"><i class="fa fa-table fa-fw"></i> Inicio</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Ingresos<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="index.php/ingresos/Factura/create">Facturar</a>
                                    </li>
                                    <li>
                                        <a href="morris.html">Nota credito</a>
                                    </li>
                                    <li>
                                        <a href="morris.html">Cotizacion</a>
                                    </li>
                                    <li>
                                        <a href="morris.html">Abono</a>
                                    </li>
                                    <li>
                                        <a href="index.php/ingresos/Historial/view">Historial</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="tables.html"><i class="fa fa-table fa-fw"></i> Gastos</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Inventario<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="index.php/negocio/Negocio"><i class="fa fa-edit fa-fw"></i> Configuracion</a>
                                    </li>
                                    <li>
                                        <a href="index.php/negocio/Producto/view"><i class="fa fa-edit fa-fw"></i> Productos</a>
                                    </li>
                                </ul>
                            </li>                            
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Contactos<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="index.php/crm/cliente/view"><i class="fa fa-edit fa-fw"></i> Clientes</a>
                                    </li>
                                </ul>
                            </li>                            
                            <li>
                                <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Reportes</a>
                            </li>
                            <li>
                                <a href="index.php/builder/WorkEntityBuilder"><i class="fa fa-edit fa-fw"></i> Sistema</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <?php if($contenedor->isAutenticado()){?>

                        <?php $contenedor->cuerpo(); ?>                       

                    <?php }?>
                </div>
            </div>
            <!-- /#page-wrapper -->

        </div>

        
        <!-- jQuery -->
        <script src="resources/bootstrap/vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="resources/bootstrap/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="resources/bootstrap/dist/js/sb-admin-2.js"></script>
        
        <!-- Metis Menu Plugin JavaScript -->
        <script src="resources/bootstrap/vendor/metisMenu/metisMenu.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>

        
        <?php $contenedor->getJsModulo();?>

    </body>
    
</html>
