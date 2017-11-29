<div class="well well-sm well-border-no-color">
    <h4>Producto</h4>
    <p id="producto_mensaje"></p>
</div>
<form role="form" id="producto_form">
    <div class="form-group">
        <label>Id:</label>
        <input class="form-control" name="id" id="producto_id" value="<?php echo $producto->id?>">
        <p class="help-block"></p>
    </div>
    <div class="form-group">
        <label>Nombre:</label>
        <input class="form-control" name="nombre" value="<?php echo $producto->nombre?>">
        <p class="help-block"></p>
    </div>
    <div class="form-group">
        <label>Descripcion:</label>
        <input class="form-control" name="descripcion" value="<?php echo $producto->descripcion?>">
        <p class="help-block"></p>
    </div>
    <div class="form-group">
        <label>Impuesto:</label>
        <select class="form-control" name="impuesto_id" id="impuesto_id_select">
            <?php foreach ($this->getImpuestosForSelect() as $impuesto):?>
                <option value="<?php echo $impuesto->id;?>" <?php echo ($impuesto->id === $producto->impuesto_id) ? 'selected' : '';?>><?php echo $impuesto->nombre;?></option>                    
            <?php endforeach;?>
        </select>
        <p class="help-block"></p>
    </div>
    <div class="form-group">
        <label>Cuenta credito:</label>
        <input class="form-control" name="puc_credito_id" value="<?php echo $producto->puc_credito_id?>">
        <p class="help-block"></p>
    </div>
    <div class="form-group">
        <label>Cuenta debito:</label>
        <input class="form-control" name="puc_debito_id" value="<?php echo $producto->puc_debito_id?>">
        <p class="help-block"></p>
    </div>
    <div class="form-group">
        <label>Cuenta cartera:</label>
        <input class="form-control" name="puc_cartera_id" value="<?php echo $producto->puc_cartera_id?>">
        <p class="help-block"></p>
    </div>
    
    <br/>
    <br/>
    <div class="pull-right">
    <a href="index.php/negocio/producto/view" class="btn btn-info" role="button">Cancelar</a>
    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardarProducto()">Guardar</button>
    <a href="index.php/negocio/producto/add" class="btn btn-info" role="button">Nuevo producto</a>
    </div>
    
</form>