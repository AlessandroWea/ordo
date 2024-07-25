<?php

namespace app\models;

use Ordo\Database\Model;
use Ordo\Database\QueryBuilder;
use Ordo\Database\Mapping as ORM;
use app\repositories\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User
{
    private string $tableName = 'users';

    // [Ordo\Database\Id]
    // [Ordo\Database\GeneratedValue]
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private string $age;

    public array $validationRules = [
        'name' => [
            'Choice' => [
                'choices' => ['Alex','Anna'],
                'max'=>2,
                'multiple' => true,
                'multipleMessage' => 'Your values: {{ value }}',
            ],
        ],
        'age' => [
            'EqualTo' => [
                'value' => 17,
                'message' => 'This value should be equal to {{ compared_value }}, present {{ value }}',
            ]
        ]
    ];

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

}
