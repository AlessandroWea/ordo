<?php

namespace Alewea\Malordo\Session;

class Session
{
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
}