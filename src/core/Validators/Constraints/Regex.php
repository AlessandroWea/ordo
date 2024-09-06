<?php

namespace Ordo\Validators\Constraints;

use Attribute;
use Ordo\Validators\Interfaces\ConstraintAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Regex implements ConstraintAttribute
{
    public function __construct(
        public string $message = 'The value is not appropriate to regex',
        public string $pattern = '',
        public bool $match = true
    ){
    }
}