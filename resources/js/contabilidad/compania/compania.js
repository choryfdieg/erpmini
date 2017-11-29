
var baseUrl = $('base').attr('href');
$(document).ready(function(){
var table = $('#mTableCompania').DataTable({
	'ajax': baseUrl + 'api.php/maintenance/mCompania/companias',
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

   $('#mTableCompania tbody').on( 'click', 'tr', function () {
     var data = table.row( this ).data();
    $.get(baseUrl + 'api.php/maintenance/mCompania/compania', {id: data[0]}, 
       function(response){
        editar_compania(response);
      }).fail(function(){
     });
     });
     $('#compania_modal').on('hide.bs.modal', function () {
         table.ajax.reload(function(){});
     });
});
function nuevoCompania(){
	var controles = $('#compania_form .form-control');
	$.each(controles, function(i, e){
	$(e).val('');
	});
	
	$('#compania_modal').modal('show');
}

function guardarCompania(){
     var type = 'post';
     if($('#compania_id').val() !== ''){
         type = 'put';
 }
     $.ajax({url: baseUrl + 'api.php/maintenance/mCompania/compania', 
     type: type,
     data: $('#compania_form').serialize(),
     success: function (response) {
     $('#compania_modal').modal('hide');
     }
     });
 }
function editar_compania(data){
     var obj = eval('('+data+')');
     var controles = $('#compania_form .form-control');
     $.each(controles, function(i, e){
     $(e).val(obj[$(e).attr('name')]);
     });
     $('#compania_modal').modal('show');
 }