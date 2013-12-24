<?php

class Magics
{

    private $data = array();

    public $method;

    protected $_hasDataChanges = false;

    public function __construct()
    {

    }

    /* public function getData($property)
     {
       foreach ($this as $obj => $val){
           $obj->$val;
       }
     }*/

    public function setData($key, $value=null)
    {
        $this->_hasDataChanges = true;
        if(is_array($key)) {
            $this->_data = $key;
            $this->_addFullNames();
        } else {
            $this->_data[$key] = $value;
            if (isset($this->_syncFieldsMap[$key])) {
                $fullFieldName = $this->_syncFieldsMap[$key];
                $this->_data[$fullFieldName] = $value;
            }
        }
        return $this;
    }

    public function get($property, $args, $methodName) {
        if($property == 'data'){
            foreach($methodName as $key => $val){
                foreach($this->data as $keys => $vals){
                    if($val === $keys){
                        echo $vals . '<br>';
                    }
                }
            }
        }else{
            foreach($this->data as $key => $val){
                if($property === $key){
                    echo $val . '<br>';
                }

            }
        }

    }

    public function set($property, $value, $methodName) {
      /*  array_push( $this->data[$property] , $value);
        foreach($this->data as $key => $val){
            array_push( $this->data , $value);
        }*/
        $this->data[$property] = $value;
        return $this->data;
    }

    public function __get($var)
    {
        return $this->$var;
    }

    public function __call($methodName, $args) {
        if (preg_match('~^(set|get)([A-Z])(.*)$~', $methodName, $matches)) {
            $property = strtolower($matches[2]) . $matches[3];
            /* if (!property_exists($this, $property)) {
                 echo '(Property ' . '"' . $property . '"' . ' not exists)';
             }*/
            switch($matches[1]) {
                case 'set':
                    return $this->set($property, $args[0], $methodName);
                case 'get':
                    return $this->get($property, $methodName, $args);
                case 'getData':
                    return $this->__get($property, $methodName);
                case 'default':
                    echo '(Method ' . '"' . $methodName . '"' .' not exists)';
            }
        }
    }

    /*protected function checkArguments(array $args, $min, $max, $methodName) {
        $argc = count($args);
        if ($argc < $min || $argc > $max) {
            echo '(Method ' . $methodName . ' needs minimaly '
                . $min . ' and maximaly ' . $max . ' arguments. ' . $argc . ' arguments given.)';
        }
    }*/

    public static function __callStatic($name, $arguments) {
        // Замечание: значение $name регистрозависимо.
        echo "call static method '$name' "
            . implode(', ', $arguments). "\n";
    }
}

$o = new Magics();

//$o->setData('dfvdfv');
//$o->getData('Andrew');


