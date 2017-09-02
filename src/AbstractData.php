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
     * @param string $names elements names, divided by comma
     * @param bool $getValue return variable value if defined, or null if not
     * @return bool|mixed
     */
    public function isSetted($names, $getValue = false)
    {
        $ans = false;
        if ($getValue) {
            $ans = null;
        }
        $namesArr = explode(",", $names);
        if (is_array($namesArr)) {
            if ($getValue) {
                $ans = array();
            } else {
                $ans = true;
            }
            foreach ($namesArr as $el) {
                if (isset($this->dataStore__[$el])) {
                    if ($getValue) {
                        $ans[$el] = $this->dataStore__[$el];
                    }
                } else {
                    if ($getValue) {
                        $ans = null;
                    } else {
                        $ans = false;
                    }
                    break;
                }
            }
        }
        return $ans;
    }

    public function value($moveCursor = true)
    {
        $ans = current($this->dataStore__);
        if ($moveCursor) {
            next($this->dataStore__);
        }
        return $ans;
    }

    public function key($moveCursor = true)
    {
        $ans = key($this->dataStore__);
        if ($moveCursor) {
            next($this->dataStore__);
        }
        return $ans;
    }

    public function reset()
    {
        reset($this->dataStore__);
    }
}
