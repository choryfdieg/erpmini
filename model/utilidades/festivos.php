<?php

class festivos 
{

        public  $hoy;
	public  $festivos;
	public  $ano;
	public  $pascua_mes;
	public  $pascua_dia;

        function __construct($ano = "") {
            if ($ano != "")
                $this->ano = $ano;

            $this->diasFestivos($this->ano);
        }


	public function diasFestivos($ano=''){
                $this->festivos = '';
		$this->hoy=date('Y-m-d');
		
		if($ano=='')
			$ano=date('Y');
			
		$this->ano=$ano;
		
		$this->pascua_mes=date("m", easter_date($this->ano));
		$this->pascua_dia=date("d", easter_date($this->ano));
				
		$this->festivos[$ano."-1"][1]   = true;		// Primero de Enero
		$this->festivos[$ano."-5"][1]   = true;		// Dia del Trabajo 1 de Mayo
		$this->festivos[$ano."-7"][20]  = true;		// Independencia 20 de Julio
		$this->festivos[$ano."-8"][7]   = true;		// Batalla de Boyac� 7 de Agosto
		$this->festivos[$ano."-12"][8]  = true;		// Maria Inmaculada 8 diciembre (religiosa)
		$this->festivos[$ano."-12"][25] = true;		// Navidad 25 de diciembre
		
		$this->calcula_emiliani(1, 6);				// Reyes Magos Enero 6
		$this->calcula_emiliani(3, 19);				// San Jose Marzo 19
		$this->calcula_emiliani(6, 29);				// San Pedro y San Pablo Junio 29
		$this->calcula_emiliani(8, 15);				// Asunci�n Agosto 15
		$this->calcula_emiliani(10, 12);			// Descubrimiento de Am�rica Oct 12
		$this->calcula_emiliani(11, 1);				// Todos los santos Nov 1
		$this->calcula_emiliani(11, 11);			// Independencia de Cartagena Nov 11
		
		//otras fechas calculadas a partir de la pascua.
		
		$this->otrasFechasCalculadas(-3);			//jueves santo
		$this->otrasFechasCalculadas(-2);			//viernes santo
		
		$this->otrasFechasCalculadas(36,true);		//Ascenci�n el Se�or pascua
		$this->otrasFechasCalculadas(60,true);		//Corpus Cristi
		$this->otrasFechasCalculadas(68,true);		//Sagrado Coraz�n
		
		// otras fechas importantes que no son festivos

		// $this->otrasFechasCalculadas(-46);		// Miercoles de Ceniza
		// $this->otrasFechasCalculadas(-46);		// Miercoles de Ceniza
		// $this->otrasFechasCalculadas(-48);		// Lunes de Carnaval Barranquilla
		// $this->otrasFechasCalculadas(-47);		// Martes de Carnaval Barranquilla
                
		$this->otrasFechasCalculadas(-81);		// Martes de Carnaval Barranquilla
                
                return $this->festivos;
	}

	protected function calcula_emiliani($mes_festivo,$dia_festivo){
            // funcion que mueve una fecha diferente a lunes al siguiente lunes en el
            // calendario y se aplica a fechas que estan bajo la ley emiliani
            //global  $y,$dia_festivo,$mes_festivo,$festivo;
            // Extrae el dia de la semana
            // 0 Domingo a 6 Sabado
            $dd = date("w",mktime(0,0,0,$mes_festivo,$dia_festivo,$this->ano));
            switch ($dd) {
                case 0:                                    // Domingo
                $dia_festivo = $dia_festivo + 1;
                break;
                case 2:                                    // Martes.
                $dia_festivo = $dia_festivo + 6;
                break;
                case 3:                                    // Miercoles
                $dia_festivo = $dia_festivo + 5;
                break;
                case 4:                                     // Jueves
                $dia_festivo = $dia_festivo + 4;
                break;
                case 5:                                     // Viernes
                $dia_festivo = $dia_festivo + 3;
                break;
                case 6:                                     // Sabado
                $dia_festivo = $dia_festivo + 2;
                break;
            }
            $mes = date("n", mktime(0,0,0,$mes_festivo,$dia_festivo,$this->ano))+0;
            $dia = date("d", mktime(0,0,0,$mes_festivo,$dia_festivo,$this->ano))+0;
            $this->festivos[$this->ano."-".$mes][$dia] = true;
	}
        
	protected function otrasFechasCalculadas($cantidadDias=0,$siguienteLunes=false)	{
            $mes_festivo = date("n", mktime(0,0,0,$this->pascua_mes,$this->pascua_dia+$cantidadDias,$this->ano));
            $dia_festivo = date("d", mktime(0,0,0,$this->pascua_mes,$this->pascua_dia+$cantidadDias,$this->ano));

            if ($siguienteLunes)
            {
                $this->calcula_emiliani($mes_festivo, $dia_festivo);
            }
            else
            {
                $this->festivos[$this->ano."-".($mes_festivo+0)][$dia_festivo+0] = true;
            }
	}

	public function esFestivo($dia, $mes){
            if($dia=='' or $mes==''){
                return false;
            }

            if (isset($this->festivos[$this->ano."-".(int)$mes][(int)$dia])){
                return true;
            }else{
                return false;
            }
	}

        public function getDiaNumero($anio, $mes, $dia){

            $esDia = false;

            $diaCalculado = date("w",mktime(0,0,0,$mes,$dia,$anio));

            return $diaCalculado;
        }
}
?>