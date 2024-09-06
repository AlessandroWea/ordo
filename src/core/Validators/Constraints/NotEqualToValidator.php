<?php

namespace Ordo\Validators\Constraints;

use Ordo\Validators\Interfaces\ConstraintAttribute;
use Ordo\Validators\Constraints\NotEqualTo;
use Ordo\Validators\Exceptions\ConstraintValidatorException;
use Ordo\Validators\Interfaces\ConstraintValidatorInterface;

class NotEqualToValidator extends ComparisonValidator implements ConstraintValidatorInterface
{
    public function validate(mixed $value, ConstraintAttribute $constraint)
    {
        if(!$constraint instanceof NotEqualTo)
            throw new ConstraintValidatorException('Constraint for NotEqualToValidator should be ' . NotEqualTo::class);

        $constraint->message = $this->compileMessage($constraint->message, $value, $constraint->value);

        if($value != $constraint->value)
            return true;

        return false;

    }
}