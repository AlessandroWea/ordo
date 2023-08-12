<?php

namespace Ordo\Validators;

use Exception;
use Ordo\Validators\BaseValidator;

class ChoiceValidator extends BaseValidator
{
    public array $choices = [];

    public ?int $max = null;
    //choices, value, limit=max
    public string $maxMessage = 'You must select at most {{ limit }} choices';

    public ?int $min = null;
    //choices, value, limit=min
    public string $minMessage = 'You must select at least {{ limit }} choices';

    // choices, value
    public string $message = 'The value you selected is not a valid choice';

    public bool $multiple = false;
    //value
    public string $multipleMessage = 'One or more of the given values is invalid.';

    public bool $match = true;

    public function __construct($initData = [])
    {
        if(isset($initData['choices']))
            $this->choices = $initData['choices'];
        else
            throw new Exception('Choices are not defined');

        if(isset($initData['match']))
            $this->match = $initData['match'];
        if(isset($initData['message']))
            $this->message = $initData['message'];

        if(isset($initData['multiple']))
        {
            $this->multiple = $initData['multiple'];
            if(isset($initData['multipleMessage']))
                $this->multipleMessage = $initData['multipleMessage']; 
            if($this->multiple)
            {
                if(isset($initData['min']))
                    $this->min = $initData['min'];
                if(isset($initData['minMessage']))
                    $this->minMessage = $initData['minMessage'];
                if(isset($initData['max']))
                    $this->max = $initData['max'];
                if(isset($initData['maxMessage']))
                    $this->maxMessage = $initData['maxMessage'];
            }
        }

    }

    public function run($value)
    {
        $str_choices = join(', ', $this->choices);

        if($this->multiple)
        {
            if(!is_array($value))
                throw new Exception('An array should be passed for choice validation!');

            $str_values = join(', ', $value);
            $this->multipleMessage = str_replace('{{ value }}', $str_values, $this->multipleMessage);
            $this->maxMessage = str_replace(['{{ value }}', '{{ choices }}', '{{ limit }}'], [$str_values, $str_choices, $this->max], $this->maxMessage);
            $this->minMessage = str_replace(['{{ value }}', '{{ choices }}', '{{ limit }}'], [$str_values, $str_choices, $this->min], $this->minMessage);

            // number of found elements
            $num = 0;
            foreach($value as $val)
            {
                if(!in_array($val, $this->choices))
                {
                    $this->message = $this->multipleMessage;
                    return false;
                }
                $num++;
            }

            if($this->min !== null && $num < $this->min)
            {
                $this->message = $this->minMessage;
                return false;
            }
            else if($this->max !== null && $num > $this->max)
            {
                $this->message = $this->maxMessage;
                return false;
            }

            return true;
        }

        if(is_array($value))
            throw new Exception('The value should be a scalar value');

        $this->message = str_replace('{{ value }}, {{ choices }}', [$value, $str_choices], $this->message);

        return in_array($value, $this->choices);
    }
}