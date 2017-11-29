var baseUrl = $('base').attr('href');

$(document).ready(function(){
    
    var table = $('#tableCliente').DataTable({
        "ajax": baseUrl + 'api.php/crm/cliente/clientes',
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
    
    $('#tableCliente tbody').on( 'click', 'tr', function () {
        var data = table.row( this ).data();        
        $.get(baseUrl + 'api.php/crm/cliente/cliente', {id: data[0]}, 
        function(response){
            editCliente(response);
        }).fail(function(){
        });
    } );
    
    $('#cliente_modal').on('hide.bs.modal', function () {
        table.ajax.reload(function(){});
    });
    
});

function addCliente(){
    
    var controles = $('#cliente_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val('');
    });
    
    $("#cliente_modal").modal('show');
}

function saveCliente(){
    
    var type = 'post';
    
    if($("#cliente_id").val() !== ''){
        type = 'put';
    }
    
    $.ajax({url: baseUrl + 'api.php/crm/cliente/cliente', 
            type: type,
            data: $("#cliente_form").serialize(),
        success: function (response) {
            $("#cliente_modal_cerrar_button").click();
        }
    });
}

function editCliente(data){
    
    var obj = eval('('+data+')');
    
    var controles = $('#cliente_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val(obj[$(e).attr('name')]);
    });
    
    $("#cliente_modal").modal('show');
    
}