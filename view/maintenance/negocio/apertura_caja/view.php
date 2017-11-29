<h3>Lista de la entidad Apertura_caja</h3>
<button type='button' class='btn btn-primary' onclick='nuevoApertura_caja()'>Nuevo</button><div>
   <table id="mTableApertura_caja"  width="100%" class="table table-striped table-bordered table-hover">
       <thead>
           <tr>
                <th>id</th>
                <th>caja_sucursal_id</th>
                <th>fecha_apertura</th>
                <th>fecha_cierre</th>
                <th>estado_caja_id</th>
                <th>a_usuario</th>
                <th>a_ip</th>
                <th>a_fecha</th>
                <th>a_estado_id</th>
           </tr>
       </thead>
   </table>
</div>

<!-- Modal -->
<div class='modal fade' id='apertura_caja_modal' role='dialog'>
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
									<form role='form' id='apertura_caja_form'>
										<div class='form-group'>
											<label>id:</label>
											<input class='form-control' name='id' id='apertura_caja_id'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>caja_sucursal_id:</label>
											<input class='form-control' name='caja_sucursal_id' id='apertura_caja_caja_sucursal_id'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>fecha_apertura:</label>
											<input class='form-control' name='fecha_apertura' id='apertura_caja_fecha_apertura'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>fecha_cierre:</label>
											<input class='form-control' name='fecha_cierre' id='apertura_caja_fecha_cierre'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>estado_caja_id:</label>
											<input class='form-control' name='estado_caja_id' id='apertura_caja_estado_caja_id'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_usuario:</label>
											<input class='form-control' name='a_usuario' id='apertura_caja_a_usuario'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_ip:</label>
											<input class='form-control' name='a_ip' id='apertura_caja_a_ip'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_fecha:</label>
											<input class='form-control' name='a_fecha' id='apertura_caja_a_fecha'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_estado_id:</label>
											<input class='form-control' name='a_estado_id' id='apertura_caja_a_estado_id'>
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
		<button type='button' class='btn btn-primary' data-dismiss='modal' onclick='guardarApertura_caja()'>Guardar</button>
		<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
	  </div>
	</div>
  </div>
</div>