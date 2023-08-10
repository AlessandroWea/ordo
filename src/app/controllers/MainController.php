<?php

namespace app\controllers;

use Ordo\BaseController;
use Ordo\View;

class MainController extends BaseController
{
    public function index()
    {
        View::render('main/index');
    }
}