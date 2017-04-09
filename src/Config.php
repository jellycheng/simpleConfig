<?php
namespace SimpleConfig;
use ArrayAccess;
use Closure;

class Config implements ArrayAccess {

    protected static $configData = [];

    protected function __construct()
    {

    }

    public static function create() {
        static $instance;

        if(!$instance) {
            $instance = new static();
        }
        return $instance;
    }

    public function getAll()
    {
        return self::$configData;
    }

    protected function _value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }

    public function get($key=null, $default = null)
    {
        $array = self::$configData;
        if (is_null($key)) return $array;

        if (isset($array[$key])) return $array[$key];

        foreach (explode('.', $key) as $segment)
        {
            if ( ! is_array($array) || ! array_key_exists($segment, $array))
            {
                return $this->_value($default);
            }

            $array = $array[$segment];
        }

        return $array;

    }

    function set($key, $value)
    {
        $config = [];
        $array    = &$config;
        if (is_null($key)) return self::$configData = $value;
        $keys = explode('.', $key);
        while (count($keys) > 1)
        {
            $key = array_shift($keys);
            if ( ! isset($array[$key]) || ! is_array($array[$key]))
            {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
        self::$configData = array_replace_recursive(self::$configData, $config);
        return $this;
    }

    public function has($key)
    {
        $array = self::$configData;
        if (empty($array) || is_null($key)) return false;
        if (array_key_exists($key, $array)) return true;
        $keysAry = explode('.', $key);
        foreach ($keysAry as $segment)
        {
            if ( ! is_array($array) || ! array_key_exists($segment, $array))
            {
                return false;
            }
            $array = $array[$segment];
        }
        return true;
    }

    public function del($keys)
    {
        $array = self::$configData;
        $original =& $array;

        foreach ((array) $keys as $key)
        {
            $parts = explode('.', $key);

            while (count($parts) > 1)
            {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part]))
                {
                    $array =& $array[$part];
                }
            }

            unset($array[array_shift($parts)]);
            $array =& $original;
        }
        self::$configData = $array;
        return $this;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->del($offset);
    }

}