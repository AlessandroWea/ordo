<?php

namespace Ordo\Validators;
use Ordo\Validators\ComparisonValidator;

class GreaterThanValidator extends ComparisonValidator
{
    public string $message = 'This value should be greater than {{ compared_value }}';

    public function __construct($initData = [])
    {
        parent::__construct($initData);
    }

    public function compareValues($value1, $value2)
    {
        return $value1 < $value2;
    }
}