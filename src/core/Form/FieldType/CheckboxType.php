<?php

namespace Ordo\Form\FieldType;

class CheckboxType extends AbstractFieldType
{
    public function __construct(string $formName, string $name, array $options)
    {
        parent::__construct($formName, $name, $options);
    }

    public function view($old_value) : string
    {
        return "
            <label>$this->label</label>
            <input type='checkbox'
                name='$this->formName[$this->name]'
                value='$old_value'
                class='$this->class'>
        ";
    }
}