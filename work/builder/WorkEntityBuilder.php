<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wEntityBuilder
 *
 * @author choryfdieg
 */

require_once 'model/AbstractFacade.php';


class WorkEntityBuilder extends AbstractFacade{

    public $entities = null;
    
    function WorkEntityBuilder(){
        
        $this->entities = array();
        
        $this->entities['sistema'] = array();
        $this->entities['negocio'] = array();
        $this->entities['contabilidad'] = array();
        $this->entities['crm'] = array();
        $this->entities['kardex'] = array();
        $this->entities['ingresos'] = array();
        
        $this->entities['sistema'][] = 'a_estado';
        $this->entities['sistema'][] = 'apelativo';
        $this->entities['negocio'][] = 'apertura_caja';
        $this->entities['negocio'][] = 'caja_sucursal';
        $this->entities['contabilidad'][] = 'centro_costo';
        $this->entities['sistema'][] = 'ciudad';
        $this->entities['negocio'][] = 'clasificador_ficha_tecnica';
        $this->entities['contabilidad'][] = 'compania';
        $this->entities['crm'][] = 'contactos';
        $this->entities['sistema'][] = 'estado_caja';
        $this->entities['ingresos'][] = 'factura';
        $this->entities['ingresos'][] = 'factura_forma_pago';
        $this->entities['ingresos'][] = 'factura_producto';
        $this->entities['ingresos'][] = 'factura_producto_saldo';
        $this->entities['ingresos'][] = 'factura_producto_saldo_detalle';
        $this->entities['negocio'][] = 'ficha_tecnica';
        $this->entities['ingresos'][] = 'forma_pago';
        $this->entities['negocio'][] = 'grupo_unidad_medida';
        $this->entities['negocio'][] = 'impuesto';
        $this->entities['kardex'][] = 'kardex';
        $this->entities['negocio'][] = 'numero_factura';
        $this->entities['sistema'][] = 'pais';
        $this->entities['negocio'][] = 'producto';
        $this->entities['contabilidad'][] = 'puc';
        $this->entities['sistema'][] = 'region';
        $this->entities['kardex'][] = 'saldos_promedio_ponderado';
        $this->entities['negocio'][] = 'sucursal';
        $this->entities['negocio'][] = 'tarifa';
        $this->entities['crm'][] = 'tercero';
        $this->entities['sistema'][] = 'tipo_documento';
        $this->entities['sistema'][] = 'tipo_factura';
        $this->entities['sistema'][] = 'tipo_movimiento_kardex';
        $this->entities['negocio'][] = 'unidad_medida';

    }
    
    public function index(){
        $rutas = $this->getRutas();
        include_once 'view/builder/wEntityBuilder.php';
    }
    
    public function getRutas(){
        $directorio = './control/';
        $ficheros  = scandir($directorio, 1);
        
        $rutas = array();
        
        foreach ($ficheros as $modulo) {            
            
            $controles = array();
            
            if($modulo !== '.' && $modulo !== '..'){
                
                $controles  = scandir("./control/$modulo", 1);
                
                foreach ($controles as $control) {
                    
                    if($control !== '.' && $control !== '..'){
                        
                        include_once "control/{$modulo}/{$control}";
                        
                        $nombreControl = str_replace('.php', '', $control);
                        
                        $instancia = new $nombreControl();
                        
                        $rutas[$modulo][$nombreControl] = get_class_methods($instancia);
                        
                        unset($instancia);
                        
                    }
                }
                
            }
            
        }
        
        return $rutas;
        
    }

    public function createEntity(){
        
        $params = $_POST;
        
        if(empty($params)){
            echo "No se generaron datos";
            return false;
        }
        
        $this->schema = $params['esquema'];
        
        $abstractFacade = new AbstractFacade();

//        if($params['motor'] == 'mysql'){
//            $abstractFacade->setMotor(AbstractFacade::$MYSQL);
//            $sql = "describe $params[esquema].$params[tabla]";
//        }
//
//        $result = $abstractFacade->executeQuery($sql);
        
        
        foreach ($this->entities as $modulo => $entidades) {
            
            foreach ($entidades as $entidad) {
                $params = array();

                $params['esquema'] = 'erpmini';
                $params['tabla'] = $entidad;

                $abstractFacade->setMotor(AbstractFacade::$MYSQL);
                $sql = "describe $params[esquema].$params[tabla]";

                $result = $abstractFacade->executeQuery($sql);

                $this->buildEntity($result, $entidad, $modulo);
            }
        
        }
        
//        $this->buildEntity($result, $params['tabla'], $params['modulo']);
//        $this->buildFacade($params['tabla'], $params['modulo']);
//        $this->buildControl($params['tabla'], $params['modulo']);
//        $this->buildList($result, $params['tabla'], $params['modulo']);
//        $this->buildJs($params['tabla'], $params['modulo']);

        $this->index();

    }
    
