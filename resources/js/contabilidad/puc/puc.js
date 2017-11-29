
var baseUrl = $('base').attr('href');
$(document).ready(function(){
var table = $('#mTablePuc').DataTable({
	'ajax': baseUrl + 'api.php/maintenance/mPuc/pucs',
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

   $('#mTablePuc tbody').on( 'click', 'tr', function () {
     var data = table.row( this ).data();
    $.get(baseUrl + 'api.php/maintenance/mPuc/puc', {id: data[0]}, 
       function(response){
           showModal(response);
      }).fail(function(){
     });
     });
     $('#myModal').on('hide.bs.modal', function () {
         table.ajax.reload(function(){});
     });
});
function nuevoPuc(){
	var controles = $('#puc_form .form-control');
	$.each(controles, function(i, e){
	$(e).val('');
	});
	
	$('#myModal').modal('show');
}

function guardarPuc(){
     var type = 'post';
     if($('#puc_id').val() !== ''){
         type = 'put';
 }
     $.ajax({url: baseUrl + 'api.php/maintenance/mPuc/puc', 
     type: type,
     data: $('#puc_form').serialize(),
     success: function (response) {
     $('#myModal').modal('hide');
     }
     });
 }
function showModal(data){
     var obj = eval('('+data+')');
     var controles = $('#puc_form .form-control');
     $.each(controles, function(i, e){
     $(e).val(obj[$(e).attr('name')]);
     });
     $('#myModal').modal('show');
 }