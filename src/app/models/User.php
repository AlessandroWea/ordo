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
    private string $nickname;



    public function setNickname
    {
        $this->nickname = nickname;
    }


}
