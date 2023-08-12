<?php

namespace Ordo\Validators;
use Ordo\Validators\ComparisonValidator;

class PositiveValidator extends ComparisonValidator
{
    public string $message = 'This value should be positive';

    public function __construct($initData = [])
    {
        $initData['value'] = 0;
        parent::__construct($initData);
    }

    public function compareValues($value1, $value2)
    {
        return $value1 < $value2;
    }
}