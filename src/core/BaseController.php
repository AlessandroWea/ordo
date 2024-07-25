<?php

namespace Ordo;

use Ordo\View;

class BaseController
{
    function __construct()
    {
    }

    public function runBefore()
    {
        return;
    }

    public function render($path, $vars)
    {
        return View::render($path, $vars);
    }

    public function redirect(string $path)
    {
        header('Location: /'.$path);
        exit();
    }

    public function isPost() : bool
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST');
    }

    public function json($arr)
    {
        echo json_encode($arr);
    }
}