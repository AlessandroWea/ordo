<?php

namespace app\models;

use Ordo\Database\Mapping as ORM;
use app\repositories\UserRepository;

#[ORM\Entity(repositoryClass: {CLASS}Repository::class)]
#[ORM\Table(name: '{TABLE}')]
class {CLASS}
{
    #[ORM\Column]
    private int|null $id = null;

{PROPERTIES}

{METHODS}
}
