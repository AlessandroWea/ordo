<?php

namespace Ordo\Validators\Constraints;

use Attribute;
use Ordo\Validators\Interfaces\ConstraintAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class NotEqualTo implements ConstraintAttribute
{
    public function __construct(
        public readonly int|null $value,
        public string|null $message = ''
    ){
    }
}