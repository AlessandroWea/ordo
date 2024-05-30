<?php

namespace Ordo\Form\FieldType;

class RadioType extends AbstractFieldType
{
    public function __construct(string $formName, string $name, array $options)
    {
        parent::__construct($formName, $name, $options);
    }

    public function view($old_value) : string
    {
        return "
            <label>$this->name</label>
            <input type='radio' name='$this->formName[$this->name]' value='$old_value' class='$this->class'>
        ";
    }
}