<?php

namespace Ordo\Validators\Constraints;

use Attribute;
use Ordo\Validators\Interfaces\ConstraintAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Range implements ConstraintAttribute
{
    public function __construct(
        public int $min,
        public int $max,
        public string $notInRangeMessage = 'This value should be between {{ min }} and {{ max }}',
        public string $maxMessage = 'This value should be {{ limit }} or less.',
        public string $minMessage = 'This value should be {{ limit }} or more.',
        public string $invalidMessage = ' This value should be a valid number.',
        public string $message = ''
    ){
    }


}