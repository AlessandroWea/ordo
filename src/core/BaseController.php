<?php

namespace Ordo;

use Ordo\View;

class BaseController
{
    function __construct()
    {
    }

    public function render($path, $vars)
    {
        return View::render($path, $vars);
    }
}