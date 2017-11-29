
var baseUrl = $('base').attr('href');
$(document).ready(function(){
var table = $('#mTableNumero_factura').DataTable({
	'ajax': baseUrl + 'api.php/maintenance/mNumero_factura/numero_facturas',
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

   $('#mTableNumero_factura tbody').on( 'click', 'tr', function () {
     var data = table.row( this ).data();
    $.get(baseUrl + 'api.php/maintenance/mNumero_factura/numero_factura', {id: data[0]}, 
       function(response){
           showModal(response);
      }).fail(function(){
     });
     });
     $('#myModal').on('hide.bs.modal', function () {
         table.ajax.reload(function(){});
     });
});
function nuevoNumero_factura(){
	var controles = $('#numero_factura_form .form-control');
	$.each(controles, function(i, e){
	$(e).val('');
	});
	
	$('#myModal').modal('show');
}

function guardarNumero_factura(){
     var type = 'post';
     if($('#numero_factura_id').val() !== ''){
         type = 'put';
 }
     $.ajax({url: baseUrl + 'api.php/maintenance/mNumero_factura/numero_factura', 
     type: type,
     data: $('#numero_factura_form').serialize(),
     success: function (response) {
     $('#myModal').modal('hide');
     }
     });
 }
function showModal(data){
     var obj = eval('('+data+')');
     var controles = $('#numero_factura_form .form-control');
     $.each(controles, function(i, e){
     $(e).val(obj[$(e).attr('name')]);
     });
     $('#myModal').modal('show');
 }