<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MysqlModel
 *
 * @author cirsisdgr
 */
class MysqlModel {

    public $conexion;
    public $server;
    public $baseDatos;
    public $usuario;
    public $password;


    function MysqlModel($parametros = array()) {
        $this->server = (isset($parametros['server'])) ? $parametros['server'] : Ambiente::$SERVIDOR;
        $this->baseDatos = (isset($parametros['baseDatos'])) ? $parametros['baseDatos'] : Ambiente::$DB;
        $this->usuario = (isset($parametros['usuario'])) ? $parametros['usuario'] : Ambiente::$USER;
        $this->password = (isset($parametros['password'])) ? $parametros['password'] : Ambiente::$PASS;
        $this->getConexion();
    }    

    public function getConexion() {
        $this->conexion = @mysql_connect($this->server, $this->usuario, $this->password);
        mysql_select_db($this->baseDatos, $this->conexion);
//        mysql_query ("SET NAMES 'utf8'");
        return $this->conexion;
    }

    function executeQuery($sqlStatement){
        
        $lista     = array();
        
        $a = $this->getConexion();
        
        $resultado = mysql_query($sqlStatement, $a);
        
        if($resultado){
            while($entidad = mysql_fetch_array($resultado, MYSQL_ASSOC)){            
                $lista[] = $entidad;
            }        
        }
        
        return $lista;
    }

    function sentenciaSimple($sqlStatement,$getCount = false){
        
        $conexion0 = $this->getConexion();
        
        $resultado = mysql_query($sqlStatement, $conexion0);
                
        if($getCount)
            $resultado = mysql_fetch_array($resultado);
        
        if(mysql_error($conexion0)){
            throw new Exception(mysql_error($conexion0));
        }

        return $resultado;
    }

    function querySimpleObject($sqlStatement){
        $resultado = mysql_query($sqlStatement, $this->getConexion());
        return $resultado;
    }

    function executeQueryObject($sqlStatement){
        $lista = "";
        $resultado = mysql_query($sqlStatement, $this->getConexion());
        while($entidad = mysql_fetch_object($resultado)){
            $lista[] = $entidad;
        }
        return $lista;
    }

    function closeEntityManager(){
        mysql_close($this->conexion);
    }

    function ejecutarConsulta($sql) {
        $resultado = array();
        $this->sql = $sql;
        if (($link = $this->conexion) != 'error') {
            $res = mysql_query($this->sql, $link);
            if ($res)
                $resultado = mysql_fetch_array($res);
        }
        return $resultado;
    }

    public function getLastId(){
        $resultado = array();
        $this->sql = "SELECT LAST_INSERT_ID() AS ID";
        if (($link = $this->conexion) != 'error') {
            $res = mysql_query($this->sql, $link);
            if ($res)
                $resultado = mysql_fetch_array($res);
        }

        return $resultado['ID'];
    }

}
?>