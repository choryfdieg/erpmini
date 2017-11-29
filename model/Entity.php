<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entity
 *
 * @author cirsisdgr
 */

require_once 'model/Inspection.php';

abstract class Entity extends Inspection{

    protected $id;

    function __construct($fieldsValues) {
        $this->merge($fieldsValues);
    }

    public function equals($object){
        throw new Exception('Aun no se implementa');
    }

    public function merge($fieldsValues){

        $keySet = array_keys(array_change_key_case(get_object_vars($this),CASE_UPPER));

	$fields = array_change_key_case($fieldsValues,CASE_UPPER);

        foreach($keySet as $key){

            if(key_exists($key,$fields)){

                $keyLower = strtolower($key);

                $setMethod = 'set'. ucwords($keyLower);

                $value = $fields[$key];

                $this->$setMethod($value);

            }
        }
    }

    public function setId($id) {        
        $this->id = $id;
    }

    public function getId(){
        return $this->id;

    }

    public function addId($attrName, $value){

        $this->id[$attrName] = $value;

    }

    public function getAttrByAnnotation($tag){

        $attrByAnnotation = array();

        $keySet = array_keys(array_change_key_case(get_object_vars($this),CASE_UPPER));

        $reflector = new ReflectionClass(get_class($this));

        foreach($keySet as $key){

            $keyLower = strtolower($key);

            $docComment = $reflector->getProperty($keyLower)->getDocComment();

            if($docComment){

                $docComment = preg_replace('#[ \t]*(?:\/\*\*|\*\/|\*)?[ ]{0,1}(.*)?#', '$1', $docComment);

                $parsedDocComment =  ltrim($docComment, "\r\n");

                preg_match_all ("/(@.*)\b/", $parsedDocComment, $docArray);

                $nArray = array();

                foreach ($docArray[0] as $propertyDoc) {

                    $doc = explode(' ', $propertyDoc);

                    $nArray[$doc[0]] = $doc[1];
                }

                // Depurar Tipo Integer
                if(isset ($nArray[$tag])){

                    $setMethod = 'get'. ucwords($keyLower);

                    $value = $this->$setMethod();

                    $attrByAnnotation[$keyLower] = $value;

                }
            }
        }

        return $attrByAnnotation;

    }

    public function setValue($attrName, $value){

        $setMethod = 'set'. ucwords($attrName);

        $this->$setMethod($value);

    }

}