    public function crearModulo($modulo){
        
        $appName = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
		
        $ruta = $_SERVER['DOCUMENT_ROOT'];
        $ruta .= $appName . $modulo;
        
        if(!file_exists($ruta)){
            mkdir($ruta, 0777, true);
        }
        
    }

    public function buildEntity($result, $entityName, $modulo){

        $this->crearModulo('model/'.$modulo . '/entity');
        
        $archivo = "";

        $archivo .= "<?php";

        $archivo .= "\n";
        $archivo .= "\n";

        $archivo .= "/*";
        $archivo .= "\n";
        $archivo .= "* To change this template, choose Tools | Templates";
        $archivo .= "\n";
        $archivo .= "* and open the template in the editor.";
        $archivo .= "\n";
        $archivo .= "*/";

        $archivo .= "\n";
        $archivo .= "\n";

        $archivo .="/**";
        $archivo .= "\n";
        $archivo .="* Description of " . ucfirst($entityName);
        $archivo .= "\n";
        $archivo .="*";
        $archivo .= "\n";
        $archivo .="* @author chory";
        $archivo .= "\n";
        $archivo .="* @date " . date('Y-m-d H:m:s');
        $archivo .= "\n";
        $archivo .="*/";
        
        $archivo .= "\n";
        $archivo .= 'require_once \'model/Entity.php\';';
        $archivo .= "\n";

        if(!empty ($result)){

            $archivo .= "\n";
            $archivo .= "\n";

            $archivo .= "class " . ucfirst($entityName) . " extends Entity{";

            $archivo .= "\n";
            $archivo .= "\n";

            foreach ($result as $fila){

                $fila = array_change_key_case($fila, CASE_LOWER);

                preg_match_all ("/(\(.*\))/", $fila['type'], $length);
                
                if($fila['key'] == 'PRI'){
                    
                    $archivo .= '   /**';
                    $archivo .= "\n   *";
                    $archivo .= "\n   * @id id";
                    $archivo .= "\n   * @autoincrement true";
                    $archivo .= "\n   * @type " . strtolower($fila['type']);
                    $archivo .= "\n   * @length " . $length[1][0];
                    $archivo .= "\n   */";
                }else{
                    $archivo .= '   /**';
                    $archivo .= "\n   *";
                    $archivo .= "\n   * @type " . strtolower($fila['type']);
                    $archivo .= "\n   * @length " . (isset($length[1][0]) ? $length[1][0] : '');
                    $archivo .= "\n   */";
                }
                
                $archivo .= "\n";
                
                $archivo .= "   ";
                $archivo .= 'public $' . strtolower($fila['field']) . ';';
                $archivo .= "\n";
                $archivo .= "\n";
                
            }
            
            $archivo .= "\n";
            $archivo .= "\n";
            
            $archivo .= '   ';
            
            $archivo .= "function " . ucfirst($entityName) . '($fieldsValues = array()) {';
            $archivo .= "\n";
            $archivo .= "       ";
            $archivo .= 'parent::__construct($fieldsValues);';
            $archivo .= "\n";
            $archivo .= "   ";
            $archivo .= "}";

            $archivo .= "\n";
            
            foreach ($result as $fila){
                
                $fila = array_change_key_case($fila, CASE_LOWER);

                $archivo .= "\n";
                $archivo .= "   ";

                
                
                $archivo .= "public function set" . ucfirst(strtolower($fila['field'])) . '($'. strtolower($fila['field']) ."){";
                $archivo .= "\n";
                $archivo .= "      ";
                $archivo .= '$this->' . strtolower($fila['field']) . ' = ' . '$' . strtolower($fila['field']) . ';';
                $archivo .= "\n";
                $archivo .= "   ";
                $archivo .= "}";

                $archivo .= "\n";
                $archivo .= "\n";
                $archivo .= "   ";

                $archivo .= "public function get" . ucfirst(strtolower($fila['field'])) . "(){";
                $archivo .= "\n";
                $archivo .= "       ";
                $archivo .= 'return $this->' . strtolower($fila['field']) . ';';
                $archivo .= "\n";
                $archivo .= "   ";
                $archivo .= "}";
                
                $archivo .= "\n";
                $archivo .= "\n";

            }

            $archivo .= "\n";
            
            $archivo .= "}";
            
        }

        $archivo .= "\n";
        $archivo .= "\n";

        $file = fopen("model/{$modulo}/entity/" . ucfirst($entityName).".php","a");

        fputs($file, $archivo);
        
        fclose($file);
    }
    
