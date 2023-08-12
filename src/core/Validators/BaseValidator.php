<?php

namespace Ordo\Validators;

abstract class BaseValidator
{
    abstract public function run($value);
}