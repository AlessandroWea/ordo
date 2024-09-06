<?php

namespace Ordo\Validators\Constraints;

use Ordo\Validators\Interfaces\ConstraintAttribute;
use Ordo\Validators\Constraints\EqualTo;
use Ordo\Validators\Exceptions\ConstraintValidatorException;
use Ordo\Validators\Interfaces\ConstraintValidatorInterface;


class EqualToValidator extends ComparisonValidator implements ConstraintValidatorInterface
{
    public function validate(mixed $value, ConstraintAttribute $constraint)
    {
        if(!$constraint instanceof EqualTo)
            throw new ConstraintValidatorException('Constraint for EqualToValidator should be ' . EqualTo::class);

        $constraint->message = $this->compileMessage($constraint->message, $value, $constraint->value);

        if($value == $constraint->value)
            return true;

        return false;

    }
}