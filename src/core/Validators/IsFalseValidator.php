<?php

namespace Ordo\Validators;
use Ordo\Validators\BaseValidator;

class IsFalseValidator extends BaseValidator
{
    public string $message = 'This value should be true';

    public function __construct($initData = [])
    {
        if(isset($initData['message']))
            $this->message = $initData['message'];
    }

    public function run($value)
    {
        return $value === null || $value === false || 0 === $value || '0' === $value;
    }
}