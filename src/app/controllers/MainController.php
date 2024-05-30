<?php

namespace app\controllers;

use app\forms\AddProductFormType;
use Ordo\BaseController;
use Ordo\Form\FormBuilder;
use Ordo\Database\QueryBuilder;
use Ordo\View;

class MainController extends BaseController
{
    public function runBefore()
    {
       
    }

    public function index()
    {
        $form = (new FormBuilder)->build(AddProductFormType::class);

        // if($form->isSubmitted() && $form->isValid())
        // {
        //     dd($form->getData());
        // }

        // $query = (new QueryBuilder)
        //             ->select(QueryBuilder::ALL_COLUMNS)
        //             ->from('users', 'u')
        //             ->join('rules', 'r', 'u.ruleid = r.id')
        //             // ->where('u.id = ?1')
        //             ->where('u.id = :id')
        //             // ->setParameter(1, 2)
        //             ->setParameter(':id', 2)
        //             ->getQuery()
        // ;

        // $query = (new QueryBuilder)
        //             ->update('users', 'u')
        //             ->set('u.name', ':name')
        //             ->setParameter(':name', 'Name')
        //             ->getQuery()
        //     ;

        $query = (new QueryBuilder)
                    ->delete('users', 'u')
                    ->andWhere('u.name = :name')
                    ->andWhere('u.age > 18')
                    ->orWhere('u.age < 10')
                    ->setParameter(':name', 'Name')
                    ->getQuery()
            ;

        // $query = (new QueryBuilder)
        //             ->insert('users')
        //             ->setParameter(':name', 'Name')
        //             ->getQuery()

        // $query = (new QueryBuilder)
        //             ->update('users')
        //             ->where('id = :id')
        //             ->set('name')
        //             ->set('age')
        //             ->setParameter(':id', '1')
        //             ->setParameter(':name', 'Name')
        //             ->setParameter(':age', '18')
        //             ->getQuery()

        // dd($query);

        View::render('main/index', [
            'form' => $form,
        ]
    );
    }
}