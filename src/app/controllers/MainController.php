<?php

namespace app\controllers;

use Ordo\BaseController;
use Ordo\Form\FormBuilder;
use app\models\User;
use Ordo\Validators\Interfaces\ValidatorInterface;
use Ordo\View\ViewInterface;

class MainController extends BaseController
{
    public function __construct(
        private ViewInterface $view,
        private ValidatorInterface $validator
    )
    {

    }

    public function runBefore()
    {
       
    }

    public function index($id = null, $str = 's')
    {
        $user = new User();
        $user->setName('ee');
        $user->setAge('1');

        $errors = $this->validator->validate($user);
        if(count($errors) > 0)
        {
            echo 'There are some errors! : ' . "</br>";
            dd($errors);
        }
        else
        {
            echo 'There are no errors!';
        }
        $this->view->render('main/main.twig.html', []);
    }
}