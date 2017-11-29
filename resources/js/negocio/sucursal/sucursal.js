var baseUrl = $('base').attr('href');

$(document).ready(function(){
    
    var table = $('#tableSucursal').DataTable({
        "ajax": baseUrl + 'api.php/negocio/sucursal/sucursals',
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
    
    $('#tableSucursal tbody').on( 'click', 'tr', function () {
        var data = table.row( this ).data();        
        $.get(baseUrl + 'api.php/negocio/sucursal/sucursal', {id: data[0]}, 
        function(response){
            editarSucursal(response);
        }).fail(function(){
        });
    } );
    
    $('#sucursal_modal').on('hide.bs.modal', function () {
        table.ajax.reload(function(){});
    });
    
});

function nuevaSucursal(){
    
    var controles = $('#sucursal_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val('');
    });
    
    $("#sucursal_modal").modal('show');
}

function guardarSucursal(){
    
    var type = 'post';
    
    if($("#sucursal_id").val() !== ''){
        type = 'put';
    }
    
    $.ajax({url: baseUrl + 'api.php/negocio/sucursal/sucursal', 
            type: type,
            data: $("#sucursal_form").serialize(),
        success: function (response) {
            $("#sucursal_modal_cerrar_button").click();
        }
    });
}

function editarSucursal(data){
    
    var obj = eval('('+data+')');
    
    var controles = $('#sucursal_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val(obj[$(e).attr('name')]);
    });
    
    $("#sucursal_modal").modal('show');
    
}