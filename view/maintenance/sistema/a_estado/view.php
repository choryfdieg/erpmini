<div class="row">
    <div class="col-lg-12">
        <h3>Lista de la entidad A_estado</h3>
    </div>
</div>

<div>
    <select id="mSelectA_estado">
   </select>
</div>

<div>
   <table id="mTableA_estado"  width="100%" class="table table-striped table-bordered table-hover">
       <thead>
           <tr>
                <th>id</th>
                <th>tabla</th>
                <th>descripcion_corta</th>
                <th>descripcion_larga</th>
           </tr>
       </thead>
   </table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Crear/Editar estado</h4>
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
                                    <form role="form" id="a_estado_form" action="index.php/maintenance/mA_estado/guardar" method="POST">
                                        <div class="form-group">
                                            <label>Id:</label>
                                            <input class="form-control" name="id" id="a_estado_id">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Tabla:</label>
                                            <input class="form-control" name="tabla">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Descripcion corta:</label>
                                            <input class="form-control" name="descripcion_corta">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Descripcion larga:</label>
                                            <input class="form-control" name="descripcion_larga">
                                            <p class="help-block"></p>
                                        </div>
                                        <input type="submit"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardar()">Guardar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="borrar()">Borrar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>