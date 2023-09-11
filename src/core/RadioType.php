<?php

namespace Ordo;

class RadioType extends AbstractFieldType
{
    public function __construct(string $formName, string $name, array $options)
    {
        parent::__construct($formName, $name, $options);
    }

    public function view() : string
    {
        $olt_value = $_POST[$this->name] ?? '';
        return "
            <label>$this->name</label>
            <input type='radio' name='$this->formName[$this->name]' value='$olt_value' class='$this->class'>
        ";
    }
}