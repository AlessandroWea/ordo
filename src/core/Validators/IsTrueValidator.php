<?php

namespace Ordo\Validators;
use Ordo\Validators\BaseValidator;

class IsTrueValidator extends BaseValidator
{
    public string $message = 'This value should be true';

    public function __construct($initData = [])
    {
        if(isset($initData['message']))
            $this->message = $initData['message'];
    }

    public function run($value)
    {
        return $value === null || $value === true || 1 === $value || '1' === $value;
    }
}