    public function createFixtures(){
        
        $params = $_POST;
        
        $cantidad = $params['cantidad'];
        
        $this->entidad = strtolower($params['tabla']);
        
        $className = ucfirst(strtolower($params['tabla']));

        $ruta = "model/{$params['modulo']}/entity/";
        
        require_once ($ruta . $className . '.php');
        
        $objectInstance = new $className(array());
        
        $keySet = array_keys(array_change_key_case(get_object_vars($objectInstance), CASE_UPPER));
        
        $object = new ReflectionObject($objectInstance);
        $properties = $object->getProperties();
        
        
        $nArray = array();
        
        foreach ($properties as $key => $value) {
            
            $docComment = $object->getProperty($value->name)->getDocComment();
            
            $parsedDocComment =  ltrim($docComment, "\r\n");

            preg_match_all ("/(@.*)/", $parsedDocComment, $docArray);

            foreach ($docArray[0] as $propertyDoc) {

                $doc = explode(' ', $propertyDoc);

                $nArray[$value->name][$doc[0]] = $doc[1];
            }
            
        }
        
        
        for ($i = 0; $i < $cantidad; $i++) {
            
            $objectInstance = new $className(array());
        
            foreach ($properties as $key => $value) {

                $attr = $value->name;

                if(strpos($nArray[$value->name]['@type'], 'int') !== false || strpos($nArray[$value->name]['@type'], 'int') !== false) {
                    $objectInstance->$attr = $this->getNumero(3);
                }

                if(strpos($nArray[$value->name]['@type'], 'varchar') !== false) {
                    $objectInstance->$attr = $this->getTexto(10);
                }

                if(strpos($nArray[$value->name]['@type'], 'date') !== false) {
                    $objectInstance->$attr = $this->getFecha();
                }
            }
            
            $objectInstance->producto_sucursal_id = 2;
            $objectInstance->unidad_medida_id = 1;
            
            $this->doEdit($objectInstance);
            
        }
        
        
        $this->index();
        
    }
    
    public function getTexto($maxLength){
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
        $numerodeletras=$maxLength; 
        $texto = ""; 
        for($i=0;$i<$numerodeletras;$i++)
        {
            $texto .= substr($caracteres,rand(0,strlen($caracteres)),1);
        }
        return $texto;
    }
    
    public function getNumero($maxLength){
        $caracteres = "1234567890"; //posibles caracteres a usar
        $numerodeletras=$maxLength; 
        $texto = ""; 
        for($i=0;$i<$numerodeletras;$i++)
        {
            $texto .= substr($caracteres,rand(0,strlen($caracteres)),1);
        }
        return $texto;
    }
    
    public function getFecha(){
        return date('Y-m-d');
    }
    
