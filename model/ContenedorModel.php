<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContenedorModel
 *
 * @author cirsisjgp
 */

include_once 'work/security/WorkSecurityUI.php';

class ContenedorModel {

    public $modulo;
    public $control;
    public $file;
    public $accion;
    public $login;
    public $api = "api.php";
    public $params = array();
    
    function ContenedorModel() {
        
        $direccion = $this->getUrl();
        
        $this->modulo = (!empty ($direccion[0])) ? $direccion[0]   : 'home';      
        $this->file   = (!empty ($direccion[1])) ? $direccion[1]   : 'home';
        $this->accion = (!empty ($direccion[2])) ? $direccion[2]   : '';
        
        $this->control = $this->file;
        
        // de la posicion 2 en adeltante son parametros
        $this->params = array();
        
        for ($index = 2; $index < count($direccion); $index++) {
            if(isset($direccion[++$index]) && isset($direccion[($index + 1)])){                
                $this->params[$direccion[$index]] = $direccion[($index + 1)];
            }
        }
        
        if(stripos($_SERVER['REQUEST_URI'],$this->api) == false){
            $this->cargarUsuario();
        }

    }
    
    private function cargarUsuario() {
        if($this->login == null)
            $this->login = $_SESSION['login'];
    }    

    /**
     * Retorna verdadero cuando el usuario esta autenticado
     * @return <boolean>
     */
    function isAutenticado() {        
        if ($this->login != ''){            
            return true;
        }else{
            return false;
        }
    }
    
    function cuerpo() {        
        $this->ejecutarControl();
    }

    function menu($modulo = null){        
        if($modulo)
            include_once("view/$modulo/menu.php");
    }

    /**
     * Busca el archivo "control/"$file."Control.php" y ejecuta la $accion;
     */
    function ejecutarControl(){

        $esApi = false;
        $method = 'GET';
        
        if(strpos($_SERVER['SCRIPT_NAME'], 'api.php')){
            $esApi = true;
            $method = strtoupper($_SERVER['REQUEST_METHOD']);
            
            if($method == 'PUT'){
                $_SERVER['REQUEST_METHOD']=== $method ? parse_str(file_get_contents('php://input', false , null, -1 , $_SERVER['CONTENT_LENGTH'] ), $_PUT): $_PUT=array();
            }
            
            if($method == 'DELETE'){
                $_SERVER['REQUEST_METHOD']=== $method ? parse_str(file_get_contents('php://input', false , null, -1 , $_SERVER['CONTENT_LENGTH'] ), $_DELETE): $_DELETE=array();
            }
            
        }
        
        if($this->modulo == 'builder'){
            $carpetaControladores = "work/".$this->modulo.'/';
        }else{
            $carpetaControladores = "control/".$this->modulo.'/';            
        }


        //Si no se indica una accion, esta accion es la que se usará
        $controlador = $this->file;
        $accion      = (trim($this->accion) == '') ? 'index' : $this->accion;
        
        //Ya tenemos el controlador y la accion
        //Se crea la clase

        $clase = ($this->modulo == 'builder') ? $controlador : $controlador.'Control';
        
        
        
        //Formamos el nombre del fichero que contiene nuestro controlador
        $controlador = $carpetaControladores . $controlador . (($this->modulo == 'builder') ? '' : 'Control') . '.php';

        //Incluimos el controlador o detenemos todo si no existe        
        
        if(is_file($controlador))
              require_once $controlador;
        else{
              die('El controlador no existe - 404 not found');
        }
        
        $instancia = new $clase();
        
        if($esApi){
            $accion = strtolower($method) . ucfirst($accion);                                
        }
        
        if (in_array($accion, get_class_methods($instancia))){
            
            $params = null;
            $paramsArray = array();
            
            switch ($method) {
                case 'GET':
                    $params = (!empty($_GET)) ? (object) $_GET : ((!empty($_POST)) ? (object) $_POST : null);
                    break;
                
                case 'POST':
                    $params = (object) $_POST;
                    break;
                
                case 'PUT':
                    $params = (object) $_PUT;
                    break;
                
                case 'DELETE':
                    $params = (object) $_DELETE;
                    break;

                default:
                    break;
            }
            
            if(!empty($this->params) && $params == null){
                $params = (object)$this->params;
            }
            
            $paramsArray = (array) $params;
            
            $reflector = new ReflectionClass($instancia);
            $docComment = $reflector->getMethod($accion)->getDocComment();
            
            $pattern = '/.*(@param\s+(\w+\/?)*)/';
 
            preg_match_all($pattern, $docComment, $result);
            
            $paramsDocArray = array();
            
            if(isset($result[1][0])){
                $paramsDoc = trim(str_replace('@param', '', trim($result[1][0])));
                $paramsDocArray = explode('/', $paramsDoc);
                
            }
            
            $arrayDiff = array_diff(array_keys($paramsArray), array_values($paramsDocArray));
            
            $valuesParamsDoc = array_values($paramsDocArray);
            
            if(!empty($valuesParamsDoc) && (!empty($arrayDiff) || (count(array_keys($paramsArray)) !== count(array_values($paramsDocArray))))){
                echo "Error. No existe la ruta especificada";
            }else{            
                $instancia->$accion($params);            
            }
            
        }else{
            if($esApi){
                header('HTTP/1.0 505 Error. No existe la ruta especificada', true, 505);            
            }else{
                echo "Error. No existe la ruta especificada";
            }
        }
    }

    public static function getIpCliente() {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function getHostNameCliente() {
        return preg_replace("/\..*/", "", gethostbyaddr($_SERVER['REMOTE_ADDR']));
    }

    public function getLogin(){
        return $this->login ? $this->login : $_SESSION['login'];
    }
    
    public function getUrl() {
        
        $parametros = array();
        
        if(stripos($_SERVER['REQUEST_URI'],$this->api) !== false)
            session_start();

        $url = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : '';
        
        foreach (explode("/", $url) as $path)                
            if ($path != '')                
                $parametros[] = $path;
                             
        return $parametros;
    }    
    
    public function getJsModulo(){   
        
        if(file_exists('view/' . $this->modulo . '/' . $this->control . '/scripts.php')){        
            include 'view/' . $this->modulo . '/' . $this->control . '/scripts.php';
        }
        
        if(file_exists('view/' . $this->modulo . '/scripts.php')){        
            include 'view/' . $this->modulo . '/scripts.php';
        }
        
        return '';
    }
    
    public function getCssModulo(){
        
        if(file_exists('view/' . $this->modulo . '/' . $this->control . '/styles.php')){        
            include 'view/' . $this->modulo . '/' . $this->control . '/styles.php';
        }
        
        if(file_exists('view/' . $this->modulo . '/styles.php')){        
            include 'view/' . $this->modulo . '/styles.php';
        }
        
        return '';
    }
}