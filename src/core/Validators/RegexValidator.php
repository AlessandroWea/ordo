<?php

namespace Ordo\Validators;

use Exception;
use Ordo\Validators\BaseValidator;

class RegexValidator extends BaseValidator
{
    public string $message = 'This value is not valid';
    public bool $match = true;
    public string $pattern = '';

    public function __construct($initData = [])
    {
        if(isset($initData['pattern']))
            $this->pattern = $initData['pattern'];
        else
            throw new Exception('Pattern is not defined');

        if(isset($initData['match']))
        {
            if(!is_bool($initData['match']))
                throw new Exception('Match option should be boolean!');
            $this->match = $initData['match'];
        }

        if(isset($initData['message']))
            $this->message = $initData['message'];
    }

    public function run($value)
    {
        if($value === null) return true;
        $res = preg_match($this->pattern, $value, $match);
        if($res === 1) // found match
        {
            return $this->match == true ? true : false;
        } else if($res === 0) // not found match
        {
            return $this->match == false ? true : false;
        }
        else // failure occured
        {
            throw new Exception('Preg match failure');
        }
    }
}