var baseUrl = $('base').attr('href');

$(document).ready(function(){    
    
    bootbox.dialog({
            message: '<p><i class="fa fa-spin fa-spinner"></i>   Estamos cargando los datos de la factura...</p>',
            closeButton: false,
            className: 'top-30pe'
        });
    
    $(document).ajaxStop(function(){
        bootbox.hideAll();
    });
    
    $('#datetimepicker1').datetimepicker({locale: 'es', format: 'YYYY/MM/DD'});
    
    $("#terceros_factura_select").select2({allowClear: true, width: '50%', 
        placeholder: "Seleccione el cliente"});
    
    loadProductosSelect();    
    loadFormasDePagoSelect();
    
    $(".cantidad").on('change', function(){
        
        var row = $(this).closest('tr');
        
        var valorUnitario = $(row).find('.valor_unitario');
        
        $(row).find('.total_row').html(formatMoneda($(valorUnitario).val() * $(this).val(), true, ''));
    
        uploadSubtotal();
    });
    
    $(".valor_unitario").on('change', function(){
        
        var row = $(this).closest('tr');
        
        var cantidad = $(row).find('.cantidad');
        
        $(row).find('.total_row').html(formatMoneda($(this).val() * $(cantidad).val(), true, ''));
    
        uploadSubtotal();
    });
    
    $(".valor").on('change', function(){
        verificarTotalFormasPago();
    });
    
});

function uploadSubtotal(){
    
    var subtotal = 0;
    
    var productosTr = $("#factura_producto_table tbody tr");
    
    var impuestos = 0;
    var base = 0;
    var subtotal = 0;
    
    $.each(productosTr, function(i, e){
        
        var porcentaje_impuesto = $(e).find('.porcentaje_impuesto').val();
        
        var valor_unitario = $(e).find('.valor_unitario').val();
        var cantidad = $(e).find('.cantidad').val();
        
        var impuesto = 0;
        
        if(porcentaje_impuesto !== undefined && porcentaje_impuesto > 0){
            impuesto += Math.round((parseInt(valor_unitario) * parseInt(porcentaje_impuesto))/(100 + parseInt(porcentaje_impuesto)));
        }
        
        base += (valor_unitario - impuesto) * cantidad;
        
        subtotal += valor_unitario * cantidad;
        
        impuestos += impuesto * cantidad;
        
    });
    
    $("#factura_base").html(formatMoneda(base, true, ''));
    $("#factura_impuestos").html(formatMoneda(impuestos, true, ''));
    $("#factura_subtotal").html(formatMoneda(subtotal, true, ''));
    $("#factura_total").html(formatMoneda(subtotal, true, ''));    
    
    verificarTotalFormasPago();
}

function setOptionData(){
    
    var option = $(this).select2('data')[0].element;    
    
    var data = $(option).data('tarifa');
    
    $($(this).closest("tr").find(".valor_unitario").get(0)).val(0);
    
    $($(this).closest("tr").find(".impuesto").get(0)).html(data.impuesto);
    
    $($(this).closest("tr").find(".porcentaje_impuesto").get(0)).val(data.porcentaje_impuesto);
    
    $($(this).closest("tr").find(".cantidad").get(0)).val(1);
    
    $($(this).closest("tr").find(".total_row").get(0)).html(formatMoneda(data.valorUnitario, true, ''));
    
    uploadSubtotal();
    
}

function validarFactura(){
    
    var validacion = false;
    
    var restante = verificarTotalFormasPago();
    
    if(restante === 0){
        validacion = true;
    }else{
        bootbox.alert({
            title: 'Validación del documento',
            message: '<div class="alert alert-danger"><b>Oh!</b> Todavia restan $' + formatMoneda(restante, true, '') + ' para cubrir el total de la factura. Verifica los valores de las formas de pago.</div>',
            backdrop: true,
            className: 'top-30pe'
        });
        
    }
    
    return validacion;
}

