<?php

namespace Ordo\Validators;
use Ordo\Validators\ComparisonValidator;

class GreaterThanOrEqualValidator extends ComparisonValidator
{
    public string $message = 'This value should be greater or equal to {{ compared_value }}';

    public function __construct($initData = [])
    {
        parent::__construct($initData);
    }

    public function compareValues($value1, $value2)
    {
        return $value1 <= $value2;
    }
}