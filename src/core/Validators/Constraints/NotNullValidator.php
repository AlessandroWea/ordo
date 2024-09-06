<?php

namespace Ordo\Validators\Constraints;

use Ordo\Validators\Interfaces\ConstraintAttribute;
use Ordo\Validators\Constraints\NotNull;
use Ordo\Validators\Interfaces\ConstraintValidatorInterface;
use Ordo\Validators\Exceptions\ConstraintValidatorException;

class NotNullValidator implements ConstraintValidatorInterface
{
    public function validate(mixed $value, ConstraintAttribute $constraint)
    {
        if(!$constraint instanceof NotNull)
            throw new ConstraintValidatorException('Constraint for NotNullValidator should be ' . NotNull::class);

        if($value !== null)
            return true;

        return false;

    }
}