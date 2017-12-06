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
        },
        "columnDefs": [
              {
            "targets": -1,
            "data": [0],
            "render": function(data){ 
                        return '<a href="index.php/negocio/sucursal/edit/id/' + data + '" class="btn btn-primary btn-xs mr-3"><i class="fa fa-pencil"></i></a>';
                      }
              }
          ]
    });
    
});

function guardarSucursal(){
    
    var type = 'post';
    
    if($("#sucursal_id").val() !== ''){
        type = 'put';
    }
    
    $.ajax({url: baseUrl + 'api.php/negocio/sucursal/sucursal', 
            type: type,
            data: $("#sucursal_form").serialize(),
        success: function (response) {
            
            var data = eval('('+response+')');
            
            window.location.assign("index.php/negocio/sucursal/edit/id/"+data.id);
        }
    });
}