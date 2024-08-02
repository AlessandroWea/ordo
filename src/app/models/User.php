<?php

namespace app\models;

use Ordo\Database\Mapping as ORM;
use app\repositories\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column]
    private string $name;


    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }


}
