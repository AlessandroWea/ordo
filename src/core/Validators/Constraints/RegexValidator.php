<?php

namespace Ordo\Validators\Constraints;

use Ordo\Validators\Interfaces\ConstraintAttribute;
use Ordo\Validators\Constraints\Regex;
use Ordo\Validators\Interfaces\ConstraintValidatorInterface;
use Ordo\Validators\Exceptions\ConstraintValidatorException;

class RegexValidator implements ConstraintValidatorInterface
{
    public function validate(mixed $value, ConstraintAttribute $constraint)
    {
        if(!$constraint instanceof Regex)
            throw new ConstraintValidatorException('Constraint for RegexValidator should be ' . Regex::class);

        if($value === null) return true;
        $res = preg_match($constraint->pattern, $value, $match);
        if($res === 1) // found match
        {
            return $constraint->match == true ? true : false;
        } else if($res === 0) // not found match
        {
            return $constraint->match == false ? true : false;
        }
        else // failure occured
        {
            throw new ConstraintValidatorException('Regex validation: preg match failure');
        }

    }
}