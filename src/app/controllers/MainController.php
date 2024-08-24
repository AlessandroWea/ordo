<?php

namespace app\controllers;

use app\forms\AddProductFormType;
use Ordo\BaseController;
use Ordo\Form\FormBuilder;
use Ordo\Database\QueryBuilder;
use Ordo\View;
use app\models\PostModel;
use Ordo\Form\Form;
use app\models\User;
use Ordo\Database\EntityManager;
use app\repositories\UserRepository;
use Ordo\Security\Attributes\IsGranted;
use Ordo\Form\FormInterface;

class MainController extends BaseController
{
    public function __construct(
        private FormInterface $form,
        private QueryBuilder $qBuilder
    )
    {

    }

    public function runBefore()
    {
       
    }

    public function index($id = null, $str = 's')
    {
        View::render('main/index', [

        ]
    );
    }
}