<?php

namespace Ordo\Validators\Constraints;

class ComparisonValidator
{
    public function compileMessage($message, $value_given, $value_checked_with) : string
    {
        $message = str_replace('{{ compared_value }}', $value_checked_with, $message);
        $message = str_replace('{{ value }}', $value_given, $message);
        $message = str_replace('{{ compared_value_type }}', gettype($value_checked_with), $message);
        return $message;
    }
}