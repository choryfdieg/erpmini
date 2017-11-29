<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Description of AbstractFacade
 *
 * @author cirsisdgr
 */

include_once 'MysqlModel.php';
include_once 'As400Model.php';

class AbstractFacade {

    public $toShow;
    public $sqlBefore;
    public static $AS400 = 1;
    public static $MYSQL = 2;
    protected $schema = '';
    protected $entidad = '';
    protected $idcolum = '';
    public $ipServer;
    protected $namedQueries;
    public $motor;
    private $error = false;
    private $errorInfo = "";
    private $mensajeInfo = "";

    protected $parametrosConexion;


    private $a;

    protected function getEntityManager() {

        $entityManager = null;

        if($this->a !== null)
            return $this->a;

        if ($this->motor == AbstractFacade::$AS400)
            $entityManager = new As400Model($this->schema, $this->ipServer);

        if ($this->motor == AbstractFacade::$MYSQL)
            $entityManager = new MysqlModel($this->parametrosConexion);

        $this->a = $entityManager;
        
        return $entityManager;
    }

    public function getNotEmptyProperties($objectInstance) {
        $notEmptyProperties = array();
        $fields = $this->getPublicEntityProperties();
        foreach ($fields as $key => $value) {
            if ($objectInstance->$value != null)
                $notEmptyProperties[$value] = $objectInstance->$value;
        }
        return $notEmptyProperties;
    }

    public function doEdit($objectInstance, $crearAuditoria=true, $autoIncrement=false, $setId = false, $validar = true, $setFecCreacion = false) {

        if (is_array($objectInstance)) {
            list($objectsToCreate, $objectsToUpdate) = $this->sortObjects($objectInstance);

            foreach (array_chunk($objectsToCreate, 1000) as $objectToCreate)
                $this->createArray($objectToCreate, $autoIncrement, $crearAuditoria, $setId);
            foreach ($objectsToUpdate as $objectToUpdate) {
                if($crearAuditoria)
                    $objectToUpdate = $this->buildInspectionData($objectToUpdate);
                $this->update($objectToUpdate, $setId,$validar);
            }
        } elseif ($this->exists($objectInstance)) {
            if($crearAuditoria)
                $objectInstance = $this->buildInspectionData($objectInstance);
            $this->update($objectInstance, $setId,$validar);
        } else {
            if ($autoIncrement)
                $objectInstance = $this->setNextId($objectInstance);

            if ($crearAuditoria)
                $objectInstance = $this->buildInspectionData($objectInstance);
            
            $this->create($objectInstance, $setId, $validar);

            if($autoIncrement == false){
                if(in_array('setId',get_class_methods(get_class($objectInstance)))){
                    $objectInstance->setId($this->getEntityManager()->getLastId());
                }
            }
        }

        return $objectInstance;
    }

    private function sortObjects($objectsInstace) {

        $toCreate = array();
        $toUpdate = array();

        if ($this->idcolum) {

            $toUpdateTemp = array();

            $statement = "SELECT " . $this->idcolum . " FROM " . $this->getFullName() . " WHERE " . $this->idcolum . " in ('";
            $comma = "";
            foreach ($objectsInstace as $objectInstace) {
                if ($objectInstace->getId()) {
                    $toUpdateTemp[$objectInstace->getId()] = $objectInstace;
                    $statement .= $comma . $objectInstace->getId();
                    $comma = "','";
                } else {
                    $toCreate[] = $objectInstace;
                }
            }
            $statement .= (count($toUpdateTemp) ? '' : 0)."')";

            $results = $this->executeQuery($statement);

            if (count($results) > 0 && $results != '') {
                foreach ($results as $result) {
                    $result = array_pop($result);
                    $toUpdate[] = $toUpdateTemp[$result];
                    unset($toUpdateTemp[$result]);
                }
            }

            foreach ($toUpdateTemp as $entity)
                $toCreate[] = $entity;
        } else {
            $toCreate = $objectsInstace;
        }
        return array($toCreate, $toUpdate);
    }