    public function buildFacade($entityName, $modulo){

        $this->crearModulo('model/'.$modulo . '/facade');
        
        $archivo = "";

        $archivo .= "<?php";

        $archivo .= "\n";
        $archivo .= "\n";

        $archivo .= "/*";
        $archivo .= "\n";
        $archivo .= "* To change this template, choose Tools | Templates";
        $archivo .= "\n";
        $archivo .= "* and open the template in the editor.";
        $archivo .= "\n";
        $archivo .= "*/";

        $archivo .= "\n";
        $archivo .= "\n";

        $archivo .="/**";
        $archivo .= "\n";
        $archivo .="* Description of " . ucfirst($entityName) . 'Facade';
        $archivo .= "\n";
        $archivo .="*";
        $archivo .= "\n";
        $archivo .="* @author chory";
        $archivo .= "\n";
        $archivo .="* @date " . date('Y-m-d H:m:s');
        $archivo .= "\n";
        $archivo .="*/";
        
        $archivo .= "\n";
        
        $archivo .= 'include_once(\'model/AbstractFacade.php\');';
        $archivo .= "\n";
        $archivo .= 'require_once \'' . 'model/' . $modulo . '/entity/' . ucfirst($entityName) . '.php\';';

        $archivo .= "\n";
        $archivo .= "\n";

        $archivo .= "class " . ucfirst($entityName) . "Facade extends AbstractFacade{";

        $archivo .= "\n";
        $archivo .= "\n";

            
        $archivo .= '   ';

        $archivo .= "function " . ucfirst($entityName) . 'Facade() {';
        $archivo .= "\n";
        $archivo .= "       ";
        $archivo .= '$this->motor = AbstractFacade::$MYSQL;';
        $archivo .= "\n";
        $archivo .= '       $this->schema = \''.$this->schema.'\';';
        $archivo .= "\n";
        $archivo .= '       $this->entidad = \''. $entityName . '\';';
        $archivo .= "\n";
        $archivo .= '       $this->idcolum = \'id\';';
        $archivo .= "\n";
        $archivo .= "   ";
        $archivo .= "}";

        $archivo .= "\n";
            
        $archivo .= "\n";

        $archivo .= "}";
            
        $archivo .= "\n";
        $archivo .= "\n";

        $file = fopen("model/{$modulo}/facade/" . ucfirst($entityName)."Facade.php","a");

        fputs($file, $archivo);
        
        fclose($file);
    }
    
