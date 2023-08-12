<?php

namespace Ordo\Validators;
use Ordo\Validators\BaseValidator;

class BlankValidator extends BaseValidator
{
    public string $message = 'This value should not be blank';

    public function __construct($initData = [])
    {
        if(isset($initData['message']))
            $this->message = $initData['message'];
    }

    public function run($value)
    {
        return $value == null && $value == '';
    }
}