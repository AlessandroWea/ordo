<?php

namespace Ordo\Form\FieldType;

class TextType extends AbstractFieldType
{
    public function __construct(string $formName, string $name, array $options)
    {
        parent::__construct($formName, $name, $options);
    }

    public function view($old_value) : string
    {
        return "
            <label class='$this->labelClass'>$this->label</label>
            <input type='text' 
                    name='$this->formName[$this->name]' 
                    value='$old_value' 
                    placeholder='$this->placeholder' 
                    class='$this->class'>
        "; 
    }

}