<h3><i class="fa fa-angle-right"></i> Apertura de caja</h3>

<form role='form' id='apertura_caja_form' class="form-horizontal style-form">
    
    <input id="apertura_caja_id" type="hidden" name="id" readonly="true" value=""/>
    <input type="hidden" name="estado_caja_id" readonly="true" value="1"/>
    
    <div class="form-panel">
        
        <div class="row mt">
            <div class="col-lg-6">
    
                <div class='form-group'>
                        <label>sucursal:</label>
                        <div class='input-group' id='datetimepicker1'>
                            <select id="sucursal_select"></select>
                        </div>
                        <p class='help-block'></p>
                        
                </div>                                        
                
                <div class='form-group'>
                        <label>caja_sucursal_id:</label>
                        <input class='form-control' name='caja_sucursal_id'>
                        <p class='help-block'></p>
                </div>                                        
                <div class="form-group">
                    <label>Fecha de apertura</label>
                    <div class='input-group date input-date pd_l_0 pd_r_0' id='datetimepicker1'>
                        <input type='text' class="form-control" name="fecha_apertura" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>                                        
                </div>

                
                <div class="pull-right row">
                    <a class="btn btn-primary" href="javascript:;" onclick="guardarApertura_caja()">Abrir caja</a>
                </div>
                    
                
            </div>
            
        </div>
        
    </div>
    
</form>