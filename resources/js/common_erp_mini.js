$(document).ready(function(){
   
    var href = 'index.php/' + $("meta[name='menuUrl']").attr("content"); ;
    var aElement = $('a[href$="'+href+'/"]:first');
    var liElement = $(aElement).closest("li.sub-menu");
    $(liElement).find("a :first").click();
    $(aElement).addClass("active");
    
});

function formatMoneda(input,setDecimal,setClase){   
    var parteEntera, parteDecimal, valueSplited;
    
    if(input != null && input !== ''){
        if(typeof input == "object"){        
            valueSplited = input.value.split(',');
            parteEntera  = valueSplited[0];

            parteEntera = parteEntera.replace(/\./g,'');

            if(!isNaN(parteEntera)){
                if(setClase){
                    input.className = 'required';
                }
                parteEntera     = tratarCadenaMoneda(parteEntera);
                input.value     = parteEntera;

            }
            else{ 
                  validarNumeric(input);
                  input.value = input.value.replace(/[^\d\.]*/g,'');
                  input.value = input.value.replace('-.','-');   
            }
        } else {
            valueSplited = input.toString().replace(".",",");
            valueSplited = (setDecimal) ? aproximarNumeroCadena(valueSplited, 2) : aproximarNumeroCadena(valueSplited, 0) ;

            parteDecimal = valueSplited[1];
            parteEntera  = tratarCadenaMoneda(valueSplited[0]);

            return parteEntera+((setDecimal) ? ","+parteDecimal : "");
        }
    }
    return 0;
       
}

function tratarCadenaMoneda(num){
    
    num = num.split('').reverse().join('');
    num = num.replace(/(\d{3})/g,'$1.');
    num = num.split('').reverse().join('');
    num = num.replace(/^\./,'');
    num = num.replace('-.','-');
    
    return num;
}

function aproximarNumeroCadena(aproximado,numDecimales){
    aproximado = aproximado.replace(",",".");
    aproximado = parseFloat(aproximado);
    aproximado = aproximado.toFixed(numDecimales);
    aproximado = aproximado.toString();
    aproximado = aproximado.split(".");
    return aproximado;  
}