<h3><i class="fa fa-angle-right"></i> Factura de venta</h3>

<form id="factura_form" class="form-horizontal style-form">
    
    <input id="factura_id" type="hidden" name="factura[id]" readonly="true" value="<?php echo $factura->id?>"/>
    
    <div class="form-panel">
        
        <h5 class="mb"><i class="fa fa-angle-right"></i> <?php echo ($factura->id > 0)? 'Editar factura de venta' : 'Crear factura de venta'?></h5>

        <div class="row mt">
            <div class="col-lg-6">


                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Numero de factura</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" readonly="true" value="<?php echo $factura->prefijo . '-' . $factura->numero?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Cliente</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="terceros_factura_select" name="factura[tercero_id]">
                            <option value=""></option>
                            <?php foreach ($this->tercerosForSelect() as $tercero) : ?>
                                <option value="<?php echo $tercero->getId() ?>"
                                        <?php echo ($factura->tercero_id == $tercero->getId()) ? 'selected' : ''?>>
                                    <?php echo $tercero->getNombre() . ' (' . $tercero->getDocumento() . ')' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Observacion</label>
                    <div class="col-sm-10">
                        <textarea rows="3" class="form-control" name="factura[observacion]"><?php echo $factura->observacion?></textarea>
                        <p class="help-block">(Visible en la factura de venta)</p>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Notas adcionales</label>
                    <div class="col-sm-10">
                        <textarea rows="3" class="form-control" name="factura[nota]"><?php echo $factura->nota?></textarea>
                        <p class="help-block">(No visible en la factura de venta)</p>
                    </div>
                </div>

            </div>
            
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Fecha de generacion</label>
                    <div class='input-group date col-sm-10 input-date' id='datetimepicker1'>
                        <input type='text' class="form-control" value="<?php echo $factura->fechaGeneracion?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>                                        
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Sucursal</label>
                    <div class="col-sm-10">
                        <span>Nombre de la sucursal</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Plazo</label>
                    <div class="col-sm-10">
                        <span>De contado</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Fecha de vencimiento</label>
                    <div class="col-sm-10">
                        <span>Fecha</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Asesor</label>
                    <div class="col-sm-10">
                        <span>Lista de asesores</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-panel">

        <h5 class="mb"><i class="fa fa-angle-right"></i> Items de la factura</h5>
        
        <div class="row mt">
            <div class="col-lg-12">

                <table id="factura_producto_table" class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th><i class="fa fa-bullhorn"></i> Item</th>
                            <th>Impuesto</th>
                            <th>Valor Unit.</th>
                            <th>Cantidad</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="display: none">
                            <input type="hidden" class="item_id"/>
                            <input type="hidden" class="porcentaje_impuesto"/>
                            <td>
                                <select class="item">                        
                                </select>
                            </td>
                            <td><span value="" class="impuesto"></span></td>
                            <td><input type="number" min="1" readonly value="" class="valor_unitario"/></td>
                            <td><input type="number" min="1" value="" class="cantidad"/></td>
                            <td><input type="number" min="0" value="" class="descuento"/></td>
                            <td><span class="total_row">0</span></td>
                            <td>
                                <button class="btn btn-danger btn-xs" onclick="removeItemTable(this)"><i class="fa fa-trash-o "></i></button>
                            </td>
                        </tr>            
                    </tbody>
                </table>
                <div class="col-sm-6 col-xs-6">
                    <a href="javascript:;" onclick="addItemFacturaProductosTable()"><i class="fa fa-plus-circle"></i> Agregar item a la factura</a>
                </div>                    
            </div>
        </div>
    </div>

    <div class="form-panel">

        <h5 class="mb"><i class="fa fa-angle-right"></i> Formas de pago</h5>
        
        <div class="row mt">
            <div class="col-lg-12">

                <table id="factura_forma_pago_table" class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th><i class="fa fa-bullhorn"></i> Forma de pago</th>
                            <th>Valor</th>
                            <th>Referencia</th>
                            <th># Voucher</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="display: none">
                            <input type="hidden" class="forma_id"/>
                            <td>
                                <select class="forma">                        
                                </select>
                            </td>
                            <td><input type="number" min="1" value="" class="valor text-right"/></td>
                            <td><input value="" class="referencia"/></td>
                            <td><input value="" class="voucher_tarjeta"/></td>
                            <td>
                                <button class="btn btn-danger btn-xs" onclick="removeItemTable(this)"><i class="fa fa-trash-o "></i></button>
                            </td>
                        </tr>            
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><span class="pull-right text-bold">Total: </span></td>
                            <td><span id="total_formas_span" class="text-bold"></td>
                        </tr>
                        <tr>
                            <td><span class="pull-right text-bold">Restante: </span></td>
                            <td><span id="restante_formas_span" class="text-bold"></span></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="col-sm-6 col-xs-6">
                    <a href="javascript:;" onclick="addItemFacturaFormaDePagoTable()"><i class="fa fa-plus-circle"></i> Agregar forma de pago</a>
                </div>                    
            </div>
        </div>
    </div>

    <div class="form-panel">

        <div class="row mt">
            <div class="col-lg-4 pull-right">

                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-right"><strong>Base</strong></td>
                            <td class="text-right" id="factura_base" style="padding-right: 6%">0</td>
                        </tr>
                        <tr>
                            <td class="text-right no-border"><strong>Impuestos</strong></td>
                            <td class="text-right" id="factura_impuestos" style="padding-right: 6%">0</td>
                        </tr>
                        <tr>
                            <td class="text-right no-border"><strong>Subtotal</strong></td>
                            <td class="text-right" id="factura_subtotal" style="padding-right: 6%">0</td>
                        </tr>
                        <tr>
                            <td class="text-right no-border"><strong>Descuentos</strong></td>
                            <td class="text-right" id="factura_descuentos" style="padding-right: 6%">0</td>
                        </tr>
                        <tr>
                            <td class="text-right no-border">
                                <div class="well well-small well-green"><strong>Total</strong></div>
                            </td>
                            <td class="text-right text-bold" ><div class="well well-small"><span id="factura_total"></span></div></td>
                        </tr>
                    </tbody>
                </table>
                
                
            </div>
        </div>
        <div class="row">
            <div style="float: right; margin-right: 1%;">
                <div class="btn-group" style="padding-left: 10px">
                    <a class="" href="index.php/ingresos/Factura/" style="text-decoration: underline !important; font-weight: bold;">Volver</a>
                </div>
                <div class="btn-group" style="padding-left: 10px">
                    <a class="btn btn-default" href="javascript:;" onclick="descartarFactura()">Descartar</a>
                </div>
                <div class="btn-group" style="padding-left: 10px">
                    <a class="btn btn-default" href="index.php/ingresos/Factura/create">Crear nueva</a>
                </div>
                <div class="btn-group" style="padding-left: 10px">
                    <button style="width: 120px" type="button" class="btn btn-primary" onclick="save(false)">Guardar</button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="javascript:;" onclick="save(true)">Guardar e imprimir</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</form>