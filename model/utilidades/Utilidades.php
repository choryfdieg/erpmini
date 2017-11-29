<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilidades
 *
 * @author cirsisdgr
 */
require_once 'Mail.php';
require_once 'festivos.php';
require_once 'model/FactoryFacade.php';

class Utilidades {
    
    function Utilidades() {
    }

    public static function getTbanosfis(){
        $tbanofisFacade = new TbanofisFacade();
        $tbanosfis = $tbanofisFacade->findEntitiesDos(array("afcod", "afdes"),array("and afcod in (5, 6, 7) order by afcod desc "));
        return $tbanosfis;
    }
    
    public static function enviarCorreoOrdenAprobada($orcodorden){
        $mail = new Mail();
        
        // ***
        $tbincorpgFacade = new TbincorpgFacade();
        // ***
        $mail->setFrom("administrativa-no-reply@comfamiliar.com");
        $mail->setFromName("Herramientas Administrativas");
        $mail->setSubject("Herramientas Administrativas: Orden Aprobada por Subdireccion");
        $mail->setHost("smtp.comfamiliar.com");
        $mail->setUser("crivasi@comfamiliar.com");
        $mail->setPass("camino06=&");
        // ***
        if(!is_array($orcodorden)){
            $orcodorden = array($orcodorden);
        }
        // ***
        $tbincorpgCollection = $tbincorpgFacade->getIncidenciaByOrcodordenes($orcodorden,true);//el true es para saber que es mail
        $tbincorpgCollection = Utilidades::clasificarByUscodusuar($tbincorpgCollection);
        
        $uscodusuarArray = array_keys($tbincorpgCollection );
        
        
        for ($i = 0; count($uscodusuarArray) > $i; $i++){
            
            $mail->setTo($uscodusuarArray[$i]."@comfamiliar.com");
            
            $body = Utilidades::crearBodysMail($tbincorpgCollection[$uscodusuarArray[$i]]);
                  
            $mail->setBody($body); 
            
            $mail->sendMail();
              
        }
        
    }

    public static function clasificarByUscodusuar($datosArray) {
            $arrayClasificado = Array();
            
            //$arrayClasificado[Utilidades::getLogin()] = $datosArray;
            
            foreach ($datosArray as $dato) {
                if (!isset($arrayClasificado[$dato->getUscodusuar()]))
                    $arrayClasificado[$dato->getUscodusuar()] = array();

                $arrayClasificado[$dato->getUscodusuar()][] = $dato;
                
            }
            return $arrayClasificado;
     }
     
     public static function crearBodysMail($ordenesArray){
         $bodys = "";
         
         foreach ($ordenesArray as $ordenes){
             $bodys .= Utilidades::construirMailOrdenPg($ordenes->getOrcodorden()); 
         }
         
         return $bodys;
         
     }

    
    public  static function construirMailOrdenPg($orcodorden){
        $body = "";
                
        $tbordenpgFacade = new TbordenpgFacade();
        $datos = $tbordenpgFacade->getDatosMailOrdenPg($orcodorden);
        $F0101Facade = new F0101Facade();
        // ***
        
         $body .= "<div style='padding:10px; margin-left:5px; border: 1px solid #2e94fa; border-radius:7px; width: 800px'>";
            $body .= "Se ha autorizado por Subdirecci&oacute;n la orden n&uacute;mero " . $datos[0]['orcodorden'] . " ";
            $body .= "del Proceso " . $datos[0]['prdesproce'] . "<br/><br/>";
            $body .= "Recuerde enviar los documentos a Contabilidad<br/><br/>";
            
            
        $body .= "Resumen de la Orden <strong>" . $datos[0]['orcodorden'] . "</strong>:<br>";

        foreach ($datos as $value){
        
            $body .= "<table>";
            $body .= "<tr>";
            $body .= "<td>";
            $body .= "Proceso:";
            $body .= "</td>";
            $body .= "<td>";
            $body .= "<strong>$value[prdesproce]</strong>";
            $body .= "</td>";
            $body .= "</tr>";
            $body .= "<tr>";
            $body .= "<td>";
            $body .= "Observaci&oacute;n:";
            $body .= "</td>";
            $body .= "<td>";
            $body .= "<strong>$value[orobserva]</strong>";
            $body .= "</td>";
            $body .= "</tr>";
            $body .= "<tr>";
            $body .= "<td>";
            $body .= "Proveedor:";
            $body .= "</td>";
            $body .= "<td>";
            $body .= "<strong>".$F0101Facade->getF0101($value['pvcod'])->getAbalph()."<strong>";
            $body .= "</td>";
            $body .= "</tr>";
            $body .= "<tr>";
            $body .= "<td>";
            $body .= "Valor:";
            $body .= "</td>";
            $body .= "<td>";
            $body .= "<strong>".Utilidades::formatMoneda($value['orvalor'])."</strong>";
            $body .= "</td>";
            $body .= "</tr>";
            $body .= "</table>";
        
        
        }

        $body .= "</ul>";
        $body .= "<br/>";
        $body .= "Puede ver y hacerle seguimiento a esta orden dando click en el siguiente enlace: ";
        $body .= "<a href='".Utilidades::getBaseUrl()."ordTbordenpg/view/id/".$value['orcodorden']."' title='Click para ir a la orden'>Ir a la Orden</a><br/>";
        $body .= "</div>";
        $body .= "<br>";
        $body .= "<div style='background: #E9E9E9;border: 1px solid #C2C2C2;border-radius:3px;width: 825px;padding: 2px;'>";
        $body .= "    <font size='1' color='#DB0A0A';>";
        $body .= "      <b>Esta es una notificaci&oacute;n autom&aacute;tica de Herramientas Administrativas.<br>No responder este mensaje.</b>";
        $body .= "    </font>";
        $body .= "</div>";
            
        return $body;
    }