    public function buildControl($entityName, $modulo){
        
        $this->crearModulo('control/maintenance/');
        
        $archivo = "";
        
        $archivo .= '<?php';
        
        $archivo .= "\n";

        $archivo .= '/*';
        $archivo .= "\n";
        $archivo .= ' * To change this license header, choose License Headers in Project Properties.';
        $archivo .= "\n";
        $archivo .= ' * To change this template file, choose Tools | Templates';
        $archivo .= "\n";
        $archivo .= ' * and open the template in the editor.';
        $archivo .= "\n";
        $archivo .= ' */';

        $archivo .= '/**';
        $archivo .= "\n";
        $archivo .= ' * Description of m' . ucfirst($entityName) . 'Control';
        $archivo .= "\n";
        $archivo .= ' *';
        $archivo .= "\n";
        $archivo .= ' * @author chory';
        $archivo .= "\n";
        $archivo .="* @date " . date('Y-m-d H:m:s');
        $archivo .= "\n";
        $archivo .= ' */';

        $archivo .= "\n";
        $archivo .= "\n";
        
        $archivo .= 'require_once \'model/' . $modulo . '/facade/' . ucfirst($entityName) . 'Facade.php\';';
        $archivo .= "\n";
        $archivo .= 'require_once \'model/' . $modulo . '/entity/' . ucfirst($entityName) . '.php\';';
        
        $archivo .= "\n";
        $archivo .= "\n";

        $archivo .= 'class m' . ucfirst($entityName) . 'Control {';
        $archivo .= "\n";
        $archivo .= '	';
        $archivo .= "\n";
        $archivo .= '   function m' . ucfirst($entityName) . 'Control(){';
        $archivo .= "\n";
        $archivo .= '   }';
        $archivo .= "\n";
        $archivo .= "\n";
        $archivo .= '   public function index(){        ';
        $archivo .= "\n";
        $archivo .= '   }';
        $archivo .= "\n";
        $archivo .= "\n";
        $archivo .= '   public function view(){        ';
        $archivo .= "\n";
        $archivo .= '       include_once \'view/maintenance/'.$modulo.'/'.$entityName.'/view.php\';';
        $archivo .= "\n";
        $archivo .= '   }';
        $archivo .= "\n\n";
        $archivo .= '   /**';
        $archivo .= "\n";
        $archivo .= '   * @api';
        $archivo .= "\n";
        $archivo .= '   * @method GET';
        $archivo .= "\n";
        $archivo .= '   */';
        $archivo .= "\n";
        $archivo .= '   public function get'.ucfirst($entityName).'s($request){        ';
        $archivo .= "\n";
        $archivo .= '       $'.$entityName.'Facade = new '.ucfirst($entityName).'Facade();';
        $archivo .= "\n";
        $archivo .= '       $entities = $'.$entityName.'Facade->setParams(array(\'likeArray\' => true))->findEntities();';
        $archivo .= "\n";
        $archivo .= '       $entitiesData = array();';
        $archivo .= "\n";
        $archivo .= '       foreach ($entities as $entity) {';
        $archivo .= "\n";
        $archivo .= '           $entitiesData[] = array_values($entity);';
        $archivo .= "\n";
        $archivo .= '       }';
        $archivo .= "\n";        
        $archivo .= '       echo json_encode(array(\'data\' => $entitiesData));       ';
        $archivo .= "\n";
        $archivo .= '   }';
        
        $archivo .= 'public function get'.ucfirst($entityName).'($request){';
        $archivo .= "\n";
        $archivo .= '	   $'.$entityName.'Facade = new '.ucfirst($entityName).'Facade();';
        $archivo .= "\n";
        $archivo .= '	   $entity = $'.$entityName.'Facade->findById($request->id);';
        $archivo .= "\n";
        $archivo .= '	   echo json_encode($entity);       ';
        $archivo .= "\n";
        $archivo .= '   }';
        $archivo .= "\n";
        $archivo .= '   ';
        $archivo .= "\n";
        $archivo .= '   public function post'.ucfirst($entityName).'($request){';
        $archivo .= "\n";
        $archivo .= '	   ';
        $archivo .= "\n";
        $archivo .= '	   $'.$entityName.'Facade = new '.ucfirst($entityName).'Facade();';
        $archivo .= "\n";
        $archivo .= '	   ';
        $archivo .= "\n";
        $archivo .= '	   $'.$entityName.' = new '.ucfirst($entityName).'((array)$request);';
        $archivo .= "\n";
        $archivo .= '	   ';
        $archivo .= "\n";
        $archivo .= '	   $'.$entityName.'Facade->doEdit($'.$entityName.');';
        $archivo .= "\n";
        $archivo .= '   }';
        $archivo .= "\n";
        $archivo .= '   ';
        $archivo .= "\n";
        $archivo .= '   public function put'.ucfirst($entityName).'($request){';
        $archivo .= "\n";
        $archivo .= '	   ';
        $archivo .= "\n";
        $archivo .= '	   $'.$entityName.'Facade = new '.ucfirst($entityName).'Facade();';
        $archivo .= "\n";
        $archivo .= '	   ';
        $archivo .= "\n";
        $archivo .= '	   $'.$entityName.' = $'.$entityName.'Facade->findById($request->id);';
        $archivo .= "\n";
        $archivo .= '	   ';
        $archivo .= '	   $'.$entityName.'->merge((array)$request);';
        $archivo .= "\n";
        $archivo .= '	   ';
        $archivo .= "\n";
        $archivo .= '	   $'.$entityName.'Facade->doEdit($'.$entityName.');       ';
        $archivo .= "\n";
        $archivo .= '   }';
        $archivo .= "\n";

        $archivo .= "\n";
        $archivo .= '}';
        $archivo .= "\n";

        
        
        
        $file = fopen("control/maintenance/m" . ucfirst($entityName)."Control.php","a");
        
        fputs($file, $archivo);
        
        fclose($file);
        
        
    }
    
