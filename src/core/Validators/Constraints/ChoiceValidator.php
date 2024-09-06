<?php

namespace Ordo\Validators\Constraints;

use Ordo\Validators\Interfaces\ConstraintAttribute;
use Ordo\Validators\Constraints\Choice;
use Ordo\Validators\Interfaces\ConstraintValidatorInterface;
use Ordo\Validators\Exceptions\ConstraintValidatorException;

class ChoiceValidator implements ConstraintValidatorInterface
{
    public function validate(mixed $value, ConstraintAttribute $constraint)
    {
        if(!$constraint instanceof Choice)
            throw new ConstraintValidatorException('Constraint for ChoiceValidator should be ' . Choice::class);

        $str_choices = join(', ', $constraint->choices);

        if($constraint->multiple)
        {
            if(!is_array($value))
                throw new ConstraintValidatorException('Choice validation: an array should be passed for choice validation!');

            $str_values = join(', ', $value);
            $constraint->multipleMessage = str_replace('{{ value }}', $str_values, $constraint->multipleMessage);
            $constraint->maxMessage = str_replace(['{{ value }}', '{{ choices }}', '{{ limit }}'], [$str_values, $str_choices, $constraint->max], $constraint->maxMessage);
            $constraint->minMessage = str_replace(['{{ value }}', '{{ choices }}', '{{ limit }}'], [$str_values, $str_choices, $constraint->min], $constraint->minMessage);

            // number of found elements
            $num = 0;
            foreach($value as $val)
            {
                if(!in_array($val, $constraint->choices))
                {
                    $constraint->message = $constraint->multipleMessage;
                    return false;
                }
                $num++;
            }

            if($constraint->min !== null && $num < $constraint->min)
            {
                $constraint->message = $constraint->minMessage;
                return false;
            }
            else if($constraint->max !== null && $num > $constraint->max)
            {
                $constraint->message = $constraint->maxMessage;
                return false;
            }

            return true;
        }

        if(is_array($value))
            throw new ConstraintValidatorException('Choice validation: the value given should be a scalar value');

        $constraint->message = str_replace(['{{ value }}', '{{ choices }}'], [$value, $str_choices], $constraint->message);

        return in_array($value, $constraint->choices);

    }
}