function save(print){
    
    var type = 'post';
    
    if(print){
        if(validarFactura() === false){

            return false;
        }
    }
    
    if($("#factura_id").val() !== ''){
        type = 'put';
    }
    
    $.ajax({url: baseUrl + 'api.php/gastos/comprobante/save', 
            type: type,
            data: $("#factura_form").serialize(),
        success: function (response) {
            
            var data = eval('('+response+')');
            
            
        }
    }).done(function (response){
        
        var data = eval('('+response+')');
        
        if(print){
            printDocument(data.id);
        }
    }).always(function(response){
        
        var data = eval('('+response+')');
        
        if(!print){
            window.location.assign("index.php/gastos/comprobante/edit/id/"+data.id);
        }
    });
}

function printDocument(facturaIdResponse){
    
    var facturaId = $("#factura_id").val();
    
    if(facturaId === ""){
        facturaId = facturaIdResponse;
    }
    
    $.get(baseUrl + 'api.php/gastos/comprobante/imprimirFactura', {'factura_id':facturaId}, 
        function(response){
            
            var data = $.parseJSON(response);
            
            var a = document.createElement("a");
            a.href = 'data:application/pdf;base64,'+data.factura;
            a.download = "factura.pdf"; //update for filename
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);            

        }).done(function(){
            window.location.assign("index.php/gastos/comprobante/edit/id/"+facturaId);
        }).fail(function(){
        });
    
}

function loadProductosSelect(){
    
    var tr = $("#factura_producto_table>tbody tr:first");
    
    var select = $(tr).find('.item');
    
    $.get(baseUrl + 'api.php/gastos/comprobante/productos', {}, 
        function(response){
            
            var productos = eval('('+response+')');
            
            var option = $('<option>', {
                    value: '',
                    text: ''
                });
                
            option.data('tarifa', {valorUnitario: '', impuesto: ''});
                
            $(select).append(option);
            
            $.each(productos, function(i, e){
                
                option = $('<option>', {
                    value: e.id,
                    text: '<div><span style="display:none;">'+e.id+'</span><strong>'+e.producto+' ('+e.unidad_medida+')</strong></div>'
                });
                
                option.data('tarifa', {tarifaId: e.id, valorUnitario: 0, 
                                        impuesto: e.impuesto, porcentaje_impuesto: e.porcentaje_impuesto,
                                        existencias: e.existencias});
                
                $(select).append(option);
            });
            
            
        }).done(function(){
            loadFacturaProductosTable();
        }).fail(function(){
        });
}

function removeItemTable(element){
    $(element).closest('tr').remove();
    uploadSubtotal();
}

function addItemFacturaProductosTable(){
    
    var tr = $("#factura_producto_table>tbody tr:first");
    
    var trCount = $("#factura_producto_table>tbody tr").length;
    
    var index = trCount - 1;
    
    var newTr = tr.clone(true);
                
    // *** input item_id
    var itemId = $(newTr).find('.item_id').get(0);                
    $(itemId).attr('name', 'factura_producto['+index+'][id]');
    // *** end input
    
    // *** select productos
    var item = $(newTr).find('.item').get(0);                

    $(item).attr('name', 'factura_producto['+index+'][tarifa_id]');

    $(item).select2({allowClear: true, width: '50%', 
        placeholder: "Seleccione algun item",
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); }
    });

    $(item).on("change", setOptionData);                
    // *** end select
    
    // *** input valor unitario
    var valorUnitario = $(newTr).find('.valor_unitario').get(0);
    $(valorUnitario).attr('name', 'factura_producto['+index+'][valor_unitario]');
    // *** end input

    // *** input cantidad
    var cantidad = $(newTr).find('.cantidad').get(0);                
    $(cantidad).attr('name', 'factura_producto['+index+'][cantidad]');
    // *** end input
    // 

    $(newTr).show();

    $("#factura_producto_table").append(newTr);
}

