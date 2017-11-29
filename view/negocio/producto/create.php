<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Productos</h3>
    </div>
</div>

<div class="panel panel-default panel-no-border">
    <div class="panel-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#producto" data-toggle="tab">Producto</a>                
            </li>
            <li><a href="#tarifas" data-toggle="tab">Tarifas</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="producto">
                <?php include_once 'view/negocio/producto/producto.php';?>
            </div>
            <div class="tab-pane fade" id="tarifas">                
                <?php include_once 'view/negocio/producto/tarifas.php';?>
            </div>            
        </div>
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->

