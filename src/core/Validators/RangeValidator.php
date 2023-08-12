<?php

namespace Ordo\Validators;

use Exception;
use Ordo\Validators\BaseValidator;

class RangeValidator extends BaseValidator
{
    public string $NotInRangeMessage = 'This value should be between {{ min }} and {{ max }}';
    public string $MinMessage = 'This value should be {{ limit }} or more.';
    public string $MaxMessage = 'This value should be {{ limit }} or less.';
    public string $InvalidMessage = ' This value should be a valid number.';
    public string $message = '';

    public ?int $min = null;
    public ?int $max = null;

    public function __construct($initData = [])
    {
        if(isset($initData['min']))
            $this->min = $initData['min'];
        else
            throw new Exception('Min is not defined');

        if(isset($initData['max']))
            $this->max = $initData['max'];
        else
            throw new Exception('Max is not defined');
            
        if(isset($initData['NotInRangeMessage']))
            $this->NotInRangeMessage = $initData['NotInRangeMessage'];
        if(isset($initData['MinMessage']))
            $this->MinMessage = $initData['MinMessage'];
        if(isset($initData['MaxMessage']))
            $this->MaxMessage = $initData['MaxMessage'];
        if(isset($initData['InvalidMessage']))
            $this->InvalidMessage = $initData['InvalidMessage'];
    }

    public function run($value)
    {
        if($value === null) return true;

        $this->NotInRangeMessage = str_replace(['{{ value }}', '{{ min }}', '{{ max }}'], [$value, $this->min, $this->max], $this->NotInRangeMessage);
        $this->MinMessage = str_replace(['{{ limit }}', '{{ value }}'], [$this->min, $value], $this->MinMessage);
        $this->MaxMessage = str_replace(['{{ limit }}', '{{ value }}'], [$this->max, $value], $this->MaxMessage);
        $this->InvalidMessage = str_replace('{{ value }}', $value, $this->InvalidMessage);

        if($value < $this->min)
        {
            $this->message = $this->MinMessage;
            return false;
        }
        else if($value > $this->max)
        {
            $this->message = $this->MaxMessage;
            return false;
        }

        return true;
    }
}