    public static function tieneGrupo($grcodgrupos){

        $tbsggruusuFacade = new TbsggruusuFacade();

        if(!is_array($grcodgrupos))
            $grcodgrupos = (array)$grcodgrupos;

        $tieneGrupo = false;
        $gruposUsuario = 0;

        if(isset ($_SESSION["login"]) && $_SESSION["login"] != '')
            $gruposUsuario = $tbsggruusuFacade->getCantidadGruposUsuario($_SESSION["login"], $grcodgrupos);

        if($gruposUsuario > 0)
            $tieneGrupo = true;

        return $tieneGrupo;

    }

    public static function noTieneGrupos($Grupos = array()){
        
        if(!is_array($Grupos))
            $Grupos = (array) $Grupos;

        $tbsggruusuFacade = new TbsggruusuFacade();
        
        $gruposUsuario = array();

        $tieneGrupo = false;
        
        $filtros = array();
                
        if(empty($Grupos)){
            foreach($tbsggruusuFacade->findEntitiesDos(array('grcodgrupo')) as $tbsggruusu){
                $Grupos[] = $tbsggruusu->getGrcodgrupo();
            }
        } 
        
        $filtros[] = " and a.grcodgrupo in (".implode(",", $Grupos).")";
                
        $gruposUsuario = $tbsggruusuFacade->getGruposUsuario($_SESSION["login"], $filtros);        
        
        return (empty ($gruposUsuario)) ? true : false;
    }
    
    public static function getCedulaUsuario(){

        $cedulaUsuario = $_SESSION['cedulaUsuario'];

        return $cedulaUsuario;

    }
    
    public static function getLogin(){

        $login = $_SESSION['login'];

        return $login;

    }
    
    public static function getTbutmotivo($monomtabla,$mocodmotiv){
        $tbutmotivoModel = new TbutmotivoModel();
        $tbutmotivo = $tbutmotivoModel->getMotivo($monomtabla, $mocodmotiv);
        return $tbutmotivo;
    }
    
    public static function getTipoArticulo($id){
        $TbtipoFacade = new TbtipoFacade();
        return $TbtipoFacade->findById($id);
    }
    
    public static function getVadescripc($vacodtabla, $vacoddescr, $vacodsis='ADMINISTRA'){
        $TbbdcodvarFacade = new TbbdcodvarFacade();
        $params['vacodtabla']= $vacodtabla;
        $params['vacoddescr']= $vacoddescr;
        $params['vacodsis']= $vacodsis;
        $vadescripc = $TbbdcodvarFacade->getTbbdcodvars($params);
        return $vadescripc[0]->getVadescripc(); 
    }
    
