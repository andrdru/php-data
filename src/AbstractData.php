<?php

namespace Data;

abstract class AbstractData
{
    /**
     * @var array $dataStore__ data store
     */
    private $dataStore__ = array();

    /**
     * set data element
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->dataStore__[$name] = $value;
    }

    /**
     * get data element
     * @param $name
     * @return bool|mixed
     */
    public function __get($name)
    {
        $ans = false;
        if ($this->isSetted($name)) {
            $ans = $this->dataStore__[$name];
        }
        return $ans;
    }

    /**
     * set data from array
     * @param array $array assoc array
     * @param bool $skipNum =true skip numeric values in $array without err
     * @return bool
     */
    public function setArray($array, $skipNum = true)
    {
        $ans = false;
        if (is_array($array)) {
            $ans = true;
            foreach ($array as $k => $el) {
                if (is_string($k)) {
                    $this->$k = $el;
                } elseif (!$skipNum) {
                    $ans = false;
                    break;
                }
            }
        }
        return $ans;
    }

    /**
     * check if element $name exists
     * @param string $name element name
     * @param bool $getValue return variable value if defined, or null if not
     * @return bool|mixed
     */
    public function isSetted($name, $getValue = false)
    {
        $ans = false;
        if ($getValue) {
            $ans = null;
        }
        if (isset($this->dataStore__[$name])) {
            if ($getValue) {
                $ans = $this->dataStore__[$name];
            } else {
                $ans = true;
            }
        }
        return $ans;
    }
}
