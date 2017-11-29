
var baseUrl = $('base').attr('href');
$(document).ready(function(){
var table = $('#mTableCaja_sucursal').DataTable({
	'ajax': baseUrl + 'api.php/maintenance/mCaja_sucursal/caja_sucursals',
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

   $('#mTableCaja_sucursal tbody').on( 'click', 'tr', function () {
     var data = table.row( this ).data();
    $.get(baseUrl + 'api.php/maintenance/mCaja_sucursal/caja_sucursal', {id: data[0]}, 
       function(response){
            editarCaja_sucursal(response);
      }).fail(function(){
     });
     });
     $('#myModal').on('hide.bs.modal', function () {
         table.ajax.reload(function(){});
     });
});
function nuevoCaja_sucursal(){
	var controles = $('#caja_sucursal_form .form-control');
	$.each(controles, function(i, e){
	$(e).val('');
	});
	
	$('#caja_sucursal_modal').modal('show');
}

function guardarCaja_sucursal(){
     var type = 'post';
     if($('#caja_sucursal_id').val() !== ''){
         type = 'put';
 }
     $.ajax({url: baseUrl + 'api.php/maintenance/mCaja_sucursal/caja_sucursal', 
     type: type,
     data: $('#caja_sucursal_form').serialize(),
     success: function (response) {
     $('#myModal').modal('hide');
     }
     });
 }
function editarCaja_sucursal(data){
    
     var obj = eval('('+data+')');
     var controles = $('#caja_sucursal_form .form-control');
     $.each(controles, function(i, e){
     $(e).val(obj[$(e).attr('name')]);
     });
     $('#caja_sucursal_modal').modal('show');
 }