    public static function getListaTbcodvar($params, $order = true) {
        $tbbdcodvarFacade = new TbbdcodvarFacade();
        return $tbbdcodvarFacade->getTbbdcodvars(array('vacodtabla'=>$params),$order);
    }
    
    
    public static function diasTranscurridos($fechaFin,$fechaInicio) {
        
        if(Utilidades::verificarFecha($fechaFin) && Utilidades::verificarFecha($fechaInicio)){
            
            $dias = (strtotime ($fechaFin)-strtotime ($fechaInicio))/86400;
            
            $dias = floor(abs($dias));
                        
            if(strtotime ($fechaFin) > strtotime ($fechaInicio) && $fechaInicio == date('Y-m-d') )
                return -$dias;
            else
                return $dias;   
        }

        return "Sin fecha";
    }
    
    public static function totalDiasMes($fecha){
        return date('t',strtotime($fecha));
    }
    
    public static function getPeriodos($fecha, $periodo = ''){
        $timestamp = strtotime($fecha);
        
        list($anio,$mes,$dia,$semana) = explode('-', date("Y-m-d-W",$timestamp));
        $quincena         = (2*$mes)-(($dia <= 15) ? 1 : 0);
        list($bimestre,)  = explode('.', (($mes/3)+((($mes%3) > 0) ? 1 : 0)));
        list($trimestre,) = explode('.', (($mes/4)+((($mes%4) > 0) ? 1 : 0)));
        list($semestre,)  = explode('.', (($mes/6)+((($mes%6) > 0) ? 1 : 0)));
        
        $periodos['dia']       = $anio.$mes.$dia;
        $periodos['semana']    = (($semana > 5 &&  $mes == 1) ? $anio-1 : ($semana == 1 &&  $mes == 12) ? $anio+1 : $anio).Utilidades::setToken($semana,2,0);
        $periodos['quincena']  = $anio.Utilidades::setToken($quincena,2,0);
        $periodos['mes']       = $anio.$mes;
        $periodos['bimestre']  = $anio.$bimestre;
        $periodos['trimestre'] = $anio.$trimestre;
        $periodos['semestre']  = $anio.$semestre;
        $periodos['anio']      = $anio;
        $periodos['juliana']   = Utilidades::julianDate($fecha);
        
        if($periodo != ''){
            $periodo = strtolower($periodo);
            return $periodos[$periodo];
        }
        return $periodos;
    }
       
    public static function verificarFecha($fecha){
        if (preg_match("/^([0-9]{4})-?([0-9]{2})-?([0-9]{2})$/", $fecha, $partes)) {
            if (checkdate($partes[2], $partes[3], $partes[1]))
                return true;
            else
                return false;
        }
        else
            return false;
    }
    
     public static function diasEtiqueta($fechaFin,$fechaInicio=false){
        
        if(!$fechaInicio)
          $fechaInicio=date('Y-m-d');
        
        $diasTranscurridos = Utilidades::diasTranscurridos($fechaFin,$fechaInicio);
        if(is_numeric($diasTranscurridos)){
           
        if($diasTranscurridos == 1)
            $diasTranscurridos .= " DIA";
         else 
            $diasTranscurridos .= " DIAS";
        }
        return $diasTranscurridos;
    }    
    
    public static function getApplicationUrl(){
        
        $url = str_replace(array('index.php','api.php'),array('',''), $_SERVER["SCRIPT_NAME"]);
        
        return "http://".$_SERVER['SERVER_NAME'].$url;        
    }
    
    public static function getHostUploads($ruta){              
        $ruta = str_replace(Ambiente::$APPPATH, "", $ruta);
        $ruta = str_replace("/\/\/+/", "/", $ruta);
        return Ambiente::$HOSTUPLOADS.$ruta;
    }
    
    public static function getBaseUrl($fileName = 'index'){
                  
        return Utilidades::getApplicationUrl()."$fileName.php/";
    }
    
    public static function getAccionParamUrl($param){
        
        $paramArray = array();
        
        $url = $_SERVER['REQUEST_URI'];
                
        $patron = "/".$param."\/([a-zA-Z-0-9_\$-]*)/";
        
        preg_match_all($patron, $url, $paramArray, PREG_SET_ORDER);
        
        return (!empty($paramArray[0][1])) ? $paramArray[0][1] : '';

    }    
    
    public static function getProcesoDes($id){
        $tbthproceFacade  = new TbthproceFacade();
        $tbthproce = $tbthproceFacade->findById($id, array('prdesproce'));
        return $tbthproce->getPrdesproce();
    }

