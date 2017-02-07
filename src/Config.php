<?php
namespace SimpleConfig;
use ArrayAccess;


class Config implements ArrayAccess {

    private static $config = [];

    public static function create() {
        static $instance;

        if(!$instance) {
            $instance = new static();
        }
        return $instance;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}