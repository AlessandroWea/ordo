<?php

namespace Ordo\Validators;

abstract class ComparisonValidator
{
    public string $message = '';
    public ?int $compared_value = null;
    public string $compared_value_type = '';

    public function __construct($initData)
    {
        if(isset($initData['value']))
        {
            $this->compared_value = $initData['value'];
            $this->compared_value_type = gettype($this->compared_value);
        }
        else
        {
            throw new \Exception("EqualTo's 'value' option is required!");
        }

        if(isset($initData['message']))
            $this->message = $initData['message'];
    }

    abstract function compareValues($value1, $value2);

    public function run($value)
    {
        if(is_null($value))
            return true;

        //add 'compared_value' , 'compared_value_type', 'value' into msg if present '{{ variable }}'
        $this->message = str_replace('{{ compared_value }}', $this->compared_value, $this->message);
        $this->message = str_replace('{{ value }}', $value, $this->message);
        $this->message = str_replace('{{ compared_value_type }}', $this->compared_value_type, $this->message);

        return $this->compareValues($this->compared_value, $value);
    }
}