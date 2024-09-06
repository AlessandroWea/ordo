<?php

namespace Ordo\Validators\Constraints;

use Ordo\Validators\Interfaces\ConstraintAttribute;
use Ordo\Validators\Constraints\Range;
use Ordo\Validators\Interfaces\ConstraintValidatorInterface;
use Ordo\Validators\Exceptions\ConstraintValidatorException;


class RangeValidator implements ConstraintValidatorInterface
{
    public function validate(mixed $value, ConstraintAttribute $constraint)
    {
        if(!$constraint instanceof Range)
            throw new ConstraintValidatorException('Constraint for RangeValidator should be ' . Range::class);

        if($value == null) return true;

        $this->compileMessages($constraint, $value);

        if($value < $constraint->min)
        {
            $constraint->message = $constraint->minMessage;
            return false;
        }
        else if($value > $constraint->max)
        {
            $constraint->message = $constraint->maxMessage;
            return false;
        }

        return true;

    }

    public function compileMessages(ConstraintAttribute $constraint, mixed $value)
    {
        $constraint->notInRangeMessage = str_replace(['{{ value }}', '{{ min }}', '{{ max }}'], [$value, $constraint->min, $constraint->max], $constraint->notInRangeMessage);
        $constraint->minMessage = str_replace(['{{ limit }}', '{{ value }}'], [$constraint->min, $value], $constraint->minMessage);
        $constraint->maxMessage = str_replace(['{{ limit }}', '{{ value }}'], [$constraint->max, $value], $constraint->maxMessage);
        $constraint->invalidMessage = str_replace('{{ value }}', $value, $constraint->invalidMessage);
    }

}