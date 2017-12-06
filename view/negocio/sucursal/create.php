<h3><i class="fa fa-angle-right"></i> Sucursal</h3>

<form role="form" id="sucursal_form" class="form-horizontal style-form">
    <input type="hidden" name="id" id="sucursal_id" value="<?php echo $sucursal->id ?>"/>

    <div class="form-panel">

        <div class="form-group">
            <label>Nombre:</label>
            <input class="form-control" name="nombre" value="<?php echo $sucursal->nombre ?>"/>
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label>Centro de costo:</label>
            <input class="form-control" name="centro_costo_id" value="<?php echo $sucursal->centro_costo_id ?>"/>
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label>Descripcion:</label>
            <input class="form-control" name="descripcion" value="<?php echo $sucursal->descripcion ?>"/>
            <p class="help-block"></p>
        </div>

        
    </div>
    
    <?php if($sucursal->id > 0):?>
    <div class="form-panel">
        
        <h5 class="mb"><i class="fa fa-angle-right"></i> Cajas de la sucursal</h5>
        
        <div class="row mt">
            <div class="col-sm-6 col-xs-6">
                <a href="javascript:;" onclick="nuevoCaja_sucursal()"><i class="fa fa-plus-circle"></i> Agregar caja</a>
            </div>
        </div>
        <div class="row mt">
            <div class="col-lg-12">
        
        
                <table id="tableCaja_sucursal"  width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>id</th>
                             <th>sucursal_id</th>
                             <th>numero</th>
                             <th>nombre</th>
                             <th>prefijo</th>
                             <th>numero_inicial</th>
                             <th>numero_final</th>
                             <th>numero_actual</th>                     
                             <th>acciones</th>                     
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <?php endif;?>
    
    <div class="form-panel">
        <div class="row mt">
            <div class="col-lg-2 pull-right">
                <a class="btn btn-primary" href="index.php/negocio/negocio/">Cancelar</a>
                <button type="button" class="btn btn-primary" onclick="guardarSucursal()">Guardar</button>
            </div>
        </div>
    </div>

</form>


<!-- Modal -->
<div class='modal fade' id='caja_sucursal_modal' role='dialog'>
    <div class='modal-dialog'>
        <!-- Modal content-->
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title'>Crear/Editar</h4>
            </div>
            <div class='modal-body'>
                <div class='row'>
                    <div class='col-lg-12'>
                        <div class='panel panel-default'>
                            <!--                        <div class='panel-heading'>
                                                                                    
                                                                            </div>-->
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <form role='form' id='caja_sucursal_form'>
                                            <div class='form-group'>
                                                <label>id:</label>
                                                <input class='form-control' name='id' id='caja_sucursal_id'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                            <div class='form-group'>
                                                <label>sucursal_id:</label>
                                                <input class='form-control' name='sucursal_id' id='caja_sucursal_sucursal_id'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                            <div class='form-group'>
                                                <label>numero:</label>
                                                <input class='form-control' name='numero' id='caja_sucursal_numero'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                            <div class='form-group'>
                                                <label>nombre:</label>
                                                <input class='form-control' name='nombre' id='caja_sucursal_nombre'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                            <div class='form-group'>
                                                <label>prefijo:</label>
                                                <input class='form-control' name='prefijo' id='caja_sucursal_prefijo'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                            <div class='form-group'>
                                                <label>numero_inicial:</label>
                                                <input class='form-control' name='numero_inicial' id='caja_sucursal_numero_inicial'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                            <div class='form-group'>
                                                <label>numero_final:</label>
                                                <input class='form-control' name='numero_final' id='caja_sucursal_numero_final'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                            <div class='form-group'>
                                                <label>numero_actual:</label>
                                                <input class='form-control' name='numero_actual' id='caja_sucursal_numero_actual'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                            <div class='form-group'>
                                                <label>texto_numeracion:</label>
                                                <input class='form-control' name='texto_numeracion' id='caja_sucursal_texto_numeracion'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                            <div class='form-group'>
                                                <label>texto_resolucion:</label>
                                                <input class='form-control' name='texto_resolucion' id='caja_sucursal_texto_resolucion'>
                                                <p class='help-block'></p>
                                            </div>                                                                                                                         
                                            <div class='form-group'>
                                                <label>a_estado_id:</label>
                                                <input class='form-control' name='a_estado_id' id='caja_sucursal_a_estado_id'>
                                                <p class='help-block'></p>
                                            </div>                                        
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-primary' data-dismiss='modal' onclick='guardarCaja_sucursal()'>Guardar</button>
                <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
            </div>
        </div>
    </div>
</div>