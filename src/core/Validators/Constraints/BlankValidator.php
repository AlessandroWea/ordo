<?php

namespace Ordo\Validators\Constraints;

use Ordo\Validators\Interfaces\ConstraintAttribute;
use Ordo\Validators\Constraints\Blank;
use Ordo\Validators\Interfaces\ConstraintValidatorInterface;
use Ordo\Validators\Exceptions\ConstraintValidatorException;

class BlankValidator implements ConstraintValidatorInterface
{
    public function validate(mixed $value, ConstraintAttribute $constraint)
    {
        if(!$constraint instanceof Blank)
            throw new ConstraintValidatorException('Constraint for BlankValidator should be ' . Blank::class);

        if($value == null && $value == '');
            return true;

        return false;

    }
}