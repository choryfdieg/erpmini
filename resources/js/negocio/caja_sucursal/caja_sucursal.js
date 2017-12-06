var baseUrl = $('base').attr('href');

$(document).ready(function () {
    var table = $('#tableCaja_sucursal').DataTable({
        'ajax': { 'url' : baseUrl + 'api.php/negocio/caja_sucursal/caja_sucursals', 
                    'data': {sucursal_id: $("#sucursal_id").val()}}, 
        'responsive': true,
        'language': {
            'lengthMenu': 'Mostrar _MENU_ registros por pagina',
            'zeroRecords': 'No se encontraron registros',
            'info': 'Mostrando la pagina _PAGE_ de _PAGES_',
            'infoEmpty': 'No hay registro para mostrar',
            'infoFiltered': '(buscando entre _MAX_ registros)',
            'sSearch': 'Buscar:',
            'oPaginate': {
                'sFirst': 'Primero',
                'sLast': 'Último',
                'sNext': 'Siguiente',
                'sPrevious': 'Anterior',
            }
        },
        "columnDefs": [
              {
            "targets": -1,
            "data": [0],
            "render": function(data){ 
                        return '<a id="editar_caja_sucursal_button" href="javascript:;" class="btn btn-primary btn-xs mr-3"><i class="fa fa-pencil"></i></a>'
                      }
              }
          ]  
    });

    $('#tableCaja_sucursal tbody').on('click', '#editar_caja_sucursal_button', function () {
        
        var tr = $(this).closest('tr');
        
        var data = table.row(tr).data();
        
        $.get(baseUrl + 'api.php/negocio/caja_sucursal/caja_sucursal', {id: data[0]},
                function (response) {
                    editarCaja_sucursal(response);
                }).fail(function () {
        });
    });
    $('#caja_sucursal_modal').on('hide.bs.modal', function () {
        table.ajax.reload(function () {});
    });
});

function nuevoCaja_sucursal() {
    var controles = $('#caja_sucursal_form .form-control');
    $.each(controles, function (i, e) {
        $(e).val('');
    });

    $('#caja_sucursal_modal').modal('show');
}

function guardarCaja_sucursal() {
    var type = 'post';
    if ($('#caja_sucursal_id').val() !== '') {
        type = 'put';
    }
    $.ajax({url: baseUrl + 'api.php/negocio/caja_sucursal/caja_sucursal',
        type: type,
        data: $('#caja_sucursal_form').serialize(),
        success: function (response) {
            $('#caja_sucursal_modal').modal('hide');
        }
    });
}

function editarCaja_sucursal(data) {
    var obj = eval('(' + data + ')');
    var controles = $('#caja_sucursal_form .form-control');
    $.each(controles, function (i, e) {
        $(e).val(obj[$(e).attr('name')]);
    });
    $('#caja_sucursal_modal').modal('show');
}