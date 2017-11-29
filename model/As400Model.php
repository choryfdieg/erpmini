<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of As400Model
 *
 * @author cirsisdgr
 */
class As400Model {

    public $conexion;
    public $conexionBdutil;
    public $servidor_odbc;
    public $basedatos_odbc;
    public $usuario_odbc;
    public $clave_odbc;
    public $controlador_odbc;
    public $dsn_odbc;

    public function As400Model($basedatos_odbc, $ipServer = "") {
        
        if($ipServer != "")
            $this->servidor_odbc = $ipServer;
        else
            $this->servidor_odbc = "10.25.2.10";
        
        $this->usuario_odbc = "SISDIEGOG";
        $this->clave_odbc = "diego321";
        $this->controlador_odbc = "odbc";
        $this->basedatos_odbc = $basedatos_odbc;
        $this->getConexion();
    }

    public function getConexion() {
        $this->db2_conect();
        return $this->conexion;
    }

    function executeQuery($sqlStatement) {
        $lista = array();
        $resultado = $this->realizar_consulta($sqlStatement);
        if($resultado){
            while($entidad = odbc_fetch_array($resultado)){
                $lista[] = $entidad;
            }
        }
        
        return $lista;
    }

    function sentenciaSimple($sqlStatement,$getCount = false) {
        $resultado = $this->realizar_consulta($sqlStatement);
        
        if($getCount)
            $resultado = odbc_fetch_array($resultado);
        
        return $resultado;
    }

    function executeQueryObject($sqlStatement) {
        $lista = array();
        $resultado = $this->realizar_consulta($sqlStatement);
        while ($entidad = odbc_fetch_array($resultado)) {
            $lista[] = $entidad;
        }
        return $lista;
    }

    function db2_conect() {
        $this->dsn_odbc = "DRIVER=iSeries Access ODBC Driver; SYSTEM=" . $this->servidor_odbc . "; DBQ=" . $this->basedatos_odbc . "; ForceTranslation=1;";
        if (!$this->conexion = odbc_connect($this->dsn_odbc, $this->usuario_odbc, $this->clave_odbc)) {
            echo "error de conexion";
        } 
    }

    function realizar_consulta($sql) {
        setlocale(LC_CTYPE, "en_US.ISO-8859-1");        //para que pueda ejecutar la instrucción que convierte a formato iso
        $sql = mb_convert_encoding($sql, 'ISO-8859-1');
        
        $resultado = null;
        $this->sql = $sql;        
        if (($link = $this->conexion) != 'error') {
            $res = odbc_exec($link, $this->sql);
            if ($res)
                $resultado = $res;
        }
        return $resultado;
    }

    public function getLastId(){
        $resultado = array();
        $this->sql = "SELECT IDENTITY_VAL_LOCAL() AS ID FROM SYSIBM.SYSDUMMY1";
        if (($link = $this->conexion) != 'error') {
            $res = odbc_exec($link, $this->sql);
            if ($res)
                $resultado = odbc_fetch_array($res);
        }
        return $resultado['ID'];
    }
}