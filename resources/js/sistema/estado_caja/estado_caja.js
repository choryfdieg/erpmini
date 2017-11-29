
var baseUrl = $('base').attr('href');
$(document).ready(function(){
var table = $('#mTableEstado_caja').DataTable({
	'ajax': baseUrl + 'api.php/maintenance/mEstado_caja/estado_cajas',
	'responsive': true,
	'language': {
		'lengthMenu': 'Mostrar _MENU_ registros por pagina',
		'zeroRecords': 'No se encontraron registros',
		'info': 'Mostrando la pagina _PAGE_ de _PAGES_',
		'infoEmpty': 'No hay registro para mostrar',
		'infoFiltered': '(buscando entre _MAX_ registros)',
		'sSearch': 'Buscar:',
		'oPaginate': {
			'sFirst':    'Primero',
			'sLast':     'Último',
			'sNext':     'Siguiente',
			'sPrevious': 'Anterior',
		}
	}
});

   $('#mTableEstado_caja tbody').on( 'click', 'tr', function () {
     var data = table.row( this ).data();
    $.get(baseUrl + 'api.php/maintenance/mEstado_caja/estado_caja', {id: data[0]}, 
       function(response){
           editarEstado_caja(response);
      }).fail(function(){
     });
     });
     $('#estado_caja_modal').on('hide.bs.modal', function () {
         table.ajax.reload(function(){});
     });
});
function nuevoEstado_caja(){
	var controles = $('#estado_caja_form .form-control');
	$.each(controles, function(i, e){
	$(e).val('');
	});
	
	$('#estado_caja_modal').modal('show');
}

function guardarEstado_caja(){
     var type = 'post';
     if($('#estado_caja_id').val() !== ''){
         type = 'put';
 }
     $.ajax({url: baseUrl + 'api.php/maintenance/mEstado_caja/estado_caja', 
     type: type,
     data: $('#estado_caja_form').serialize(),
     success: function (response) {
     $('#estado_caja_modal').modal('hide');
     }
     });
 }
function editarEstado_caja(data){
     var obj = eval('('+data+')');
     var controles = $('#estado_caja_form .form-control');
     $.each(controles, function(i, e){
     $(e).val(obj[$(e).attr('name')]);
     });
     $('#estado_caja_modal').modal('show');
 }