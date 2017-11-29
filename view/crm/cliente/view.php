<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Lista de Contactos</h3>
    </div>
</div>

<button type="button" class="btn btn-info btn-circle" onclick="addCliente()" ><i class="fa fa-plus-circle"></i>
</button>

<div>
    <table id="tableCliente"  width="100%" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>id</th>
                <th>tipo_documento_id</th>
                <th>documento</th>
                <th>esproveedor</th>
                <th>nombres</th>
                <th>apellidos</th>
                <th>apelatico</th>
                <th>fecha_nacimiento</th>
                <th>pais</th>
                <th>ciudad</th>
                <th>direccion</th>
                <th>telefonos</th>
                <th>correos_electronicos</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="cliente_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="cliente_modal_cerrar_button">&times;</button>
                <h4 class="modal-title">Crear/Editar cliente</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form role="form" id="cliente_form">
                                            <div class="form-group">
                                                <label>Id:</label>
                                                <input class="form-control" name="id" id="cliente_id">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Tipo documento:</label>
                                                <input class="form-control" name="tipo_documento_id">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Documento:</label>
                                                <input class="form-control" name="documento">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Es proveedor:</label>
                                                <input class="form-control" name="esproveedor">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Nombre:</label>
                                                <input class="form-control" name="nombre">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Apelativo:</label>
                                                <input class="form-control" name="apelativo">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de nacimiento:</label>
                                                <input class="form-control" name="fecha_nacimiento">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Pais:</label>
                                                <input class="form-control" name="pais_id">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Ciudad:</label>
                                                <input class="form-control" name="ciudad_id">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Direccion:</label>
                                                <input class="form-control" name="direccion">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Telefonos:</label>
                                                <input class="form-control" name="telefonos">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Correos:</label>
                                                <input class="form-control" name="correos_electronicos">
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
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveCliente()">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>

    </div>
</div>