function loadFacturaProductosTable(){
    
    var tr = $("#factura_producto_table>tbody tr:first");
    
    $.get(baseUrl + 'api.php/gastos/comprobante/facturaProductos', {factura_id: $("#factura_id").val()}, 
        function(response){
            
            var facturaProductos = eval('('+response+')');
            
            var trCount = $("#factura_producto_table>tbody tr").length;
    
            var index = trCount - 1;
            
            $.each(facturaProductos, function(i, e){
                
                var newTr = tr.clone(true);
                
                // *** input item_id
                var itemId = $(newTr).find('.item_id').get(0);
                $(itemId).attr('name', 'factura_producto['+index+'][id]');
                $(itemId).val(e.id);
                // *** end input
                
                // *** select productos
                var item = $(newTr).find('.item').get(0);                
                
                $(item).attr('name', 'factura_producto['+index+'][tarifa_id]');
                
                $(item).select2({allowClear: true, width: '50%', 
                    placeholder: "Seleccione algun item",
                    templateResult: function (d) { return $(d.text); },
                    templateSelection: function (d) { return $(d.text); }
                });
                
                $(item).select2('val', e.tarifa_id);
                
                $(item).on("change", setOptionData);                
                // *** end select
                
                // *** input valor unitario
                var valorUnitario = $(newTr).find('.valor_unitario').get(0);
                $(valorUnitario).attr('name', 'factura_producto['+index+'][valor_unitario]');
                $(valorUnitario).val(e.valor_unitario);                
                // *** end input
                
                // *** input impuesto
                var impuesto = $(newTr).find('.impuesto').get(0);
                $(impuesto).html(e.impuesto);
                // *** end input
                // 
                // *** input % impuesto
                var porcentajeImpuesto = $(newTr).find('.porcentaje_impuesto').get(0);
                $(porcentajeImpuesto).val(e.porcentaje_impuesto);
                // *** end input
                
                // *** input cantidad
                var cantidad = $(newTr).find('.cantidad').get(0);                
                $(cantidad).attr('name', 'factura_producto['+index+'][cantidad]');
                $(cantidad).val(e.cantidad);
                // *** end input
                // 
                // *** input total
                var totalRow = $(newTr).find('.total_row').get(0);                
                $(totalRow).html(formatMoneda(e.valor_total, true, ''));
                // *** end input
                
                $(newTr).show();
                
                $("#factura_producto_table").append(newTr);
                
                index += 1;
                
            });
            
            
        }).done(function(){
            uploadSubtotal();
        }).always(function(){
            addItemFacturaProductosTable();
        }).fail(function(){
        });
}

function loadFormasDePagoSelect(){
    
    var tr = $("#factura_forma_pago_table>tbody tr:first");
    
    var select = $(tr).find('.forma');
    
    $.get(baseUrl + 'api.php/gastos/comprobante/formasDePago', {}, 
        function(response){
            
            var productos = eval('('+response+')');
            
            var option = $('<option>', {
                    value: '',
                    text: ''
                });
                
            $(select).append(option);
                
            $.each(productos, function(i, e){
                
                option = $('<option>', {
                    value: e.id,
                    text: e.nombre
                });
                
                $(select).append(option);
            });
            
            
        }).done(function(){
            loadFacturaFormaDePagoTable();
        }).fail(function(){
        });
}

function loadFacturaFormaDePagoTable(){
    
    var tr = $("#factura_forma_pago_table>tbody tr:first");
    
    $.get(baseUrl + 'api.php/gastos/comprobante/facturaFormasDePago', {factura_id: $("#factura_id").val()}, 
        function(response){
            
            var facturaFormasDePago = eval('('+response+')');
            
            var trCount = $("#factura_forma_pago_table>tbody tr").length;
    
            var index = trCount - 1;
            
            $.each(facturaFormasDePago, function(i, e){
                
                var newTr = tr.clone(true);
                
                $(newTr).addClass('factura_formas_pago');
                
                // *** input item_id
                var formaId = $(newTr).find('.forma_id').get(0);
                $(formaId).attr('name', 'factura_forma_pago['+index+'][id]');
                $(formaId).val(e.id);
                // *** end input
                
                // *** select productos
                var forma = $(newTr).find('.forma').get(0);                
                
                $(forma).attr('name', 'factura_forma_pago['+index+'][forma_pago_id]');
                
                $(forma).select2({allowClear: true, width: '50%', 
                    placeholder: "Seleccione alguna forma de pago"});
                
                $(forma).select2('val', e.forma_pago_id);                
                // *** end select
                
                // *** input valor
                var valor = $(newTr).find('.valor').get(0);
                $(valor).attr('name', 'factura_forma_pago['+index+'][valor]');
                $(valor).val(e.valor);                
                // *** end input
                
                // *** input referencia
                var referencia = $(newTr).find('.referencia').get(0);
                $(referencia).attr('name', 'factura_forma_pago['+index+'][referencia]');
                $(referencia).val(e.referencia);
                // *** end input
                
                // *** input voucher_tarjeta
                var voucherTarjeta = $(newTr).find('.voucher_tarjeta').get(0);
                $(voucherTarjeta).attr('name', 'factura_forma_pago['+index+'][voucher_tarjeta]');
                $(voucherTarjeta).val(e.voucher_tarjeta);
                // *** end input
                
                $(newTr).show();
                
                $("#factura_forma_pago_table").append(newTr);
                
                index += 1;
                
            });
            
            
        }).always(function(){
            addItemFacturaFormaDePagoTable();            
            verificarTotalFormasPago();
        }).fail(function(){
        });
}

