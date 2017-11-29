<div class="well well-sm well-border-no-color">
    <h4>Tarifas</h4>
    <p id="tarifa_mensaje"></p>
</div>

<form role="form" id="tarifa_form">
    <input class="form-control" name="tarifa[id]" id="tarifa_id" type="hidden">
    <input name="tarifa[producto_id]" id="producto_id" type="hidden" value="<?php echo $producto->id?>">
    
    <div class="row">
        <div class="form-group col-md-3">
            <label>Unidad de Medida:</label><br/>
            <select class="form-control unidad_medida_id" name="tarifa[unidad_medida_id]" id="unidad_medida_id_select">
            </select>
            <p class="help-block"></p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Costo inicial:</label>
            <input class="form-control" name="tarifa[costo_unitario]" id="costo_unitario">
            <p class="help-block"></p>
        </div>
        <div class="form-group col-md-3">
            <label>Valor de venta:</label>
            <input class="form-control" name="tarifa[valor_unitario]" id="valor_unitario">
            <p class="help-block"></p>
        </div>
        
    </div>

    <div id="tarifa_kardex_div">                
        <div class="item_kardex" style="display: none">
            <input type="hidden" class="form-control id">
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Sucursal:</label><br/>
                    <select class="form-control sucursal_id" id="sucursal_id_select">
                    </select>
                    <p class="help-block"></p>
                </div>
                <div class="form-group col-md-3">
                    <label>Cantidad inicial:</label>
                    <input class="form-control cantidad">
                    <p class="help-block"></p>
                </div>
                <button type="button" class="btn btn-info" onclick="removeItemKardex(this)" id="remove_item_kardex_button">
                    <i class="fa fa-times-circle"></i>
                </button>
           </div>
        </div>    
    </div>
    <button type="button" class="btn btn-info" onclick="addItemKardex()" >Agregar sucursal</button>
</form>
    
<div>    
    <div>
       <table id="tableTarifa"  width="100%" class="table table-striped table-bordered table-hover">
           <thead>
               <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Impuesto</th>
               </tr>
           </thead>
       </table>
    </div>
</div>

<br/>
<br/>

<button type="button" class="btn btn-info" data-dismiss="modal" onclick="nuevaTarifa()">Nueva tarifa</button>    
<button type="button" class="btn btn-primary" data-dismiss="modal" id="guardar_tarifa_button">Guardar</button>    