<?php

namespace app\controllers\admin;

use Ordo\BaseController;
use Ordo\Security\Attributes\IsGranted;

#[IsGranted(level: 'ROLE_ADMIN')]
class MainController extends BaseController
{

    public function runBefore()
    { 
    }

    public function index()
    {
        echo 'ADMIN SECTION';
    }
}