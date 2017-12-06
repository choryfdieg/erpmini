var baseUrl = $('base').attr('href');
$(document).ready(function () {
    
    $('#datetimepicker1').datetimepicker({locale: 'es', format: 'YYYY/MM/DD'});
    
    loadSucursalesSelect();
    
    $('#sucursal_select').select2({allowClear: true, width: '50%', 
        placeholder: "Seleccione una sucursal"});
    
    
});

function guardarApertura_caja() {
    var type = 'post';
    if ($('#apertura_caja_id').val() !== '') {
        type = 'put';
    }
    $.ajax({url: baseUrl + 'api.php/negocio/apertura_caja/apertura_caja',
        type: type,
        data: $('#apertura_caja_form').serialize(),
        success: function (response) {
            
        }
    });
}

function loadSucursalesSelect(){
    
    var select = $("#sucursal_select");
    
    $.get(baseUrl + 'api.php/negocio/sucursal/sucursalsForSelect', {}, 
        function(response){
            
            var sucursales = eval('('+response+')');
            
            var option = $('<option>', {
                    value: '',
                    text: ''
                });
                
            $(select).append(option);
            
            $.each(sucursales, function(i, e){
                
                option = $('<option>', {
                    value: e.id,
                    text: e.nombre
                });
                
                $(select).append(option);
            });
            
            
        }).done(function(){
        }).fail(function(){
        });
}