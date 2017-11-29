<h3>Lista de la entidad Puc</h3>
<button type='button' class='btn btn-primary' onclick='nuevoPuc()'>Nuevo</button><div>
   <table id="mTablePuc"  width="100%" class="table table-striped table-bordered table-hover">
       <thead>
           <tr>
                <th>id</th>
                <th>compania_id</th>
                <th>centro_costo_id</th>
                <th>tipo_cuenta_id</th>
                <th>nombre</th>
                <th>descripcion</th>
                <th>cuenta_objecto</th>
                <th>sub_cuenta</th>
                <th>cuenta_detalle</th>
                <th>a_usuario</th>
                <th>a_ip</th>
                <th>a_fecha</th>
                <th>a_estado_id</th>
           </tr>
       </thead>
   </table>
</div>

<!-- Modal -->
<div class='modal fade' id='myModal' role='dialog'>
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
									<form role='form' id='puc_form'>
										<div class='form-group'>
											<label>id:</label>
											<input class='form-control' name='id' id='puc_id'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>compania_id:</label>
											<input class='form-control' name='compania_id' id='puc_compania_id'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>centro_costo_id:</label>
											<input class='form-control' name='centro_costo_id' id='puc_centro_costo_id'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>tipo_cuenta_id:</label>
											<input class='form-control' name='tipo_cuenta_id' id='puc_tipo_cuenta_id'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>nombre:</label>
											<input class='form-control' name='nombre' id='puc_nombre'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>descripcion:</label>
											<input class='form-control' name='descripcion' id='puc_descripcion'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>cuenta_objecto:</label>
											<input class='form-control' name='cuenta_objecto' id='puc_cuenta_objecto'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>sub_cuenta:</label>
											<input class='form-control' name='sub_cuenta' id='puc_sub_cuenta'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>cuenta_detalle:</label>
											<input class='form-control' name='cuenta_detalle' id='puc_cuenta_detalle'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_usuario:</label>
											<input class='form-control' name='a_usuario' id='puc_a_usuario'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_ip:</label>
											<input class='form-control' name='a_ip' id='puc_a_ip'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_fecha:</label>
											<input class='form-control' name='a_fecha' id='puc_a_fecha'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_estado_id:</label>
											<input class='form-control' name='a_estado_id' id='puc_a_estado_id'>
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
		<button type='button' class='btn btn-primary' data-dismiss='modal' onclick='guardarPuc()'>Guardar</button>
		<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
	  </div>
	</div>
  </div>
</div>