<?php

namespace Ordo;

class SelectType extends AbstractFieldType
{

    protected array $options;

    public function __construct(string $formName, string $name, array $options)
    {
        parent::__construct($formName, $name, $options);

        $this->options = $options['options'] ?? [];
    }

    public function view($old_value) : string
    {
        $str = '<select>';

        foreach($this->options as $key => $value)
        {
            $str .= "<option name='$this->formName[$this->name]' value='$value'>$key</options";
        }

        $str .= '</select>';

        return $str;
    }

}