    public function buildList($result, $entityName, $modulo){
        
        $this->crearModulo('view/maintenance/' . $modulo . '/'.$entityName);
        
        $archivo = "";
        $archivo .= '<h3>Lista de la entidad ' .  ucfirst($entityName) . '</h3>';

        $archivo .= "\n<button type='button' class='btn btn-primary' onclick='nuevo".ucfirst($entityName)."()'>Nuevo</button>";
        $archivo .= '<div>';
        $archivo .= "\n";
        $archivo .= '   <table id="mTable' . ucfirst($entityName) . '"  width="100%" class="table table-striped table-bordered table-hover">';
        $archivo .= "\n";
        $archivo .= '       <thead>';
        $archivo .= "\n";
        $archivo .= '           <tr>';
        foreach ($result as $fila){
            $archivo .= "\n" . '                <th>' . strtolower($fila['Field']) . '</th>';
        }        
        $archivo .= "\n";
        $archivo .= '           </tr>';
        $archivo .= "\n";
        $archivo .= '       </thead>';
        $archivo .= "\n";
        $archivo .= '   </table>';
        $archivo .= "\n";
        $archivo .= '</div>';
        
        $archivo .= "\n";
        
        $archivo .= $this->buildForm($result, $entityName, $modulo);        
        
        $file = fopen('view/maintenance/' . $modulo . '/'. $entityName . '/view.php' ,"a");
        
        fputs($file, $archivo);
        
        fclose($file);
        
    }
    
    public function buildForm($result, $entityName, $modulo){
        
        $archivo = '';
        
        $archivo .= "\n<!-- Modal -->";
        $archivo .= "\n<div class='modal fade' id='{$entityName}_modal' role='dialog'>";
        $archivo .= "\n  <div class='modal-dialog'>";
        $archivo .= "\n	<!-- Modal content-->";
        $archivo .= "\n	<div class='modal-content'>";
        $archivo .= "\n	  <div class='modal-header'>";
        $archivo .= "\n		<button type='button' class='close' data-dismiss='modal'>&times;</button>";
        $archivo .= "\n		<h4 class='modal-title'>Crear/Editar</h4>";
        $archivo .= "\n	  </div>";
        $archivo .= "\n	  <div class='modal-body'>";
        $archivo .= "\n		  <div class='row'>";
        $archivo .= "\n				<div class='col-lg-12'>";
        $archivo .= "\n					<div class='panel panel-default'>";
        $archivo .= "\n<!--                        <div class='panel-heading'>";
        $archivo .= "\n							";
        $archivo .= "\n						</div>-->";
        $archivo .= "\n						<div class='panel-body'>";
        $archivo .= "\n							<div class='row'>";
        $archivo .= "\n								<div class='col-lg-6'>";
        $archivo .= "\n									<form role='form' id='{$entityName}_form'>";
        
        foreach ($result as $fila) {            
            $archivo .= "\n										<div class='form-group'>";
            $archivo .= "\n											<label>".strtolower($fila['Field']).":</label>";
            $archivo .= "\n											<input class='form-control' name='".strtolower($fila['Field'])."' id='{$entityName}_".strtolower($fila['Field'])."'>";
            $archivo .= "\n											<p class='help-block'></p>";
            $archivo .= "\n										</div>                                        ";
        }
        
        $archivo .= "\n									</form>";
        $archivo .= "\n								</div>";
        $archivo .= "\n							</div>";
        $archivo .= "\n						</div>";
        $archivo .= "\n					</div>";
        $archivo .= "\n				</div>";
        $archivo .= "\n		  </div>            ";
        $archivo .= "\n	  </div>";
        $archivo .= "\n	  <div class='modal-footer'>";
        $archivo .= "\n		<button type='button' class='btn btn-primary' data-dismiss='modal' onclick='guardar".ucfirst($entityName)."()'>Guardar</button>";
        $archivo .= "\n		<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>";
        $archivo .= "\n	  </div>";
        $archivo .= "\n	</div>";
        $archivo .= "\n  </div>";
        $archivo .= "\n</div>";
        
        return $archivo;
        
    }
    
