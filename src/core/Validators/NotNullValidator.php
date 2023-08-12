<?php

namespace Ordo\Validators;
use Ordo\Validators\BaseValidator;

class NotNullValidator extends BaseValidator
{
    public string $message = 'This value should not be null';

    public function __construct($initData = [])
    {
        if(isset($initData['message']))
            $this->message = $initData['message'];
    }

    public function run($value)
    {
        return $value !== null;
    }
}