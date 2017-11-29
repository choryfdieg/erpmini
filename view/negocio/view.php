<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Configuraciones</h3>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#sucursales" data-toggle="tab">Sucursales</a>                
            </li>
            <li><a href="#impuestos" data-toggle="tab">Impuestos</a>
            </li>
            <li><a href="#unidades_medida" data-toggle="tab">Unidades de medida</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="sucursales">
                <h4>Lista de Sucursales</h4>
                <?php include_once 'view/negocio/sucursal/view.php';?>
            </div>
            <div class="tab-pane fade" id="impuestos">
                <h4>Lista de Impuestos</h4>
                <?php include_once 'view/negocio/impuesto/view.php';?>
            </div>
            <div class="tab-pane fade" id="unidades_medida">
                <h4>Lista de Unidades de medida</h4>
                <?php include_once 'view/negocio/unidad_medida/view.php';?>
            </div>
        </div>
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->