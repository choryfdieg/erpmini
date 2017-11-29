<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ambiente
 *
 * @author cirsisdgr
 */
class Ambiente {

    public static $SERVIDOR       = "localhost";
    public static $DB             = "erpmini";
    public static $USER           = "root";
    public static $PASS           = "1234";
//    public static $HOSTUPLOADS    = "http://administrativa.comfamiliar.com";
//
//    public static $APPPATH        = "/home/www/administrativa/public_html";
//    public static $PUBLICDIR      = "";
        
    public static $HOSTUPLOADS    = "http://localhost/administrativa/administrativa";

    public static $APPPATH        = "/var/www/administrativa/administrativa";
    public static $PUBLICDIR      = "public_html";
    public static $DIRDATOSAPP    = "datos_aplicacion";
    public static $DIRORDENPAGO   = "orden_pago";

    
    // ***
    // FECHA PPITEMS
    public static $MESBASEPPITEMS  = "03";
    public static $DIABASEPPITEMS  = "01";
    // MOTIVOS GENERALES
    public static $MOTIVOACTIVO    = "01";
    public static $MOTIVOINACTIVO  = "02";
    
    //LISTAMESES
    static public $LISTANOMBREMESES = array(1=>'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
    
    // ***
    // ESTADOS
    public static $ESTADOACTIVO    = "A";
    public static $ESTADOINACTIVO  = "I";
    
    // ***
    // ESTADOS PRESUPUESTO
    public static $PEDIDO          = "PEDIDO";
    public static $NOPEDIDO        = "NO PEDIDO";
    
    // MOTIVOS TBPEDIDO
    public static $MOTIVOPEDIDOSOLICITADO      = "01";
    public static $MOTIVOPEDIDOAUTORIZADO      = "02";
    public static $MOTIVOPEDIDODEVUELTO        = "09";
    //INTERFACE ORDEN DE PAGO
    public static $TIPODOCINTEFACEORDENPG      = "PC";
    public static $CUENTAOBJETOORDENPGDEFAULT  = "233505";
    public static $SUBCUENTAORDENPGDEFAULT     = "02";
    // ***
    // MOTIVOS TBPPITEM
    public static $MOTIVOTBPPITEMPENDIENTE     = '01';
    public static $MOTIVOTBPPITEMPRESUPUESTADO = '02';
    public static $MOTIVOTBPPITEMNOAPROBADO = '03';
    public static $MOTIVOTBPPITEMPRIORIZADO = '04';
    public static $MOTIVOTBPPITEMINACTIVO = '05';
    public static $MOTIVOTBPPITEMNEGOCIADOGESTOR = '07';
    
    // ***
    // MOTIVOS TBPEDITEM
    public static $MOTIVOTBPEDITEMSOLICITADO = '00';
    public static $MOTIVOTBPEDITEMPEDIDO = '01';
    public static $MOTIVOTBPEDITEMAUTORIZADO = '02';
    public static $MOTIVOTBPEDITEMCOTIZADO = '03';
    public static $MOTIVOTBPEDITEMNEGOCIADO = '04';
    public static $MOTIVOTBPEDITEMPAGADO = '05';
    public static $MOTIVOTBPEDITEMREINTEGRO = '06';
    public static $MOTIVOTBPEDITEMABORTADO = '07';
    public static $MOTIVOTBPEDITEMNOAUTORIZADOSUB = '08';
    public static $MOTIVOTBPEDITEMNOAUTORIZADOALM = '09';
    public static $MOTIVOTBPEDITEMORDENPROVEEDOR = '18';
    public static $MOTIVOTBPEDITEMRECEPCIONBODEGA = '24';
    public static $MOTIVOTBPEDITEMENPRIORIZACION = '25';
    public static $MOTIVOTBPEDITEMENTREGADO = '28';
    public static $MOTIVOTBPEDITEMNEGOCIADOGESTOR = '20';
    
    // MOTIVOS TBORDENPG
    public static $MOTIVOTBORDENPGCREACION       = '00';
    public static $MOTIVOTBORDENPGPENDIENTE      = '01';
    public static $MOTIVOTBORDENPGREVISIONSUB    = '02';
    public static $MOTIVOTBORDENPGREVISIONCONT   = '03';
    public static $MOTIVOTBORDENPGASIGNADOCONT   = '04';
    public static $MOTIVOTBORDENPGEXTRACCIONTESO = '05';
    public static $MOTIVOTBORDENPGEJECUTADO      = '06';
    public static $MOTIVOTBORDENPGRECHAZADO      = '07';
    // ***
    // MOTIVOS PRESUPUESTO PERSONAL TBPPTOPERS
    public static $MOTIVOPERSONALNUEVO       = 'PN';
    public static $MOTIVOPERSONALPENDIENTE      = 'PP';
    public static $MOTIVOPERSONALEXISTENTE    = 'PE';
    // ***
    // COMPAÑIAS IVA TIPO C
    public static $COMPANIASIVATIPOC = array('23','25','26');
    // 
    // CODIGOS DE PROCESOS
    public static $PROCESOSUBDIRECCION = '2000';
    public static $PROCESOALMACEN = '2310';
    // ***
    // Lista Si/No
    public static $SI = 'S';
    public static $NO = 'N';
    // LISTA PERIODOS
    public static $DIARIO     = 1;
    public static $SEMANAL    = 2;
    public static $QUINCENAL  = 3;
    public static $MENSUAL    = 4;
    public static $BIMESTRAL  = 5;
    public static $TRIMESTRAL = 6;
    public static $SEMESTRAL  = 7;
    public static $ANUAL      = 8;
    public static $JULIANA    = 9;
    // ***
    // Tipo de pedidos
    public static $TIPOACTIVOFIJO = 1;
    public static $TIPOGENERAL    = 2;
    public static $TIPOIMPREVISTO = 3;
    public static $TIPOMAMI = 4;
    public static $TIPOPROYECTO = 5;
    public static $TIPOINTANGIBLE = 6;
    public static $TIPOSERVICIOSINFORMATICA = 7;
    // ***
    // Rutas
    public static $PREFIJODETALLEORDEN = "Detalles-OP-";
    public static $PREFIJODISTRIBUCIONORDEN = "Distribucion-OP-";
    public static $OPTIPODETALLE = "1";
    public static $OPTIPODISTRIBUCION = "2";
    // ***
    public static $RUTAPEDIDOS = "/home/administrativa/public_html/datos_aplicacion/pedidos/";
    // ***
    // Ubicaciones ordenes de pago
    public static $OPUBICACIONPROC = "PROC";
    public static $OPUBICACIONCONT = "CONT";
    public static $OPUBICACIONTESO = "TESO";
    // ***
    // Listas
    public static $LISTATIPOPEDIDO = "1";
    public static $LISTAACTIVOINACTIVO = "4";
    public static $LISTAUBICACIONOP = "8";
    public static $LISTASINO = "9";
    public static $DETALLEPEDIDOGENERAL = "10";
    public static $LISTAAFIMP = "12";
    public static $LISTANIVELES  = "13";
    public static $LISTAPERIODOS = "14";
    public static $LISTATIPOSCONCEPTO = "15";
    public static $CLASIFICACIONTIPOSDOCUMENTO = "18";
    public static $LISTALINEADECOMPRAS = "19";
    public static $LISTATIPOSDOCUMENTOS = "22";
    public static $ESTADOPERSONAL = "23";
    public static $CATEGORIAS = "27";
    public static $TIPOSCLIENTE = "28";
    public static $TIPOPROYECTOACTIVOS = "29";
    public static $TIPODETALLETARIFA = "30";
    public static $GENEROS = "31";
    public static $DESCUENTOSUBSIDIO = "35";
    public static $ITEMNACIONALIDAD = "39";
    
    // ***
    // Grupos
    public static $JEFEPROCESO = "2";
    public static $GRSUBDIRECTOR = "3";
    public static $AUXILIARCONTABLE = "4";
    public static $ADMINISTRADORSISTEMA = "5";
    public static $SUBDIRECTORDEACTIVOS = "6";
    public static $GRCOMPRADOR = "7";
    public static $ASIGNACIONCONTABLE = "8";
    public static $TESORERO = "9";
    public static $JEFECONTABLE = "10";
    public static $BASICOPEDIDO = "11";
    public static $BASICOPPTO = "12";
    public static $AUDITOR = "13";
    public static $AUXADMCOMPRAS = "14";
    public static $BASICOGESTORES = "15";
    public static $USUARIOBODEGA = "16";
    public static $DEVOLVERPEDIDO = "17";
    public static $GESTORCUENTA = "19";
    public static $REPORTES = "20";
    public static $MODIFICARPPTO = "21";
    public static $ADMINSICERVA = "18";
    public static $AUXSICERVA = "22";
    public static $AUXSUBDIRECCION = "23";
    public static $REPORTESMUF = "24";
    public static $REPORTESCONCILIACION = "25";
    public static $ADMINMUF = "26";
    public static $BASICOCOMPRAS = "27";
    public static $COMPRADORINTANGIBLES = "28";
    public static $RESTRICCIONPEDIDOS = "29";
    public static $SOPORTESISTEMAS = "30";
    
    //FLUJO DE CAJA
    public static $INGRESOS                 = 'I';
    public static $EGRESOS                  = 'E';
    public static $ITEMESTADONUEVO          = '01';
    public static $ITEMESTADOINCORRECTO     = '02';
    public static $ITEMESTADOCORRECTO       = '03';
    public static $ITEMESTADOEDITADO        = '04';
    public static $ITEMESTADOSINMOVIMIENTOS = '05'; 
    public static $ITEMESTADONOEXISTE       = '11'; 
    public static $CONCILIACIONACTIVA       = '00';
    public static $CONCILIACIONCERRADA      = '01';
    // PATRONES AREAS
    public static $ITEMNOREGISTRADO         = '06';
    public static $ITEMREGISTRADO           = '07';
    public static $ITEMNOEXISTENTE          = '08';
    public static $ITEMENOTRAAREA           = '09';
    public static $ITEMNOCUMPLEPATRON       = '10';
    
    public static $ITEMESTADOSNOVALIDO      = 'N';
    public static $ITEMESTADOSVALIDO        = 'V';
    
    public static $CUENTAOBJETOBANCOS       = array('1110%', '1120%');
    public static $LIBROCUENTACORRIENTE     = 'AA';

    public static $DIASABADO     = '6';
    public static $DIADOMINGO       = '0';

    public static $INDICADORACTIVOS    = 2;

    public static $NODEFINIDO = "No definido";

    public static $MESES = array("1" => "Ene", "2" => "Feb", "3" => "Mar", "4" => "Abr",
            "5" => "May", "6" => "Jun", "7" => "Jul", "8" => "Ago",
            "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic");
    
    //CONCILIACIONES
        
        //NIT COMFAMILIAR
        public static $NITCOMFAMILIAR = '891.480.000-1';
        
        //INFORME CONCILIACION
        public static $CODIGOINFORMECONCILIACION   = '1-FT-197';
        public static $VERSIONINFORMECONCILIACION  = '2';
        public static $VIGENCIAINFORMECONCILIACION = '2015-06-16';
        public static $TITULOINFORMECONCILIACION   = 'CONCILIACIÓN BANCARIA';

        //SEPARADORES ESTRUCTURAS CONCILIACIONES
        public static $ESPACIOBLANCO = '\s';
        public static $TABULADOR     = '\t';
        
        //ORIGENES ESTRUCTURAS
        public static $ESTRUCTURAORIGENUSUARIO = 'U';
        public static $ESTRUCTURAORIGENSISTEMA = 'S';
        
        //CANTIDAD DE REGISTROS PREVIEW
        public static $CANTIDADREGISTROSPREVIEW = 5;
        
        //LISTA CAMPOS MOVIMIENTOS CONCILIACION
        public static $CAMPOSMOVIMIENTOCONCILIACION = 30;
        
        //CAMPOS TABLA MOVIMIENTOS CONCILIACION
        public static $FECHAMOVICONCILIACION     = 2;
        public static $VALORMOVICONCILIACION     = 3;
        public static $DOCMOVICONCILIACION       = 4;
        public static $NUMDOCMOVICONCILIACION    = 5;
        public static $DESCRIPMOVICONCILIACION   = 6;
        public static $FECHAREALMOVICONCILIACION = 7;
        
        //ORIGEN MOVIMIENTOS CONCILIACIONES
        public static $ORIGENEXTRACTO = 'E';
        public static $ORIGENLIBROS   = 'L';
        
        //LISTA NATURALEZA MOVIMIENTOS
        public static $NATURALEZAMOVIMIENTO = 33;
        public static $POSITIVOS = 'P';
        public static $NEGATIVOS = 'N';
        
        //LISTA TIPOS CRUCE MOVIMIENTOS
        public static $TIPOSCRUCECONCILIACION = 34;
        public static $TIPOCRUCEDOCUMENTO = 1;
        public static $TIPOCRUCEFECHAREAL = 2;
        public static $TIPOCRUCEFECHALM   = 3;
        
        //CANTIDAD DE MOVIMIENTOS A MOSTRAR EN LA CONCILIACION PAGINAR
        public static $CANTIDADMOVIMIENTOS = 30;
        
        //

    public static $AÑOFISCAL2013 = "3";
    public static $AÑOFISCAL2014 = "4";

    public static $NUEVOCARGO = "-1";

    // TIPOS PROCESOS USUARIOS - TBPROCESOS->PROTIPO
    public static $PROCESOPADRESUBDIRECCION = "PPS";

    // MOTIVOS TBDETSICER
    public static $MOTIVODETALLE = "03";
    // PARAMETROS SICERVA
    public static $EDADADULTO = "11";

    public static $MENSAJEFICHA = "No Se ha seleccionado una ficha tecnica";

    public static $INCIDENCIAPEDIDOMOTIVO = "MO";
    public static $INCIDENCIAPEDIDOASIGNACION = "AS";
    public static $INCIDENCIAPEDIDOCOMPLETO = "PC";
    public static $INCIDENCIAPEDIDOINCOMPLETO = "PI";
    
    // INTERFACES JDE
    
    public static $INTERFACEARTICULOS = "ARTICULO";
}