    public function buildInspectionData($objectInstance) {        
        $objectInstance->buildInspectionData();
        
        return $objectInstance;
    }

    public function create($objectInstance, $setId = true, $validar = true) {
        $statement = $this->sqlBuild($objectInstance, 'INSERT', $setId, $validar);

        $result = $this->agregarSql($statement)->sentenciaSimple($statement);
        
        $this->setMessage($result, "almacenado");
    }

    public function createArray($objectsInstance, $autoIncrement=false, $crearAuditoria=true, $setId = true) {

        if (!empty($objectsInstance)) {
            
            $auditoria = array();
            $maxId = -1;

            if ($crearAuditoria) {
                $auditoria = $this->newEntityInstance();
                $auditoria = $this->buildInspectionData($auditoria);
            }

            if ($autoIncrement)
                $maxId = $this->getMax($this->idcolum);

            $statement = $this->buildInsertArray($objectsInstance, $maxId, $auditoria, $setId);

            $result = $this->sentenciaSimple($statement);
            
            $this->setMessage($result, "almacenado");
            
        }
    }

    public function update($objectInstance, $setId = true,$validar = true) {
        $entity = $objectInstance;

        $statement = $this->sqlBuild($entity, 'UPDATE', $setId,$validar);
        
        $result = $this->agregarSql($statement)->sentenciaSimple($statement);

        $this->setMessage($result, "almacenado");
    }

    public function getLastId() {
        $em = $this->getEntityManager();

        return $em->getLastId();
    }

    public function executeQuery($query) {
        
        $em = $this->agregarSql($query)->getEntityManager();
        
        return $em->executeQuery($query);
    }

    public function sentenciaSimple($query) {
        
        $em = $this->getEntityManager();

        $this->toShow = $query;

        return $em->sentenciaSimple($query);
    }

    public function findById($id) {
        
        if(!is_object($this->obj)){
            $this->setParams();
        }
        
        $consulta = "SELECT ";

        $consulta .= ( empty($this->obj->select)) ? " * " : implode(", ", $this->obj->select);
        
        $joinSql = '';

        foreach ($this->obj->joins as $join) {
            $joinSql .= " left join {$join['schema']}.{$join['table']} {$join['alias']} on {$join['alias']}.id = a.{$join['table']}_id";
        }
        
        $consulta .= " FROM " . $this->getFullName() . " a {$joinSql} where a." . $this->idcolum . " = " . $this->validarValueSQL($id);
        
        $entidades = $this->executeQuery($consulta);
        
        //***
        $entidad = (!empty($entidades)) ? $this->newEntityInstance($entidades[0]) : '';
        
        //***
        return $entidad;
    }
    
    public $obj;
    
    /**
     * 
     * @param stdClass $params
     * @values array('select', 'filters', 'orderBy', 'alias', 'joins', 'likeArray')
     */
    public function setParams($params = array('select', 'filters', 'orderBy', 'alias', 'joins', 'likeArray')){

        $this->obj = new stdClass();
        
        $this->obj->select = (isset($params['select'])) ? $params['select'] : array();
        $this->obj->filters = (isset($params['filters'])) ? $params['filters'] : array();
        $this->obj->orderBy = (isset($params['orderBy'])) ? $params['orderBy'] : '';
        $this->obj->alias = (isset($params['alias'])) ? $params['alias'] : '';
        $this->obj->joins = (isset($params['joins'])) ? $params['joins'] : array(); 
        $this->obj->likeArray = (isset($params['likeArray'])) ? $params['likeArray'] : false;
        
        return $this;
        
    }

