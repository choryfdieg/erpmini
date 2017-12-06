<a class="btn btn-primary pull-right" href="index.php/negocio/sucursal/create" >Nueva sucursal</a>

<div>
   <table id="tableSucursal"  width="100%" class="table table-striped table-bordered table-hover">
       <thead>
           <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Centro de costo</th>
                <th>Acciones</th>
           </tr>
       </thead>
   </table>
</div>

<!-- Modal -->
<div class="modal fade" id="sucursal_modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" id="sucursal_modal_cerrar_button">&times;</button>
        <h4 class="modal-title">Crear/Editar sucursal</h4>
      </div>
      <div class="modal-body">
          <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
<!--                        <div class="panel-heading">
                            
                        </div>-->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="sucursal_form" action="index.php/maintenance/mA_estado/guardar" method="POST">
                                        <div class="form-group">
                                            <label>Id:</label>
                                            <input class="form-control" name="id" id="sucursal_id">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre:</label>
                                            <input class="form-control" name="nombre">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Centro de costo:</label>
                                            <input class="form-control" name="centro_costo_id">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Descripcion:</label>
                                            <input class="form-control" name="descripcion">
                                            <p class="help-block"></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardarSucursal()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>