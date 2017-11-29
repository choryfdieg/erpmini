<button type="button" class="btn btn-info btn-circle" onclick="nuevoImpuesto()" ><i class="fa fa-plus-circle"></i>
</button>

<div>
   <table id="tableImpuesto"  width="100%" class="table table-striped table-bordered table-hover">
       <thead>
           <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Porcentaje</th>
                <th>Cuenta debito</th>
                <th>Cuenta credito</th>
           </tr>
       </thead>
   </table>
</div>

<!-- Modal -->
<div class="modal fade" id="impuesto_modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" id="impuesto_modal_cerrar_button">&times;</button>
        <h4 class="modal-title">Crear/Editar impuesto</h4>
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
                                    <form role="form" id="impuesto_form">
                                        <div class="form-group">
                                            <label>Id:</label>
                                            <input class="form-control" name="id" id="impuesto_id">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre:</label>
                                            <input class="form-control" name="nombre">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Porcentaje:</label>
                                            <input class="form-control" name="porcentaje_impuesto">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Cuenta debito:</label>
                                            <input class="form-control" name="puc_debito_id">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Cuenta credito:</label>
                                            <input class="form-control" name="puc_credito_id">
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardarImpuesto()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>