    public function findEntities() {
        
        if(!is_object($this->obj)){
            $this->setParams();
        }
        
        $consulta = "SELECT ";
        //***
        $consulta .= ( empty($this->obj->select)) ? " * " : implode(", ", $this->obj->select);
        //***
        $consulta .= " FROM " . $this->getFullName().' '.$this->obj->alias;
        //***
        $joinSql = '';

        foreach ($this->obj->joins as $join) {
            $joinSql .= " left join {$join['schema']}.{$join['table']} {$join['alias']} on {$join['alias']}.id = a.{$join['table']}_id";
        }
        // ***
        $consulta .= $joinSql;
        // ***
        $consulta .= " where 1 = 1 ";
        //***
        $consulta .= implode(" ", $this->obj->filters);
        //***
        if($this->obj->orderBy != ""){
            $consulta .= ' order by ' . $this->obj->orderBy . ' ';
        }
        
        // ***
        $entidades = $this->executeQuery($consulta);
        
        if($this->obj->likeArray){
            
            $this->obj = null;
            
            return $entidades;        
        }
        
        $this->obj = null;
        
        //***
        $lista = array();
        //***
        if (!empty($entidades)) {
            foreach ($entidades as $entidad) {
                $lista[] = $this->newEntityInstance($entidad);
            }
        }
        //***
        return $lista;
    }

    public function findEntityById($id, $select = array()) {
        $consulta = "SELECT ";
        $consulta .= ( empty($select)) ? " * " : implode(", ", $select);
        $consulta .= " FROM " . $this->getFullName() . " where " . $this->idcolum . " = " . $this->validarValueSQL($id);
        $em = $this->getEntityManager();
        $res = $em->realizar_consulta($consulta);
        $row = odbc_fetch_array($res);
        return $this->newEntityInstance($row);
    }

    public function findEntityByIdModificado($id, $select=array()) {
        $consulta = "SELECT ";
        $consulta .= ( empty($select)) ? " * " : implode(", ", $select);
        $consulta .= " FROM " . $this->getFullName() . " where " . $this->idcolum . " = " . $this->validarValueSQL($id);
        $em = $this->getEntityManager();
        $row = $em->ejecutarConsulta($consulta);
        return $this->newEntityInstance($row);
    }

    public function getCount($joins=array(), $filtros=array(), $nameQuery='', $params=array(),$aliasTabla = 'a') {
        
        // ***
        if ($nameQuery == '') {
            $query = "SELECT count(*) as cantidad FROM " . $this->getFullName() . " $aliasTabla ";
        } else {
            $consulta = $this->getNamedQuery($nameQuery);
            $query = $consulta;
        }
        // ***
        if (!empty($joins)) {
            foreach ($joins as $value) {
                $query .= $value;
            }
        }
        // ***
        if ($nameQuery == '')
            $query .= " where 1 = 1 ";
        // ***
        $query .= implode(" ", $filtros);
        // ***
        $params = $this->validarSQL($params);
        // ***
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $query = str_replace(":" . $key, $value, $query);
            }
        }
        // ***
        $em = $this->getEntityManager();
        // ***
        
        $this->agregarSql($query);
        
        $result = $em->sentenciaSimple($query,true);
//        $result = $em->ejecutarConsulta($query);
        // ***
