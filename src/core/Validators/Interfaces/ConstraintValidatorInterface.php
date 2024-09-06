<?php

namespace Ordo\Validators\Interfaces;

use Ordo\Validators\Interfaces\ConstraintAttribute;

interface ConstraintValidatorInterface
{
    public function validate(mixed $value, ConstraintAttribute $constraint);
}