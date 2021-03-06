var baseUrl = $('base').attr('href');

$(document).ready(function(){    
    
    loadNotasTable();
    
    $('#datetimepicker1').datetimepicker({locale: 'es', format: 'YYYY/MM/DD'});
    
    $("#terceros_factura_select").select2({allowClear: true, width: '50%', 
        placeholder: "Seleccione el cliente"});
    
    loadFacturaProductosTable();
    loadFormasDePagoSelect();
    
    $(".valor_unitario").on('change', function(){        
        uploadSubtotal();
    });
    
    $(".valor").on('change', function(){
        verificarTotalFormasPago();
    });
    
});

function loadNotasTable(){
    var table = $('#notas_table').DataTable({
        "ajax": baseUrl + 'api.php/ingresos/nota/notas',
        "responsive": true,
         "order": [[ 0, "desc" ]],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registro para mostrar",
            "infoFiltered": "(buscando entre _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior",
            }
        },
        "columnDefs": [{
            "targets": [0],
            "render": function(data){ 
                        return '<a href="index.php/ingresos/nota/edit/id/' + data + '">' + data + '</a>';
                      }
              }]                      
    });
    
    $("#reload_button").click(function(){
        table.ajax.reload();
    });
}

function uploadSubtotal(){
    
    var subtotal = 0;
    
    var productosTr = $("#factura_producto_table tbody tr.factura_producto");
    
    var impuestos = 0;
    var base = 0;
    var subtotal = 0;
    var descuentos = 0;
    var participacion = 0;
    
    productosTr.each(function(i, e){
        
        var factura_producto = $(e).data("factura_producto");
        
        var porcentaje_impuesto = $(e).find('.porcentaje_impuesto').val();
        
        var valor_unitario = $(e).find('.valor_unitario').val();
        
        var cantidad = 1;
        
        var impuesto = 0;
        
        var porcentajeParticipacion = 0;
        
        // *** NOTA CREDITO TOTAL        
        if(parseInt(factura_producto.valor_total) === parseInt(valor_unitario)){
            valor_unitario = parseInt(factura_producto.valor_unitario);
            cantidad = parseInt(factura_producto.cantidad);
            impuesto = parseInt(factura_producto.valor_impuesto);
            valorCalculo = parseInt(factura_producto.valor_unitario);
        }else{
            if(porcentaje_impuesto !== undefined && porcentaje_impuesto > 0){
                
                porcentajeParticipacion = (parseInt(valor_unitario) * parseInt(factura_producto.descuento)) / (parseInt(factura_producto.valor_unitario) * parseInt(factura_producto.cantidad));
                
                var valorCalculo = parseInt(valor_unitario) + porcentajeParticipacion;
                
                impuesto = Math.round((valorCalculo * parseInt(porcentaje_impuesto))/(100 + parseInt(porcentaje_impuesto)));                
            }
        }
        
        base += (valorCalculo - (impuesto/cantidad)) * cantidad;        
        
        subtotal += valor_unitario * cantidad;
        
        descuentos += porcentajeParticipacion;
        
        impuestos += impuesto;
        
    });
    
    $("#factura_base").html(formatMoneda(base, true, ''));
    $("#factura_impuestos").html(formatMoneda(impuestos, true, ''));
    $("#factura_subtotal").html(formatMoneda(subtotal, true, ''));
    $("#factura_descuentos").html(formatMoneda(descuentos, true, ''));
    $("#factura_total").html(formatMoneda(subtotal - descuentos, true, ''));
    
    verificarTotalFormasPago();
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
    
    $.ajax({url: baseUrl + 'api.php/ingresos/nota/save', 
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
            window.location.assign("index.php/ingresos/nota/edit/id/"+data.id);
        }
    });
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

function printDocument(facturaIdResponse){
    
    var facturaId = $("#factura_id").val();
    
    if(facturaId === ""){
        facturaId = facturaIdResponse;
    }
    
    $.get(baseUrl + 'api.php/ingresos/factura/imprimirFactura', {'factura_id':facturaId}, 
        function(response){
            
            var data = $.parseJSON(response);
            
            var a = document.createElement("a");
            a.href = 'data:application/pdf;base64,'+data.factura;
            a.download = "factura.pdf"; //update for filename
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);            

        }).done(function(){
            window.location.assign("index.php/ingresos/nota/edit/id/"+facturaId);
        }).fail(function(){
        });
    
}

function removeItemTable(element){
    $(element).closest('tr').remove();
    uploadSubtotal();
}

function loadFacturaProductosTable(){
    
    var tr = $("#factura_producto_table>tbody tr:first");
    
    $.get(baseUrl + 'api.php/ingresos/nota/notaProductos', {factura_original_id: $("#factura_original_id").val(), factura_id: $("#factura_id").val()}, 
        function(response){
            
            var facturaProductos = eval('('+response+')');
            
            var trCount = $("#factura_producto_table>tbody tr").length;
    
            var index = trCount - 1;
            
            var item = null;
            var nota = null;
            var factura = null;
            
            $.each(facturaProductos, function(i, e){
                
                nota = e.nota_producto;
                factura = e.factura_producto;
                
                var newTr = tr.clone(true);
              
                $(newTr).addClass('factura_producto');
                
                newTr.data("factura_producto", factura);
                
                // id del registro nota_producto
                item = $(newTr).find('.item_id').get(0);
                $(item).attr('name', 'factura_producto['+index+'][id]');
                $(item).val(nota.id);
                
                // valor de la devolucion
                item = $(newTr).find('.valor_unitario').get(0);
                $(item).attr('name', 'factura_producto['+index+'][valor_unitario]');
                $(item).val(nota.valor_unitario);
                
                // cantidad de la devolucion
                item = $(newTr).find('.cantidad_devolucion').get(0);
                $(item).attr('name', 'factura_producto['+index+'][cantidad_devolucion]');
                $(item).attr('max', factura.cantidad);
                $(item).val(nota.cantidad_devolucion);
                
                // id del registro padre factura_producto
                item = $(newTr).find('.factura_producto_id').get(0);
                $(item).attr('name', 'factura_producto['+index+'][factura_producto_id]');
                $(item).val(factura.factura_producto_id);
                
                item = $(newTr).find('.porcentaje_impuesto').get(0);
                $(item).val(factura.porcentaje_impuesto);
                
                item = $(newTr).find('.factura_producto').get(0);
                $(item).html(factura.producto);
                
                item = $(newTr).find('.factura_impuesto').get(0);
                $(item).html(factura.impuesto);
                
                item = $(newTr).find('.factura_valor_unitario').get(0);
                $(item).html(factura.valor_unitario);
                
                item = $(newTr).find('.factura_descuento').get(0);
                $(item).html(factura.descuento);
                
                item = $(newTr).find('.factura_cantidad').get(0);
                $(item).html(factura.cantidad);
                
                item = $(newTr).find('.factura_valor_total').get(0);
                $(item).html(factura.valor_total);
                
                $(newTr).show();
                
                $("#factura_producto_table").append(newTr);
                
                index += 1;
                
            });
            
            
        }).done(function(){
            uploadSubtotal();
        }).always(function(){            
        }).fail(function(){
        });
}

function loadFormasDePagoSelect(){
    
    var tr = $("#factura_forma_pago_table>tbody tr:first");
    
    var select = $(tr).find('.forma');
    
    $.get(baseUrl + 'api.php/ingresos/nota/formasDePago', {}, 
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
    
    $.get(baseUrl + 'api.php/ingresos/nota/notaFormasDePago', {factura_original_id: $("#factura_original_id").val(), factura_id: $("#factura_id").val()}, 
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