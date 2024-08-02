<?php

namespace Ordo;

class Session
{
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        if($this->has($key))
            return $_SESSION[$key];
        else
            return null;
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
}