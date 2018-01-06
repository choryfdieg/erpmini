var baseUrl = $('base').attr('href');

$(document).ready(function(){    
    loadFacturasTable();
});

function loadFacturasTable(){
    var table = $('#facturas_table').DataTable({
        "ajax": baseUrl + 'api.php/ingresos/factura/facturas',
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
        "columnDefs": [
              {
            "targets": -1,
            "data": [0],
            "render": function(data){ 
                        return '<a href="index.php/ingresos/factura/edit/id/' + data + '" class="btn btn-primary btn-xs mr-3"><i class="fa fa-pencil"></i></a>' +
                        '<a href="index.php/ingresos/nota/create/factura/' + data + '" class="btn btn-warning btn-xs mr-3">NC</a>';
                      }
              }
          ]                      
    });
    
    $("#reload_button").click(function(){
        table.ajax.reload();
    });
}