function addItemFacturaFormaDePagoTable(){
    
    var tr = $("#factura_forma_pago_table>tbody tr:first");
    
    var trCount = $("#factura_forma_pago_table>tbody tr").length;
    
    var index = trCount - 1;
    
    var newTr = tr.clone(true);
                
    $(newTr).addClass('factura_formas_pago');            
    
    // *** input forma_id
    var formaId = $(newTr).find('.forma_id').get(0);
    $(formaId).attr('name', 'factura_forma_pago['+index+'][id]');
    // *** end input
    
    // *** select formas de pago
    var forma = $(newTr).find('.forma').get(0);                
                
    $(forma).attr('name', 'factura_forma_pago['+index+'][forma_pago_id]');

    $(forma).select2({allowClear: true, width: '50%', 
        placeholder: "Seleccione alguna forma de pago"});
    // *** end select
    
    // *** input valor
    var valor = $(newTr).find('.valor').get(0);
    $(valor).attr('name', 'factura_forma_pago['+index+'][valor]');
    // *** end input
    
    // *** input referencia
    var referencia = $(newTr).find('.referencia').get(0);
    $(referencia).attr('name', 'factura_forma_pago['+index+'][referencia]');
    // *** end input
    
    // *** input voucher_tarjeta
    var voucherTarjeta = $(newTr).find('.voucher_tarjeta').get(0);
    $(voucherTarjeta).attr('name', 'factura_forma_pago['+index+'][voucher_tarjeta]');
    // *** end input

    $(newTr).show();

    $("#factura_forma_pago_table").append(newTr);
}

function verificarTotalFormasPago(){
    
    var totalFormato = $("#factura_total").html().replace('.', '');
    
    var total = parseInt(totalFormato);
    
    var formasTr = $("#factura_forma_pago_table tbody tr.factura_formas_pago");
    
    var totalFormasPago = 0;
    
    $.each(formasTr, function(i, e){
        
        var valor = 0;
        
        if($(e).find('.valor').val() > 0){
            valor = $(e).find('.valor').val();
        }
        
        totalFormasPago += parseInt(valor);
        
    });    
    
    var restante = total - totalFormasPago;
    
    if(!$.isNumeric(restante)){
        restante = 0;
    }
    
    $("#total_formas_span").html(formatMoneda(totalFormasPago, true, ''));
    $("#restante_formas_span").html(formatMoneda(restante, true, ''));
    
    var alertClass = "text-danger";
    
    $("#restante_formas_span").removeClass(alertClass);
    
    if(restante !== 0){
        $("#restante_formas_span").addClass(alertClass);
    }
    
    return restante;
    
}

function descartarFactura(){
    
    var facturaId = $("#factura_id").val();
    
    if(facturaId === ''){
        window.location.assign("index.php/gastos/comprobante/create/");
        return false;
    }
    
    $.ajax({url: baseUrl + 'api.php/gastos/comprobante/descartarFactura', 
            type: 'put',
            data: {'factura_id' : facturaId},
        success: function (response) {
            
        }
    }).done(function (response){        
        window.location.assign("index.php/gastos/comprobante/create/");        
    });
}