    public function buildJs($entityName, $modulo){
        
        $this->crearModulo('resources/js/' . $modulo . '/'.$entityName);
        
        $archivo = '';
        
        $archivo .= "\nvar baseUrl = $('base').attr('href');";

        $archivo .= "\n$(document).ready(function(){";
    
        
        $archivo .= "\nvar table = $('#mTable".  ucfirst($entityName)."').DataTable({";
        $archivo .= "\n	'ajax': baseUrl + 'api.php/maintenance/m".ucfirst($entityName)."/".$entityName."s',";
        $archivo .= "\n	'responsive': true,";
        $archivo .= "\n	'language': {";
        $archivo .= "\n		'lengthMenu': 'Mostrar _MENU_ registros por pagina',";
        $archivo .= "\n		'zeroRecords': 'No se encontraron registros',";
        $archivo .= "\n		'info': 'Mostrando la pagina _PAGE_ de _PAGES_',";
        $archivo .= "\n		'infoEmpty': 'No hay registro para mostrar',";
        $archivo .= "\n		'infoFiltered': '(buscando entre _MAX_ registros)',";
        $archivo .= "\n		'sSearch': 'Buscar:',";
        $archivo .= "\n		'oPaginate': {";
        $archivo .= "\n			'sFirst':    'Primero',";
        $archivo .= "\n			'sLast':     'Último',";
        $archivo .= "\n			'sNext':     'Siguiente',";
        $archivo .= "\n			'sPrevious': 'Anterior',";
        $archivo .= "\n		}";
        $archivo .= "\n	}";
        $archivo .= "\n});";
        
        $archivo .= "\n\n   $('#mTable".  ucfirst($entityName)." tbody').on( 'click', 'tr', function () {";
        $archivo .= "\n     var data = table.row( this ).data();";
        
        $archivo .= "\n    $.get(baseUrl + 'api.php/maintenance/m".ucfirst($entityName)."/".$entityName."', {id: data[0]}, ";
        $archivo .= "\n       function(response){";
        $archivo .= "\n           editar".ucfirst($entityName)."(response);";
        $archivo .= "\n      }).fail(function(){";
        $archivo .= "\n     });";
        $archivo .= "\n     });";
        
        
        $archivo .= "\n     $('#{$entityName}_modal').on('hide.bs.modal', function () {";
        $archivo .= "\n         table.ajax.reload(function(){});";
        $archivo .= "\n     });";
        
        $archivo .= "\n});";
        
        $archivo .= "\nfunction nuevo".ucfirst($entityName)."(){";
        $archivo .= "\n	var controles = $('#{$entityName}_form .form-control');";
        $archivo .= "\n	$.each(controles, function(i, e){";
        $archivo .= "\n	$(e).val('');";
        $archivo .= "\n	});";
        $archivo .= "\n	";
        $archivo .= "\n	$('#{$entityName}_modal').modal('show');";
        $archivo .= "\n}";
        
        $archivo .= "\n\nfunction guardar" . ucfirst($entityName)."(){";

        $archivo .= "\n     var type = 'post';";

        $archivo .= "\n     if($('#{$entityName}_id').val() !== ''){";
        $archivo .= "\n         type = 'put';";
        $archivo .= "\n }";

        $archivo .= "\n     $.ajax({url: baseUrl + 'api.php/maintenance/m".ucfirst($entityName)."/".$entityName."', ";
        $archivo .= "\n     type: type,";
        $archivo .= "\n     data: $('#{$entityName}_form').serialize(),";
        $archivo .= "\n     success: function (response) {";
        $archivo .= "\n     $('#{$entityName}_modal').modal('hide');";
        $archivo .= "\n     }";
        $archivo .= "\n     });";
        $archivo .= "\n }";

        $archivo .= "\nfunction editar".ucfirst($entityName)."(data){";

        $archivo .= "\n     var obj = eval('('+data+')');";

        $archivo .= "\n     var controles = $('#{$entityName}_form .form-control');";

        $archivo .= "\n     $.each(controles, function(i, e){";
        $archivo .= "\n     $(e).val(obj[$(e).attr('name')]);";
        $archivo .= "\n     });";

        $archivo .= "\n     $('#".$entityName."_modal').modal('show');";

        $archivo .= "\n }";
        
        $fileJs = 'resources/js/' . $modulo . '/'. $entityName . '/'.$entityName.'.js';
        
        $file = fopen($fileJs ,"a");
        
        fputs($file, $archivo);
        
        fclose($file);
        
        $this->buildScriptFile($fileJs);
        
    }
    
    public function buildScriptFile($fileJs){
        
        $archivo = '';
        
        $archivo .= "\n<script src='".$fileJs."'></script>";
        
        $file = fopen('view/maintenance/scripts.php' ,"a");
        
        fputs($file, $archivo);
        
        fclose($file);
        
    }
    
}