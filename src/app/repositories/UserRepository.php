<?php

namespace app\repositories;

use Ordo\Database\Model;
use Ordo\Database\QueryBuilder;
use Ordo\Database\EntityRepository;
use app\models\User;

class UserRepository extends EntityRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }


    public function customQuery()
    {
        $query = $this->queryBuilder
                    ->delete('users', 'u')
                    ->andWhere('u.name = :name')
                    ->andWhere('u.age > 18')
                    ->orWhere('u.age < 10')
                    ->setParameter(':name', 'Name')
                    ->getQuery()
            ;

        return ['a',2];
    }
}