    public static function getCorreosCandidatos($cacodcandis){
        
        $correos = array();

        $tbthcandiFacade = new TbthcandiFacade();

        $cedulasCandidatos = $tbthcandiFacade->getCedulasCandidatos($cacodcandis);

        $cadena = "";        

        foreach ($cedulasCandidatos as $cedula) {

            $cadena = "sec.comfamiliar.com/usuario/$cedula[CANUMDOCUM].xml";

            $xml = simplexml_load_file($cadena);

            foreach ($xml as $value) {
                if(isset($xml->email)){
                    $correos[] = (string)$xml->emial;
                }
            }
        }

        return $correos;

    }
    
    public static function setToken($cadena, $longitudFinal, $token = " "){     
        while(strlen($cadena) < $longitudFinal){
            $cadena = $token.$cadena;       
        }
        return $cadena;
    }
    
    public static function setTokenPosition($cadena, $posiciones, $token = " "){
        if(!is_array($posiciones))
            $posiciones = array($posiciones);
        while($posicion = array_pop($posiciones))
            $cadena = substr($cadena, 0,$posicion).$token.substr($cadena, $posicion);
  
        return $cadena;
    }
    
    public static function splitPosition($cadena, $posiciones){
        $splited = array();
        if(!is_array($posiciones))
            $posiciones = array($posiciones);
        while($posicion = array_pop($posiciones)){
            $splited[] = substr($cadena, $posicion);
            $cadena    = substr($cadena, 0,$posicion);
        }
        $splited[] = $cadena;
        return array_reverse($splited);
    }
    
    public static function julianDate($fecha = ""){
        if($fecha != ""){
            $fecha = (strlen($fecha) == 10) ? $fecha : Utilidades::setTokenPosition($fecha, array(4,6),'-');
            list($anio,,) = preg_split('/\W+/', $fecha);
        } else{
            $fecha = date("Y-m-d");
            $anio  = date("Y");
        }       
        
        $dias = Utilidades::diasTranscurridos($fecha, $anio."-01-01");
                
        return "1".substr($anio,2).Utilidades::setToken(($dias+1),3,"0");
    }
    
    public static function formatMoneda($valor, $conDecimales = true){
        $decimales = ($conDecimales) ? 2 : 0;
        return number_format($valor,$decimales,',','.');
        
    }
    
    public static function truncar($cadena, $posicion){
        if(strlen($cadena) > --$posicion){
            $cadena = substr($cadena, 0,$posicion);
        }
        return $cadena;
    }
    
    public static function meses($mes = ""){
        $meses       = array();
        $meses["01"] = "Enero";
        $meses["02"] = "Febrero";
        $meses["03"] = "Marzo";
        $meses["04"] = "Abril";
        $meses["05"] = "Mayo";
        $meses["06"] = "Junio";
        $meses["07"] = "Julio";
        $meses["08"] = "Agosto";
        $meses["09"] = "Septiembre";
        $meses["10"] = "Octubre";
        $meses["11"] = "Noviembre";
        $meses["12"] = "Diciembre";
        
        if ($mes != "") {
            return (isset($meses[$mes])) ? $meses[$mes] : '';
        }
        
        return $meses;
    }
    
    public static function camposTbfecha($periodo){
        $campos   = array();
        $campos[Ambiente::$DIARIO]     = "DIA";
        $campos[Ambiente::$SEMANAL]    = "SEMANA";
        $campos[Ambiente::$QUINCENAL]  = "QUINCENA";
        $campos[Ambiente::$MENSUAL]    = "MES";
        $campos[Ambiente::$BIMESTRAL]  = "BIMESTRE";
        $campos[Ambiente::$TRIMESTRAL] = "TRIMESTRE";
        $campos[Ambiente::$SEMESTRAL]  = "SEMESTRE";
        $campos[Ambiente::$ANUAL]      = "ANIO";
        $campos[Ambiente::$JULIANA]    = "JULIANA";
        return $campos[$periodo];
    }  
    
    public static function descripcionFecha($fecha = ""){
        list($anio, $mes, $dia) = (strlen($fecha) == 8) ? Utilidades::splitPosition($fecha, array(4,6)) : preg_split('/\W+/', $fecha);
        
        return "$dia de ".Utilidades::meses($mes)." del $anio";
    }
    
