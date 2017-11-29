var baseUrl = $('base').attr('href');

$(document).ready(function(){
    
    var table = $('#mTableTipo_factura').DataTable({
        "ajax": baseUrl + 'api.php/maintenance/mTipo_factura/tipo_facturas',
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
    
    $('#mSelectA_estado').append($('<option>', {
                    value: '',
                    text: ''
                })).append($('<option>', {
                    value: '1',
                    text: 'el uno'
                })).append($('<option>', {
                    value: '2',
                    text: 'el dos'
                }));
    
    $("#mSelectA_estado").select2({width: '50%', 
        placeholder: "Seleccione el estado"});
    
    var table = $('#mTableA_estado').DataTable({
        "ajax": baseUrl + 'api.php/maintenance/mA_estado/a_estados',
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
    
    $('#mTableA_estado tbody').on( 'click', 'tr', function () {
        var data = table.row( this ).data();
        
        $.get(baseUrl + 'api.php/maintenance/mA_estado/a_estado', {id: data[0]}, 
        function(response){
            showModal(response);
        }).fail(function(asfasf,asasf,asfasf){
        });
    } );
    
});

function guardar(){
    
    var type = 'post';
    
    if($("#a_estado_id").val() !== ''){
        type = 'put';
    }
    
    $.ajax({url: baseUrl + 'api.php/maintenance/mA_estado/a_estado', 
            type: type,
            data: $("#a_estado_form").serialize(),
        success: function (response) {
            $("#myModal").modal('hide');
            }
    });
}

function borrar(){
    
    $.ajax({url: baseUrl + 'api.php/maintenance/mA_estado/a_estado', 
            type: 'delete',
            data: $("#a_estado_form").serialize(),
        success: function (response) {
            $("#myModal").modal('hide');
            }
    });
}

function showModal(data){
    
    var obj = eval('('+data+')');
    
    var controles = $('#a_estado_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val(obj[$(e).attr('name')]);
    });
    
    $("#myModal").modal('show');
    
}