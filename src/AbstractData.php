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
     * @var array $data data store
     */
    private $data = array();

    /**
     * is data setted
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * set data element
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * get data element
     * @param $name
     * @return bool|mixed
     */
    public function &__get($name)
    {
        if (!isset($this->data[$name])) {
            $this->data[$name] = null;
        }
        return $this->data[$name];
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
     * @param bool $skipNull =false clear null values
     * @return array
     */
    public function getArray($keys = '', $skipNull = false): array
    {
        if (!$keys) {
            return $this->data;
        }
        $ans = array();
        $keysArr = explode(',', $keys);
        foreach ($keysArr as $el) {
            if (!$skipNull || $this->isSet($el)) {
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
                        $ans[$el] = $this->data[$el];
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

    public function current($moveCursor = true)
    {
        $ans = current($this->data);
        if ($moveCursor) {
            next($this->data);
        }
        return $ans;
    }

    public function key($moveCursor = true)
    {
        $ans = key($this->data);
        if ($moveCursor) {
            next($this->data);
        }
        return $ans;
    }

    public function reset(): void
    {
        reset($this->data);
    }

    public function next(): void
    {
        next($this->data);
    }

    public function prev(): void
    {
        prev($this->data);
    }

    public function end()
    {
        return end($this->data);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->data);
    }

    /**
     * Set key of array with value
     * @param $name
     * @param $key
     * @param $value
     * @deprecated use direct array setting instead
     */
    public function setArrEl($name, $key, $value): void
    {
        if (!isset($this->data[$name]) || !\is_array($this->data[$name])) {
            $this->data[$name] = array($key => $value);
        } else {
            $this->data[$name][$key] = $value;
        }
    }

    /**
     * Append value to array
     * @param $name
     * @param $value
     * @deprecated use direct array appending instead
     */
    public function appendArrEl($name, $value): void
    {
        if (!isset($this->data[$name]) || !\is_array($this->data[$name])) {
            $this->data[$name] = array($value);
        } else {
            $this->data[$name][] = $value;
        }
    }
}
