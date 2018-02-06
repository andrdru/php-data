<?php

namespace Data;

abstract class AbstractData
{
    /**
     * AbstractData constructor.
     * @param array $arr initial assoc array ['property'=>'value']
     */
    public function __construct(array $arr = array())
    {
        $this->setArray($arr);
    }

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
        $ans = null;
        if ($this->isSet($name)) {
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
            if (\is_string($k)) {
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
     * @param string $keys ='' keys to get, comma delimited
     * @return array
     */
    public function getArray($keys = ''): array
    {
        if (!$keys) {
            return $this->dataStore__;
        }
        $ans = array();
        $keysArr = explode(',', $keys);
        foreach ($keysArr as $el) {
            if ($this->isSet($el)) {
                $ans[$el] = $this->$el;
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
    public function isSet($names, $getValue = false)
    {
        $ans = false;
        if ($getValue) {
            $ans = null;
        }
        $namesArr = explode(',', $names);
        if (\is_array($namesArr)) {
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
        return \count($this->dataStore__);
    }

    /**
     * Set key of array with value
     * @param $name
     * @param $key
     * @param $value
     */
    public function setArrEl($name, $key, $value): void
    {
        $arr = $this->$name;
        if (!\is_array($arr)) {
            $arr = array($key => $value);
        } else {
            $arr[$key] = $value;
        }
        $this->$name = $arr;
    }

    /**
     * Append value to array
     * @param $name
     * @param $value
     */
    public function appendArrEl($name, $value): void
    {
        $arr = $this->$name;
        if (!\is_array($arr)) {
            $arr = array($value);
        } else {
            $arr[] = $value;
        }
        $this->$name = $arr;
    }
}
