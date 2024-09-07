<?php

namespace app\models;

use Ordo\Database\Mapping as ORM;
use app\repositories\UserRepository;
use Ordo\Validators\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Column]
    #[Assert\NotNull(message : 'Id should not be null!')]
    private int|null $id = null;

    #[ORM\Column]
    #[Assert\Blank(message : 'Name should be blank!')]
    #[Assert\Regex(pattern: '/[A-Z]+/')]
    private string|null $name = null;

    #[Assert\NotNull(message: 'Age should not be null!')]
    #[Assert\Range(max: 30, min: 18)]
    #[Assert\EqualTo(value: 20, message: 'Hehehe')]
    #[Assert\Choice(choices: [32,34,35,11])]
    private int|null $age = null;

    public function getId()
    {
        return $this->id;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }
 

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }


}
