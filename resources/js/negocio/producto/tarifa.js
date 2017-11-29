var baseUrl = $('base').attr('href');

$(document).ready(function(){
    
    var table = $('#tableTarifa').DataTable({
        "ajax": {"url" : baseUrl + 'api.php/negocio/producto/tarifasProducto', "data":{producto_id: $("#producto_id").val()}},
        "responsive": true,
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
        }
    });
    
    $("#unidad_medida_id_select").select2({width: '50%', 
                placeholder: "Seleccione una unidad"});
    
    loadUnidadesMedidaSelect();
    loadSucursalesSelect();
    
    $('#tableTarifa tbody').on( 'click', 'tr', function (data) {
        
        var data = table.row( this ).data();
        
        $.get(baseUrl + 'api.php/negocio/producto/tarifa', {id: data[0]}, 
        
        function(response){
            nuevaTarifa();
            editarTarifa(response);
        }).fail(function(){
        });
        
    });
    
    $('#guardar_tarifa_button').click(function () {
        guardarTarifa(table);        
    });
    
});

function nuevaTarifa(){
    
        
    var unidad = $('#unidad_medida_id_select');    
    $(unidad).select2('val', null);
    
    var valor = $('#valor_unitario');
    valor.val('');
    
    var costo = $('#costo_unitario');
    costo.val('');
        
    $('.new_item_kardex').remove();
    
}

function guardarTarifa(table){
    
    var type = 'post';
    
    if($("#tarifa_id").val() !== ''){
        type = 'put';
    }
    
    $.ajax({url: baseUrl + 'api.php/negocio/producto/tarifa', 
            type: type,
            data: $("#tarifa_form").serialize(),
        success: function (response) {
            
            var data = eval('('+response+')');            
            
        }
    }).done(function(){
        nuevaTarifa();
        table.ajax.reload(function(){});
    });
}

function removeItemKardex(element){
    
    $(element).closest('div.new_item_kardex').remove();
}

function addItemKardex(){
    
    var div = $("#tarifa_kardex_div");
    
    var itemCount = $(div).find("div.item_kardex").length;
    
    var index = itemCount - 1;
    
    var item = $(div).find("div.item_kardex:first");
    
    var newItem = item.clone(true);
    
    $(newItem).attr('class', 'new_item_kardex');
    
    // *** input id
    var id = $(newItem).find('.id').get(0);                
    $(id).attr('name', 'kardex['+index+'][id]');
    // *** end input
                
    // *** select sucursal
    var sucursalId = $(newItem).find('.sucursal_id').get(0);                
    $(sucursalId).attr('name', 'kardex['+index+'][sucursal_id]');
    $(sucursalId).select2({allowClear: true, width: '50%', 
        placeholder: "Seleccione una sucursal"});
    // *** end select
    
    // *** select sucursal
    var cantidad = $(newItem).find('.cantidad').get(0);                
    $(cantidad).attr('name', 'kardex['+index+'][cantidad]');
    // *** end select
    
    $(newItem).show();    
    
    div.append(newItem);
}

function editarTarifa(data){
    
    var obj = eval('('+data+')');
    
    var tarifa = obj.tarifa;
    
    var id = $('#tarifa_id');
    id.val(tarifa.id);
    
    var unidad = $('#unidad_medida_id_select');    
    $(unidad).select2('val', tarifa.unidad_medida_id);
    
    var costo = $('#costo_unitario');
    costo.val(tarifa.costo_unitario);
    
    var valor = $('#valor_unitario');
    valor.val(tarifa.valor_unitario);
    
    var kardex = tarifa.kardexArray;    
    
    // *** Panel de sucursales
    var div = $("#tarifa_kardex_div");
    
    var itemCount = $(div).find("div.item_kardex").length;    
    
    var index = itemCount - 1;
    
    var item = $(div).find("div.item_kardex:first");
    
    $.each(kardex, function(i, e){        

        var newItem = item.clone(true);
        
        $(newItem).attr('class', 'new_item_kardex');
        
        // reemplaza al valor que esta en la tarifa
        $("#costo_unitario").val(e.costo_unitario);
        
        // *** input id
        var id = $(newItem).find('.id').get(0);                
        $(id).attr('name', 'kardex['+index+'][id]');
        $(id).val(e.id);
        // *** end input

        // *** select sucursal
        var sucursalId = $(newItem).find('.sucursal_id').get(0);                
        $(sucursalId).attr('name', 'kardex['+index+'][sucursal_id]');
        $(sucursalId).val(e.sucursal_id);
        $(sucursalId).select2({allowClear: true, width: '50%', 
                                placeholder: "Seleccione una sucursal"});
        $(sucursalId).select2().val(e.sucursal_id);
        // *** end select

        // *** input cantidad
        var cantidad = $(newItem).find('.cantidad').get(0);                
        $(cantidad).attr('name', 'kardex['+index+'][cantidad]');
        $(cantidad).val(e.cantidad);
        // *** end input
        
        $(newItem).show();    

        div.append(newItem);
        
        index +=1;
        
    });
    
    
}

function loadSucursalesSelect(){
    
    var select = $("#sucursal_id_select");
    
    $.get(baseUrl + 'api.php/negocio/sucursal/sucursalsForSelect', {}, 
        function(response){
            
            var sucursales = eval('('+response+')');
            
            var option = $('<option>', {
                    value: '',
                    text: ''
                });
                
            $(select).append(option);
            
            $.each(sucursales, function(i, e){
                
                option = $('<option>', {
                    value: e.id,
                    text: e.nombre
                });
                
                $(select).append(option);
            });
            
            
        }).done(function(){
        }).fail(function(){
        });
}

function loadUnidadesMedidaSelect(){
    
    var select = $("#unidad_medida_id_select");
    
    $.get(baseUrl + 'api.php/negocio/unidad_medida/unidadesMedidaForSelect', {}, 
        function(response){
            
            var unidades = eval('('+response+')');
            
            var grupoAux = '';
            
            var data = [];
            var item = null;
            
            $.each(unidades, function(i, e){
                
                if(e.grupo !== grupoAux){
                    grupoAux = e.grupo;
                    item = {id:0, text: e.grupo, children:[]};
                    data.push(item);
                }
                    
                item.children.push({id:e.id, text: e.descripcion + ' ('+e.simbolo+')'});
            });
            
            $(select).select2({data: data});
            
            
        }).done(function(){            
        }).fail(function(){
        });
}