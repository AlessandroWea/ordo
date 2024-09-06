<?php

namespace Ordo\Database\Mapping;

use Attribute;
use Ordo\Database\Mapping\MappingAttribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Entity implements MappingAttribute
{
    public function __construct(
        public readonly string|null $repositoryClass = null
    ){
    }
}