
var baseUrl = $('base').attr('href');
$(document).ready(function(){
var table = $('#mTableApertura_caja').DataTable({
	'ajax': baseUrl + 'api.php/maintenance/mApertura_caja/apertura_cajas',
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

   $('#mTableApertura_caja tbody').on( 'click', 'tr', function () {
     var data = table.row( this ).data();
    $.get(baseUrl + 'api.php/maintenance/mApertura_caja/apertura_caja', {id: data[0]}, 
       function(response){
           editarApertura_caja(response);
      }).fail(function(){
     });
     });
     $('#apertura_caja_modal').on('hide.bs.modal', function () {
         table.ajax.reload(function(){});
     });
});
function nuevoApertura_caja(){
	var controles = $('#apertura_caja_form .form-control');
	$.each(controles, function(i, e){
	$(e).val('');
	});
	
	$('#apertura_caja_modal').modal('show');
}

function guardarApertura_caja(){
     var type = 'post';
     if($('#apertura_caja_id').val() !== ''){
         type = 'put';
 }
     $.ajax({url: baseUrl + 'api.php/maintenance/mApertura_caja/apertura_caja', 
     type: type,
     data: $('#apertura_caja_form').serialize(),
     success: function (response) {
     $('#apertura_caja_modal').modal('hide');
     }
     });
 }
function editarApertura_caja(data){
     var obj = eval('('+data+')');
     var controles = $('#apertura_caja_form .form-control');
     $.each(controles, function(i, e){
     $(e).val(obj[$(e).attr('name')]);
     });
     $('#apertura_caja_modal').modal('show');
 }