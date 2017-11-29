var baseUrl = $('base').attr('href');

$(document).ready(function(){
    
    var table = $('#tableProducto').DataTable({
        "ajax": baseUrl + 'api.php/negocio/producto/productos',
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
    
    $('#tableProducto tbody').on( 'click', 'tr', function (data) {
        var data = table.row( this ).data();        
        window.location.assign('index.php/negocio/producto/edit/id/'+data[0]);
    });
    
    $("#impuesto_id_select").select2();
    
});



function nuevoProducto(){
    
    var controles = $('#producto_form .form-control');
    
    $.each(controles, function(i, e){
        $(e).val('');
    });
    
}

function guardarProducto(){
    
    var type = 'post';
    
    if($("#producto_id").val() !== ''){
        type = 'put';
    }
    
    $.ajax({url: baseUrl + 'api.php/negocio/producto/producto', 
            type: type,
            data: $("#producto_form").serialize(),
        success: function (response) {
            
            var data = eval('('+response+')');
            
            window.location.assign("index.php/negocio/producto/edit/id/"+data.id);
            
        }
    });
}