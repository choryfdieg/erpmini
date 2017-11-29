var baseUrl = $('base').attr('href');

$(document).ready(function(){
    
    var table = $('#tableImpuesto').DataTable({
        "ajax": baseUrl + 'api.php/negocio/impuesto/impuestos',
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
    
    $('#tableImpuesto tbody').on( 'click', 'tr', function () {
        var data = table.row( this ).data();        
        $.get(baseUrl + 'api.php/negocio/impuesto/impuesto', {id: data[0]}, 
        function(response){
            editarImpuesto(response);
        }).fail(function(){
        });
    } );
    
    $('#impuesto_modal').on('hide.bs.modal', function () {
        table.ajax.reload(function(){});
    });
    
});

function nuevoImpuesto(){
    
    var controles = $('#impuesto_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val('');
    });
    
    $("#impuesto_modal").modal('show');
}

function guardarImpuesto(){
    
    var type = 'post';
    
    if($("#impuesto_id").val() !== ''){
        type = 'put';
    }
    
    $.ajax({url: baseUrl + 'api.php/negocio/impuesto/impuesto', 
            type: type,
            data: $("#impuesto_form").serialize(),
        success: function (response) {
            $("#impuesto_modal_cerrar_button").click();
        }
    });
}

function editarImpuesto(data){
    
    var obj = eval('('+data+')');
    
    var controles = $('#impuesto_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val(obj[$(e).attr('name')]);
    });
    
    $("#impuesto_modal").modal('show');
    
}