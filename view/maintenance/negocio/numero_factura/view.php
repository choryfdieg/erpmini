<h3>Lista de la entidad Numero_factura</h3>
<button type='button' class='btn btn-primary' onclick='nuevoNumero_factura()'>Nuevo</button><div>
   <table id="mTableNumero_factura"  width="100%" class="table table-striped table-bordered table-hover">
       <thead>
           <tr>
                <th>id</th>
                <th>caja_sucursal_id</th>
                <th>prefijo</th>
                <th>numero_inicial</th>
                <th>numero_final</th>
                <th>numero_actual</th>
                <th>texto_numeracion</th>
                <th>texto_resolucion</th>
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
									<form role='form' id='numero_factura_form'>
										<div class='form-group'>
											<label>id:</label>
											<input class='form-control' name='id' id='numero_factura_id'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>caja_sucursal_id:</label>
											<input class='form-control' name='caja_sucursal_id' id='numero_factura_caja_sucursal_id'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>prefijo:</label>
											<input class='form-control' name='prefijo' id='numero_factura_prefijo'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>numero_inicial:</label>
											<input class='form-control' name='numero_inicial' id='numero_factura_numero_inicial'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>numero_final:</label>
											<input class='form-control' name='numero_final' id='numero_factura_numero_final'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>numero_actual:</label>
											<input class='form-control' name='numero_actual' id='numero_factura_numero_actual'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>texto_numeracion:</label>
											<input class='form-control' name='texto_numeracion' id='numero_factura_texto_numeracion'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>texto_resolucion:</label>
											<input class='form-control' name='texto_resolucion' id='numero_factura_texto_resolucion'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_usuario:</label>
											<input class='form-control' name='a_usuario' id='numero_factura_a_usuario'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_ip:</label>
											<input class='form-control' name='a_ip' id='numero_factura_a_ip'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_fecha:</label>
											<input class='form-control' name='a_fecha' id='numero_factura_a_fecha'>
											<p class='help-block'></p>
										</div>                                        
										<div class='form-group'>
											<label>a_estado_id:</label>
											<input class='form-control' name='a_estado_id' id='numero_factura_a_estado_id'>
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
		<button type='button' class='btn btn-primary' data-dismiss='modal' onclick='guardarNumero_factura()'>Guardar</button>
		<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
	  </div>
	</div>
  </div>
</div>