    public static function privateJson($objeto){
        $toJson  = array();
        
        if(is_object($objeto)){    
            $metodos = get_class_methods($objeto);       
            foreach($metodos as $metodo){
                if(preg_match('/^get/', $metodo)){
                    $atributo = strtolower((str_replace('get', '', $metodo)));
                     $value   = $objeto->$metodo();
                     if(is_array($value) || is_object($value))
                         $value = Utilidades::privateJson($value);
                     $toJson[$atributo] = $value;
                }
            }
        } elseif(is_array($objeto)){
            foreach($objeto as $value){
                $toJson[] = Utilidades::privateJson($value);
            }
        }      
        return $toJson;
    }

    public static function matrizToVector($matriz, $setNull = false){
        $vector = array();
        $matriz = (array) $matriz; 
        foreach($matriz as $key=>$value){
            if(is_array($value) || is_object($value)){
                $vector   = array_merge($vector, Utilidades::matrizToVector($value, $setNull));
            } else {
                if($setNull || ($value !== null && $value !== ''))
                    $vector[] = $value;
            }
        }
        return $vector;
    }
    
    public static function festivos($anio, $anioHasta = '2037'){
        $festivos = new festivos();
        $diasFestivos     = array();
        
        for($anio; $anio <= $anioHasta; $anio++)
            $diasFestivos[$anio] = $festivos->diasFestivos($anio);    
        
        return $diasFestivos;
        
    }
    
    public static function replaceSpecialChar($subject){
        $search = array("á","à","â","ã","ª","Á","À","Â","Ã",
                        "é","è","ê","É","È","Ê",
                        "í","ì","î","Í","Ì","Î",
                        "ó","ò","ô","õ","º","Ó","Ò","Ô","Õ",
                        "ú","ù","û","Ú","Ù","Û","ñ","Ñ");

        $replace = array("a","a","a","a","a","A","A","A","A",
                         "e","e","e","E","E","E",
                         "i","i","i","I","I","I",
                         "o","o","o","o","o","O","O","O","O",
                         "u","u","u","U","U","U","n","N");

        return str_replace($search, $replace, $subject);
    }
    
    public function igualContenido($arregloUno, $arregloDos, $mismaLlave = false){
        $arregloUno = (array) $arregloUno;
        $arregloDos = (array) $arregloDos;
        if(count($arregloUno) == count($arregloDos)){
            foreach($arregloUno as $keyUno=>$dataUno){            
                if($mismaLlave && !isset ($arregloDos[$keyUno]) || $mismaLlave &&  $arregloDos[$keyUno] != $dataUno)
                    return false;
                else if(!$mismaLlave && !in_array($dataUno, $arregloDos))
                    return false;                
            }
        } else 
            return false;
        return true;        
    }

    public static function getMonthDays($Month, $Year){
        return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
    }

    public static function getFechaValida($fecha){

        if ($fecha != '' && $fecha != '0000-00-00')
            return date("Y-m-d", strtotime($fecha));
        return "--";
    }

    public static function getUltimoDiaMes($fecha){

        if ($fecha != '' && $fecha != '0000-00-00')
            return date("Y-m-t", strtotime($fecha));
        return "--";
    }

    public static function diferenciaFechas($fechaA, $fechaB){

        $date = new DateTime();

        $fechaInicial = new DateTime($fechaA);
        $fechaFinal = new DateTime($fechaB);

        $interval =  $fechaInicial->diff($fechaFinal);

        return $interval->format('%y');

    }

