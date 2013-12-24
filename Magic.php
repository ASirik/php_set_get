<?php

class Magics
{

    private $data = array();

    public $method;

    protected $_hasDataChanges = false;

    public function __construct()
    {

    }

    public function get($property, $methodName) {
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

    public static function __callStatic($name, $arguments) {
        // Замечание: значение $name регистрозависимо.
        echo "call static method '$name' "
            . implode(', ', $arguments). "\n";
    }
}