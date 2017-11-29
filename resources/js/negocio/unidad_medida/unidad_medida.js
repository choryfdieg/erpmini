var baseUrl = $('base').attr('href');

$(document).ready(function(){
    
    var table = $('#tableUnidad_medida').DataTable({
        "ajax": baseUrl + 'api.php/negocio/unidad_medida/unidad_medidas',
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
    
    $('#tableUnidad_medida tbody').on( 'click', 'tr', function () {
        var data = table.row( this ).data();        
        $.get(baseUrl + 'api.php/negocio/unidad_medida/unidad_medida', {id: data[0]}, 
        function(response){
            editarUnidad_medida(response);
        }).fail(function(){
        });
    } );
    
    $('#unidad_medida_modal').on('hide.bs.modal', function () {
        table.ajax.reload(function(){});
    });
    
    loadGruposUnidadesSelect();
    
    $("#grupo_unidad_medida_id").select2({width: '50%',
        placeholder: "Seleccione una clasificacion"});
    
});

function nuevaUnidad_medida(){
    
    var controles = $('#unidad_medida_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val('');
    });
    
    $("#grupo_unidad_medida_id").select2('val', $('#grupo_unidad_medida_id option:eq(0)').val());
    
    $("#unidad_medida_modal").modal('show');
}

function guardarUnidad_medida(){
    
    var type = 'post';
    
    if($("#unidad_medida_id").val() !== ''){
        type = 'put';
    }
    
    $.ajax({url: baseUrl + 'api.php/negocio/unidad_medida/unidad_medida', 
            type: type,
            data: $("#unidad_medida_form").serialize(),
        success: function (response) {
            $("#unidad_medida_modal_cerrar_button").click();
        }
    });
}

function editarUnidad_medida(data){
    
    var obj = eval('('+data+')');
    
    var controles = $('#unidad_medida_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val(obj[$(e).attr('name')]);
    });
    
    $("#grupo_unidad_medida_id").select2().val(obj['grupo_unidad_medida_id']);
    
    $("#unidad_medida_modal").modal('show');
    
}

function loadGruposUnidadesSelect(){
    
    var select = $("#grupo_unidad_medida_id");
    
    $.get(baseUrl + 'api.php/negocio/unidad_medida/grupo_unidad_medidas', {}, 
        function(response){
            
            var option = null;
            
            var grupos = eval('('+response+')');
            
            $.each(grupos, function(i, e){
                
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