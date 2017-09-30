<?php

namespace Data;

abstract class AbstractData
{
    /**
     * @var array $dataStore__ data store
     */
    private $dataStore__ = array();

    /**
     * is data setted
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->dataStore__[$name]);
    }

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
    public function &__get($name)
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
    public function setArray(array $array, $skipNum = true): bool
    {
        $ans = true;
        foreach ($array as $k => $el) {
            if (is_string($k)) {
                $this->$k = $el;
            } elseif (!$skipNum) {
                $ans = false;
                break;
            }
        }
        return $ans;
    }

    /**
     * get all stored data as array
     * @return array
     */
    public function getArray(): array
    {
        return $this->dataStore__;
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
        $namesArr = explode(',', $names);
        if (is_array($namesArr)) {
            $ans = true;
            if ($getValue) {
                $ans = array();
            }
            foreach ($namesArr as $el) {
                if (isset($this->$el)) {
                    if ($getValue) {
                        $ans[$el] = $this->dataStore__[$el];
                    }
                } else {
                    $ans = false;
                    if ($getValue) {
                        $ans = null;
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

    public function reset(): void
    {
        reset($this->dataStore__);
    }

    public function count(): int
    {
        return count($this->dataStore__);
    }
}
