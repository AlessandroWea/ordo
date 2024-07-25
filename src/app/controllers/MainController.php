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

class MainController extends BaseController
{

    public function runBefore()
    {
       
    }

    public function index(
        UserRepository $urepo,
        EntityManager $em,
        Form $form,
        FormBuilder $fBuilder,
        QueryBuilder $qBuilder
    )
    {
        // $fBuilder = $this->container->get(FormBuilder::class);
        // $form = (new FormBuilder)->build(AddProductFormType::class);
        $form = $fBuilder->build(AddProductFormType::class);
        $form->method = Form::$GET;
        $user = new User();
        $user->setId(1);
        $user->setName('A');
        $user->setAge(1);
        //1) make and save query to insert a new user into its table
        $em->persist($user);

        $user->setAge(2);

        //2) execute all saved queries to insert
        $em->flush();

        $em->getRepository(User::class);

        $urepo->setLimit(5);
        $urepo->setOffset(3);
        dd($urepo->findAll());

        // $ref = new \ReflectionClass(User::class);
        // $attributes = $ref->getAttributes();
        // dd($attributes[0]->getName());
        // dd($attributes[0]->getArguments());

        $query = $qBuilder
                    ->delete('users', 'u')
                    ->andWhere('u.name = :name')
                    ->andWhere('u.age > 18')
                    ->orWhere('u.age < 10')
                    ->setParameter(':name', 'Name')
                    ->getQuery()
            ;

        // $query = $qBuilder
        //             ->insert('users', 'u')
        //             ->set($args)
        //             ->getQuery()
        //     ;

        View::render('main/index', [
            'form' => $form,
        ]
    );
    }
}