    public static function mostrarAuditoria($objeto){
        $divAuditoria  = "<div class='divAuditoria'>";
        $divAuditoria .= "<h3>Ultima modificacion</h3>";
        $divAuditoria .= "  <table>";
        $divAuditoria .= "      <tr class='listado1'>";
        $divAuditoria .= "          <td>Direccion IP</td>";
        $divAuditoria .= "          <td>".$objeto->getAudirip()."</td>";
        $divAuditoria .= "      </tr>";
        $divAuditoria .= "      <tr class='listado1'>";
        $divAuditoria .= "          <td>Fecha</td>";
        $divAuditoria .= "          <td>".$objeto->getAufecmod()."</td>";
        $divAuditoria .= "      </tr>";
        $divAuditoria .= "      <tr class='listado1'>";
        $divAuditoria .= "          <td>Hora</td>";
        $divAuditoria .= "          <td>".$objeto->getAuhormod()."</td>";
        $divAuditoria .= "      </tr>";
        $divAuditoria .= "      <tr class='listado1'>";
        $divAuditoria .= "          <td>Nombre del equipo</td>";
        $divAuditoria .= "          <td>".$objeto->getAunomequip()."</td>";
        $divAuditoria .= "      </tr>";
        $divAuditoria .= "      <tr class='listado1'>";
        $divAuditoria .= "          <td>Usuario</td>";
        $divAuditoria .= "          <td>".$objeto->getUscodusuar()."</td>";
        $divAuditoria .= "      </tr>";
        $divAuditoria .= "      <tr class='listado1'>";
        $divAuditoria .= "          <td>Estado del registro</td>";
        $divAuditoria .= "          <td>".$objeto->getAucodestad()."</td>";
        $divAuditoria .= "      </tr>";
        $divAuditoria .= "  </table>";
        $divAuditoria .= "</div>";   
        echo $divAuditoria;
    }

    public static function cargarEntidades($facade, $descripcion = '', $aucodestad = 'A', $order = ''){

        $setDescripcion = 'set'.ucfirst(strtolower($descripcion));
        $getDescripcion = 'get'.ucfirst(strtolower($descripcion));

        $filtros        = ($aucodestad != '') ? array(" and aucodestad = '$aucodestad'") : array();
        $filtros[]      = ($order != '') ? " ORDER BY $order" : '';

        $tablaFacade = FactoryFacade::getFacade($facade);

        $entidades = $tablaFacade->findEntitiesDos(array(),$filtros);

        if($descripcion != ''){
            foreach($entidades as $entidad){
                $entidad->$setDescripcion(ucfirst(strtolower($entidad->$getDescripcion())));
            }
        }

        return $entidades;
    }
    
    public static function columnToRow($colums, $setNull = true, $columnKey = null){
        $columsToRow = array();
        
        foreach((array)$colums as $keyColum => $colum){
            foreach($colum as $key=>$value){
                if($setNull || $value != ''){
                    if(!isset($columsToRow[$key]))
                        $columsToRow[$key] = array();
                    $columsToRow[$key][$keyColum] = $value;
                }
            }
        }
        
        if($columnKey)
            return isset($columsToRow[$columnKey]) ? $columsToRow[$columnKey] : array();
        
        return $columsToRow;
    }

    public static function entities($value, $key){
        echo $value;
    }

    public static function diccionarioBancos($banco = NULL){
        $bancos       = array();
        $bancos['01'] = $bancos['36'] = 'Bogota';
        $bancos['05'] = $bancos['34'] = $bancos['51'] = 'Davivienda';
        $bancos['10'] = 'HSBC';
        $bancos['19'] = 'Colpatria';
        $bancos['23'] = 'Occidente';
        $bancos['40'] = 'Agrario';       
        $bancos['57'] = 'CajaSocial';
        $bancos['58'] = 'Bancolombia';
        $bancos['59'] = 'Helm';
        $bancos['61'] = 'Citibank';
        $bancos['60'] = $bancos['99'] = 'AVVillas';
        
        return $banco ? $bancos[$banco] : array_unique($bancos);
    }

    public static function getNombreBanco($banco){
        $bancos               = array();
        $bancos['Bogota']     = "BANCO DE BOGOTA";
        $bancos['Davivienda'] = "DAVIVIENDA";
        $bancos['HSBC']       = 'HSBC';
        $bancos['Colpatria']  = 'COLPATRIA';
        $bancos['Occidente']  = 'BANDO DE OCCIDENTE';
        $bancos['Agrario']    = 'BANCO AGRARIO';       
        $bancos['CajaSocial'] = 'BANCO CAJA SOCIAL';
        $bancos['Bancolombia']= 'BANCOLOMBIA';
        $bancos['Helm']       = 'HELM';
        $bancos['Citibank']   = 'CITIBANK';
        $bancos['AVVillas']   = 'AV VILLAS';
        return $bancos[$banco];
    }