//        $cantidad = mysql_fetch_array($result);
        // ***
        return array_pop($result);
    }

    /**
     * @param <type> $namequery
     * @param <type> $p parametros
     * @param <type> $f filtros en la consulta
     * @param <type> $item-- Retorna la lista con un item de todos
     * @return <type>
     */
    public function runNamedQuery($namequery, $filtros=array(), $params = array()) {
        $consulta = $this->getNamedQuery($namequery);
        //***
        $consulta .= implode(" ", $filtros);
        //***
        foreach ($params as $key => $value) {
            $consulta = str_replace(":" . $key, $value, $consulta);
        }
        // ***
        $em = $this->getEntityManager();
        //***
        $this->toShow = $consulta;

        $entidades = $em->executeQueryObject($consulta);
        //***
        return $entidades;
    }

    public function runNamedQueryArray($namequery, $filtros=array(), $params=array(), $replaceFields = false, $validar = true) {
        //***
        $consulta = $this->getNamedQuery($namequery);
        // ***
        $consulta .= implode(" ", $filtros);
        // ***
//        if($validar)
//            $params = $this->validarSQL($params);
        // ***
        foreach ($params as $key => $value) {
            $consulta = str_replace(":" . $key, $value, $consulta);
        }
        // ***     
        if ($replaceFields)
            $consulta = $this->replaceFields($consulta);
        
        $entidades = $this->executeQuery($consulta);

        //***
        return $entidades;
    }

    public function runNamedQueryMerge($namequery, $filtros=array()) {
        $consulta = $this->getNamedQuery($namequery);
        $consulta .= implode(" ", $filtros);
        $entidades = $this->executeQuery($consulta);
        //***
        $lista = array();
        //***
        if (!empty($entidades)) {
            foreach ($entidades as $entidad) {
                $lista[] = $this->newEntityInstance($entidad);
            }
        }
        //***
        return $lista;
    }

    public function runSimpleNamedQuery($namequery, $filtros=array(), $params=array(), $validarSQL = true) {
        //***
        $consulta = $this->getNamedQuery($namequery);
        //***
        $consulta .= implode(" ", $filtros);
        //***
        if($validarSQL){
            $params = $this->validarSQL($params);
        }
        // ***
        foreach ($params as $key => $value) {
            $consulta = str_replace(":" . $key, $value, $consulta);
        }
        
        $result = $this->sentenciaSimple($consulta);

        $this->setMessage($result, "almacenado");
    }

    protected function getFullName() {
        return $this->schema . "." . $this->entidad;
    }

    public function sqlBuild($objectInstance, $tipo, $setId = true, $validar = true) {
        if ($tipo == 'UPDATE')
            return $this->buildUpdate($objectInstance, $setId,$validar);
        if ($tipo == 'INSERT')
            return $this->buildInsert($objectInstance, $setId, $validar);
        return null;
    }

    public function buildInsert($objectInstance, $setId = true, $validar = true) {
        
        $insert = 'INSERT INTO ' . $this->getFullName();
        //***
        $fields = $this->getPublicEntityProperties($setId);
        //***    
        $insert .= ' (' . implode(",", $fields) . ') ';
        //***
        $insert .= 'values(';
        //***
        $fieldsNames = new ArrayObject(array_values($fields));
        //***
        $ci = new CachingIterator($fieldsNames->getIterator(), $fieldsNames->getIterator()->getFlags());
        $comma = "";
        foreach ($ci as $value) {
            $insert .= $comma;
            if ($objectInstance->$value === null || $objectInstance->$value == '')
                $insert .= "null";
            else {
                if ($validar) {
                    $insert .= "'" . $objectInstance->$value . "'";
                } else {
                    $insert .= "'" . $objectInstance->$value . "'";
                }                
            }
            $comma = ",";
        }
        $insert .= ') ';
        
        return $insert;
        
    }

    public function buildInsertArray($objectsInstance, $maxId = -1, $auditoria = array(), $setId = true) {
        $insert = 'INSERT INTO ' . $this->getFullName() . " ";
        $fields = $this->getPublicEntityProperties($setId);
        $insert .= ' (' . implode(",", $fields) . ') ';
        $insert .= 'values';
        $commaFields = "";
        $commaRows = "";

        foreach ($objectsInstance as $objectInstance) {
            $insert .= $commaRows . " (";

            if ($maxId > -1) {
                $objectInstance->setId(++$maxId);
            }

            foreach ($fields as $field) {
                $insert .= $commaFields;
                if ($objectInstance->$field !== null) {
                    $insert .= "'" . str_replace("'", ' ', $objectInstance->$field) . "'";
                } elseif ($auditoria && $auditoria->$field !== null) {
                    $insert .= "'" . $auditoria->$field . "'";
                } else {
                    $insert .= "null";
                }
                $commaFields = ",";
            }

            $insert .= ") ";
            $commaRows = ",";
            $commaFields = "";
        }
        return $insert;
    }

    public function buildUpdate($objectInstance, $setId = true,$validar = true) {

        $update = 'UPDATE ' . $this->getFullName() . ' SET ';
        $fields = new ArrayObject($this->getPublicEntityProperties($setId));
        $ci = new CachingIterator($fields->getIterator(), $fields->getIterator()->getFlags());

        foreach ($ci as $value) {
            
            if ($objectInstance->$value === null || $objectInstance->$value == '')
                $update .= $value . '=' . "null";
            elseif($validar){
                $update .= $value . '=' . "'" . $this->validarValueSQL($objectInstance->$value) . "'";
            } else{
                $update .= $value . '=' . "'" . str_replace("'", ' ', $objectInstance->$value) . "'";
            }

            if ($ci->hasNext())
                $update.=', ';
        }

        // ***

        $update .= " where 1 = 1 ";

        //***
        $ids = $objectInstance->getId();
        // ***

        if(is_array($ids)){
            foreach ($ids as $key => $value) {
                $update .= " and $key = '$value'";
            }
        }else{
            $update .= " and $this->idcolum = '{$objectInstance->getId()}'";
        }

        // ***

        return $update;
    }

    public function setNextId($objectInstance) {
        
        $ids = get_parent_class($objectInstance) == 'Entity' ? $objectInstance->getAttrByAnnotation('@autoincrement') : array();

        if(is_array($ids) && !empty ($ids)){
            foreach ($ids as $key => $value) {
                $maxId = $this->getMax($key);

                $objectInstance->setValue($key, $maxId + 1);
            }
        }else{
            $maxId = $this->getMax($this->idcolum);
            $objectInstance->setId($maxId + 1);
        }

        return $objectInstance;
    }

    public function getMax($fieldName, $filtros = array()) {
        return $this->getMaxMinValue($fieldName, "MAX", $filtros);
    }

    public function getMin($fieldName, $filtros = array()) {
        return $this->getMaxMinValue($fieldName, "MIN", $filtros);
    }

    public function getMaxMinValue($fieldName, $tipo, $filtros = array()) {
        $statement = 'SELECT ' . $tipo . '(' . $fieldName . ') AS ' . $tipo . ' FROM ' . $this->getFullName() . ' WHERE 1 = 1 ';

        $statement .= ( !empty($filtros)) ? implode('', $filtros) : '';

        $value = array_pop($this->executeQuery($statement));

        return (!empty($value) && $value[$tipo] != null) ? $value[$tipo] : 0;
    }

    public function exists($objectInstance) {

        $existe = false;

        $idsVacios = false;

        $ids = $objectInstance->getId();

        if ($ids == null || count(array($ids)) == 0){
            $idsVacios = true;
        }

        foreach (array($ids) as $key => $value) {

            if($value == null){
                $idsVacios = true;
                break;
            }
            
        }

        // si los ids estan vacios es como si no existiera el registro
        if($idsVacios)
            return false;

        $statement = 'select count(*) as cantidad from ' . $this->getFullName();

        $statement .= " where 1 = 1 ";

        if(is_array($ids)){
            foreach ($ids as $key => $value) {
                $statement .= " and $key = '$value'";
            }
        }else{
            $statement .= ' and ' . $this->idcolum . ' = ' . $this->validarValueSQL($objectInstance->getid());
        }

        $entidades = $this->executeQuery($statement);
        
        $lista = null;

        if (!empty($entidades)) {

            foreach ($entidades as $entidad) {
                $lista[] = $entidad;
            }

            $lista[0] = array_change_key_case($lista[0], CASE_LOWER);

            if ((int) $lista[0]['cantidad'] > 0)
                $existe = true;

        }
        
        return $existe;
    }

    public function getPublicEntityProperties($setId = true) {
        $entidad = $this->entidad;
        if ($this->entidad == "FPAGOS04Z1") {
            $entidad = "F0411Z1";
        } else if ($this->entidad == "FPAGOS09Z1") {
            $entidad = "F0911Z1";
        }

        $keys = array_keys(get_class_vars($entidad));
        
        if (!$setId){
            unset($keys[array_search($this->idcolum, $keys)]);
        }
        return $keys;
    }

    function validarSQL($parametros) {
        if (is_array($parametros) || is_object($parametros)) {
            $parametros = (array) $parametros;
            $arrayDatos = array();
            // ***
            if (!empty($parametros)) {
                foreach ($parametros as $key => $value) {
                    $metodo = (is_array($value) || is_object($value)) ? "validarSQL" : "validarValueSQL";
                    $arrayDatos[$key] = $this->$metodo($value);
                }
            }
            return $arrayDatos;
        } else {
            return $this->validarValueSQL($parametros);
        }
    }

    function validarValueSQL($value) {

        if(is_array($value))
            return json_encode($value);

        $isMagicEnable = false;
        // ***
        $temp = null;
        // ***
        if (get_magic_quotes_gpc() != 0) {
            $isMagicEnable = true;
        }
        // ***

        $temp = htmlentities($value, ENT_QUOTES | ENT_IGNORE, "UTF-8");
        // ***
        if ($isMagicEnable)
            $temp = stripslashes($temp);
        // ***
        if ($this->motor == AbstractFacade::$MYSQL)
            @mysql_escape_string($temp);
        // ***
        return $temp;
    }

    public function remove($id) {
        $statement = 'delete from ' . $this->getFullName() . ' where ' . $this->idcolum . ' = ' . $id;

        $result = $this->sentenciaSimple($statement);
        // ***
        $this->setMessage($result, "eliminado");
    }

    public function removeEntities($filtros = array()) {
        $consulta = "DELETE FROM " . $this->getFullName() . " WHERE 1 = 1 ";
        //***
        $consulta .= implode(" ", $filtros);
        //***
        $result = $this->agregarSql($consulta)->sentenciaSimple($consulta);
        //***
        $this->setMessage($result, "eliminado");
    }

    public function updateEntities($params = array(), $filtros = array(),$actualizarAuditoria = false) {
        // ***
        $consulta = "UPDATE " . $this->getFullName() . " SET ";
        // ***
        $comma = "";
        $comaUpdate = count($params) > 1 ? ',' : '';
        
        //actualizar auditoria
        if($actualizarAuditoria){
            $time        = time();
            $fechaActual = date("Ymd", $time);
            $horaActual  = date("His", $time);
            $contenedorModel = new ContenedorModel();

            $camposValoresAuditoria = array('aufecmod'=>$fechaActual,'auhormod'=>$horaActual,
                                            'audirip'=>ContenedorModel::getIpCliente(),'uscodusuar'=>$contenedorModel->getLogin(),
                                            'aunomequip'=>$contenedorModel->getHostNameCliente());

            foreach($camposValoresAuditoria as $campoAuditoria=>$valor)
                $params[$campoAuditoria] = $valor;
        }
        ///
        
        foreach($params as $key=>$value){
            if($key == 'case'){
                $case = $comma.$params['case'][0].' = CASE';

                if(count($params['case'][2])){
                    foreach($params['case'][2] as $valorCampo=>$condicion){
                        if((is_array($condicion) && count($condicion)) || $condicion != ''){
                            $consulta .= $case .' WHEN '. $params['case'][1] ." IN ('". (implode("','",$condicion)). "')" .' THEN '. $valorCampo;
                            $case = '';
                        }
                    }
                    $consulta .= " END$comaUpdate ";  
                }
                
            } else{
                $valor = $value === null ? 'null' : "'$value'";
                $consulta .= "$comma$key = $valor";
                $comma = ",";
                $comaUpdate = '';
            }
        }
        
//            foreach ($params as $key => $value) {
//                $valor = $value === null ? 'null' : "'$value'";
//                $consulta .= "$comma$key = $valor";
//                $comma = ",";
//            }

        //***
        $consulta .= " WHERE 1=1 ";
        //***              
        $consulta .= implode('', $filtros);
        //***        
        $result = $this->agregarSql($consulta)->sentenciaSimple($consulta);
        //***
        $this->setMessage($result, "actualizado");
    }

    private function setMessage($result, $descripcion) {
        if (!$result) {
            $this->error = true;
            $this->errorInfo = "Se ha presentado un error. No se han $descripcion los datos correctamente";
        } else {
            $this->mensajeInfo = "Se han $descripcion los datos correctamente";
        }
    }

    private function getTablesSQL($SQL) {
        $expReg = "/(\w+)\.(\w+|\*)\s*(\w+)?/";
        $results = array();
        $tables = array();
        preg_match_all($expReg, $SQL, $results, PREG_SET_ORDER);

        $length = count($results);
        for ($i = 0; $length > $i; $i++) {
            if (isset($results[$i]) && isset($results[$i][3])) {
                foreach ($results as $result) {
                    if ($results[$i][3] == $result[1]) {
                        $tables[$results[$i][3]] = $results[$i][2];
                        unset($results[array_search($result, $results)]);
                    }
                }
            }
        }
        return $tables;
    }

    private function getAllFields($table, $alias = '') {
        $keys = array_keys(get_class_vars(ucfirst(strtolower($table))));
        $alias = ($alias != '') ? $alias . '.' : '';
        $comma = '';
        $statement = '';
        foreach ($keys as $key) {
            $statement .= $comma . $alias . $key . " AS " . $table . "_" . $key;
            $comma = ',';
        }
        return $statement;
    }

    private function replaceFields($SQL) {
        $tables = $this->getTablesSQL($SQL);
        if (!empty($tables)) {
            $expReg = "/select\s+([\s\S]+)\s+from/i";
            preg_match_all($expReg, $SQL, $selects, PREG_SET_ORDER);

            foreach ($selects as $select) {
                $pattern = "/(^|,)?\s*([\w\.\*]*((\(((?>[^()]+)|(?R))*\)))?[\w\s]*)\s*($|,)?/";
                preg_match_all($pattern, $select[1], $matchesarray, PREG_SET_ORDER);
                $fields = array();
                foreach ($matchesarray as $matches) {
                    if ($matches[2] != '')
                        $fields[] = $matches[2];
                }
                for ($i = 0; count($fields) > $i; $i++) {
                    if ($fields[$i] == "*") {
                        $fields[$i] = '';
                        $comma = '';
                        foreach ($tables as $alias => $table) {
                            $fields[$i] .= $comma . $this->getAllFields($table, $alias);
                            $comma = ",";
                        }
                    } elseif (!preg_match("/\sas\s/i", $fields[$i])) {
                        preg_match_all("/(\w+\.[\*\w]*)/", $fields[$i], $field, PREG_SET_ORDER);
                        $explode = explode('.', str_replace(" ", "", $field[0][1]));
                        $alias = $explode[0];
                        $field = (isset($explode[1])) ? $explode[1] : '';
                        if ($field == "*")
                            $fields[$i] = $this->getAllFields($tables[$alias], $alias);
                        else
                            $fields[$i] .= " AS " . $tables[$alias] . "_" . $field;
                    }
                }
                $SQL = str_replace($select[1], implode(",", $fields), $SQL);
            }
        }
        return $SQL;
    }
    
    public function getFiltros($valores, $alias = array()){
        $filtros = array();
        
        foreach ($valores as $key=>$value){
            if($value != ''){
                $value  = $this->validarSQL($value);
                
                $condicion = is_array($value) ? 'IN' : '=';
                if(preg_match('/^not\./i', $key))
                    $condicion = is_array($value) ? 'NOT IN' : '<>';
                else {
                    if(preg_match('/mayor\./i', $key))
                        $condicion = '>';
                    else if(preg_match('/menor\./i', $key))
                        $condicion = '<';
                    if(preg_match('/igual\./i', $key)){
                        $condicion .= '=';
                    }
                }
                
                $filtro  = " AND ".preg_replace(array('/^not\./i','/mayor\./i','/menor\./i','/igual\./i'),'',$key);
                
                if(!empty($alias)){
                    if(isset($alias[$key])){
                        $filtro = " AND $alias[$key] ";
                    } else {
                        continue;
                    }
                }
                
                $filtros[] = $filtro.(is_array($value)  ? " $condicion ('".implode("','", $value)."')" : " $condicion '$value'");
            }
        }
        
        return $filtros;
    }

    public function newEntityInstance($fieldsValues = array()) {

        $className = ucfirst(strtolower($this->entidad));

        $object = new ReflectionObject($this);

        $ruta = str_replace(array(dirname(__DIR__), $object->getName() . ".php"), "", $object->getFileName());
        
        $ruta = str_replace('facade', 'entity', $ruta);
        
        require_once preg_replace("/^\//", '', $ruta . $className . '.php');
        
        $objectInstance = new $className(array());

        $objectInstance->merge($fieldsValues);

        return $objectInstance;
    }
    
    public function agregarSql($consulta){
        $this->toShow = $consulta;
        if($this->sqlBefore === TRUE){
            $this->showSql();
            die;
        }
        return $this;
    }

    public function showSql($die = false) {
        $this->sqlBefore = $die;
        echo "<code>" . $this->toShow . "</code>";
        return $this;
    }

    public function getError() {
        return $this->error;
    }

    public function setError($error) {
        $this->error = $error;
    }

    public function getErrorInfo() {
        return $this->errorInfo;
    }

    public function setErrorInfo($errorInfo) {
        $this->errorInfo = $errorInfo;
    }

    public function getMensajeInfo() {
        return $this->mensajeInfo;
    }

    public function setMensajeInfo($mensajeInfo) {
        $this->mensajeInfo = $mensajeInfo;
    }

    public function getToShow() {
        return $this->toShow;
    }

    public function setToShow($toShow) {
        $this->toShow = $toShow;
    }

    public function getMotor() {
        return $this->motor;
    }

    public function setMotor($motor) {
        $this->motor = $motor;
    }
    
    public function updateEntityArray($entities){
        
        // ***
        $consulta = "UPDATE " . $this->getFullName() . " SET ";
        // ***
        $comma = "";
        $comaUpdate = count($params) > 1 ? ',' : '';
        
        //actualizar auditoria
        if($actualizarAuditoria){
            $time        = time();
            $fechaActual = date("Ymd", $time);
            $horaActual  = date("His", $time);
            $contenedorModel = new ContenedorModel();

            $camposValoresAuditoria = array('aufecmod'=>$fechaActual,'auhormod'=>$horaActual,
                                            'audirip'=>ContenedorModel::getIpCliente(),'uscodusuar'=>$contenedorModel->getLogin(),
                                            'aunomequip'=>$contenedorModel->getHostNameCliente());

            foreach($camposValoresAuditoria as $campoAuditoria=>$valor)
                $params[$campoAuditoria] = $valor;
        }
        ///
        
        foreach($params as $key=>$value){
            if($key == 'case'){
                $case = $comma.$params['case'][0].' = CASE';

                if(count($params['case'][2])){
                    foreach($params['case'][2] as $valorCampo=>$condicion){
                        if((is_array($condicion) && count($condicion)) || $condicion != ''){
                            $consulta .= $case .' WHEN '. $params['case'][1] ." IN ('". (implode("','",$condicion)). "')" .' THEN '. $valorCampo;
                            $case = '';
                        }
                    }
                    $consulta .= " END$comaUpdate ";  
                }
                
            } else{
                $valor = $value === null ? 'null' : "'$value'";
                $consulta .= "$comma$key = $valor";
                $comma = ",";
                $comaUpdate = '';
            }
        }
        
//            foreach ($params as $key => $value) {
//                $valor = $value === null ? 'null' : "'$value'";
//                $consulta .= "$comma$key = $valor";
//                $comma = ",";
//            }

        //***
        $consulta .= " WHERE 1=1 ";
        //***              
        $consulta .= implode('', $filtros);
        //***        
        $result = $this->agregarSql($consulta)->sentenciaSimple($consulta);
        //***
        $this->setMessage($result, "actualizado");
    }

}