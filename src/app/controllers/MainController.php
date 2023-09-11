<?php

namespace app\controllers;

use app\forms\AddProductFormType;
use Ordo\BaseController;
use Ordo\FormBuilder;
use Ordo\View;

class MainController extends BaseController
{
    public function runBefore()
    {
       
    }

    public function index()
    {
        $form = (new FormBuilder)->build(AddProductFormType::class);

        if($form->isSubmitted() && $form->isValid())
        {
            dd($form->getData());
        }

        View::render('main/index', [
            'form' => $form,
        ]
    );
    }
}