    public static function diasNoHabiles($fechaIni, $fechaFin){

        $timeIni = strtotime($fechaIni);
        $timeFin = strtotime($fechaFin);

        if($timeIni > $timeFin){
            $cantidadDias = ($timeIni - $timeFin) / 86400;            
        } else {
            $cantidadDias = ($timeFin - $timeIni) / 86400;
        }

        $festivos = Utilidades::festivos(date('Y'), date('Y'));

        $diasNoHabiles = array();

        for ($index = 0; $index <= $cantidadDias; $index++) {

            $date = date('N', mktime(0,0,0,date('n', strtotime($fechaIni)), date('d', strtotime($fechaIni)),date('Y', strtotime($fechaIni))));

            $anioMes = date('Y', strtotime($fechaIni)) . '-' . intval(date('m', strtotime($fechaIni)));

            if(isset ($festivos[date('Y')][$anioMes]))
                $festivosMes = $festivos[date('Y')][$anioMes];
            else
                $festivosMes = array();

            if (($date == 6 || $date == 7) || (array_key_exists(intval(date('d', strtotime($fechaIni))), $festivosMes))){
                $diasNoHabiles[] = $fechaIni;
            }

            $fechaIni = date("Y-m-d", strtotime("$fechaIni +1 day"));

        }

        return $diasNoHabiles;
    }

    public static function getCantidadSemanas($fechaDesde, $fechaHasta){

        $divideFecha = explode("-", $fechaDesde);

        $fechaDesdeTime = mktime(0, 0, 0, $divideFecha[1], $divideFecha[2], $divideFecha[0]); //Convertimos $fechaDesde en formato timestamp

        $divideFecha = explode("-", $fechaHasta);

        $fechaHastaTime = mktime(0, 0, 0, $divideFecha[1], $divideFecha[2], $divideFecha[0]); //Convertimos $fechaDesde en formato timestamp

        $segundos = $fechaDesdeTime - $fechaHastaTime; // Obtenemos los segundos entre esas dos fechas
        $segundos = abs($segundos); //en caso de errores

        $semanas = floor($segundos / 604800); //Obtenemos las semanas entre esas fechas.

        return $semanas;
    }
    
    
    public static function getKeysPorPatron($array, $patron){       
        return Utilidades::keysPorPatron($array, $patron);
    }
    
    public static function unsetKeysPorPatron($array, $patron){       
        return Utilidades::keysPorPatron($array, $patron, true);
    }  
    
    public static function keysPorPatron($array, $patron, $unset = false){
        foreach(array_keys($array) as $key)
            if(!(preg_match($patron, $key) xor $unset))
                unset($array[$key]);
        
        return $array;
    }


    public static function getTipoPedido($codigo){
        $tipoPedido = array();
        $tipoPedido['1']     = "ACTIVOS";
        $tipoPedido['2'] = "GENERAL";
        $tipoPedido['3']       = 'IMPREVISTOS';
        $tipoPedido['4']  = 'MAMI';
        $tipoPedido['5']  = 'PROYECTO';
        $tipoPedido['6']  = 'INTANGIBLES';
        $tipoPedido['7']  = 'SERVICIOS DE INFORMATICA';
        return $tipoPedido[$codigo];
    }

    public static function diasHabiles($fechaIni, $fechaFin){

        $timeIni = strtotime($fechaIni);
        $timeFin = strtotime($fechaFin);

        if($timeIni > $timeFin){
            $cantidadDias = ($timeIni - $timeFin) / 86400;
        }else{
            $cantidadDias = ($timeFin - $timeIni) / 86400;
        }

        $festivos = Utilidades::festivos(date('Y'), '2016');
        
        $diasHabiles = array();

        for ($index = 0; $index <= $cantidadDias; $index++) {

            $date = date('N', mktime(0,0,0,date('n', strtotime($fechaIni)), date('d', strtotime($fechaIni)),date('Y', strtotime($fechaIni))));

            $anioMes = date('Y', strtotime($fechaIni)) . '-' . intval(date('m', strtotime($fechaIni)));

            if(isset ($festivos[date('Y')][$anioMes]))
                $festivosMes = $festivos[date('Y')][$anioMes];
            else
                $festivosMes = array();

            if (($date != 6 && $date != 7) && (!array_key_exists(intval(date('d', strtotime($fechaIni))), $festivosMes))){
                $diasHabiles[] = $fechaIni;
            }

            $fechaIni = date("Y-m-d", strtotime("$fechaIni +1 day"));

        }

        return $diasHabiles;
    }
}