<?php

namespace Ordo\Validators;
use Ordo\Validators\ComparisonValidator;

class NegativeValidator extends ComparisonValidator
{
    public string $message = 'This value should be negative';

    public function __construct($initData = [])
    {
        $initData['value'] = 0;
        parent::__construct($initData);
    }

    public function compareValues($value1, $value2)
    {
        return $value1 > $value2;
    }
}