<?php

namespace app\repositories;

use Ordo\Database\EntityRepository;
use app\models\Usero;

class UseroRepository extends EntityRepository
{
    public function __construct()
    {
        parent::__construct(Usero::class);
    }

    // public function customQuery()
    // {
    //     $query = $this->queryBuilder
    //                 ->delete('users', 'u')
    //                 ->andWhere('u.name = :name')
    //                 ->andWhere('u.age > 18')
    //                 ->orWhere('u.age < 10')
    //                 ->setParameter(':name', 'Name')
    //                 ->getQuery()
    //         ;
    // }
}
