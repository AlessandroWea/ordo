<?php

namespace Ordo\Validators;
use Ordo\Validators\ComparisonValidator;

class NotIdenticalToValidator extends ComparisonValidator
{
    public string $message = 'This value should not be identical to {{ compared_value }}';

    public function __construct($initData = [])
    {
        parent::__construct($initData);
    }

    public function compareValues($value1, $value2)
    {
        return $value1 !== $value2;
    }
}