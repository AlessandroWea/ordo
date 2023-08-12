<?php

namespace Ordo\Validators;
use Ordo\Validators\ComparisonValidator;

class LessThanOrEqualValidator extends ComparisonValidator
{
    public string $message = 'This value should be less than or equal to {{ compared_value }}';

    public function __construct($initData = [])
    {
        parent::__construct($initData);
    }

    public function compareValues($value1, $value2)
    {
        return $value1 >= $value2;
    }
}