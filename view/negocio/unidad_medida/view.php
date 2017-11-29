<button type="button" class="btn btn-info btn-circle" onclick="nuevaUnidad_medida()" ><i class="fa fa-plus-circle"></i>
</button>

<div>
   <table id="tableUnidad_medida"  width="100%" class="table table-striped table-bordered table-hover">
       <thead>
           <tr>
                <th>Id</th>
                <th>Clasificacion</th>
                <th>Simbolo</th>
                <th>Descripcion</th>
           </tr>
       </thead>
   </table>
</div>

<!-- Modal -->
<div class="modal fade" id="unidad_medida_modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" id="unidad_medida_modal_cerrar_button">&times;</button>
        <h4 class="modal-title">Crear/Editar unidades de medida</h4>
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
                                    <form role="form" id="unidad_medida_form" action="index.php/maintenance/mA_estado/guardar" method="POST">
                                        <div class="form-group">
                                            <label>Id:</label>
                                            <input class="form-control" name="id" id="unidad_medida_id">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Clasificacion:</label>
                                            <br/>
                                            <select class="form-control" name="grupo_unidad_medida_id" id="grupo_unidad_medida_id">
                                            </select>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Simbolo:</label>
                                            <input class="form-control" name="simbolo">
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardarUnidad_medida()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>