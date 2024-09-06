<?php

namespace Ordo\Validators\Constraints;

use Attribute;
use Ordo\Validators\Interfaces\ConstraintAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Blank implements ConstraintAttribute
{
    public function __construct(
        public readonly string|null $message = ''
    ){
    }
}