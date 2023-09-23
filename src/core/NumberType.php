<?php

namespace Ordo;

class NumberType extends AbstractFieldType
{
    protected ?int $min;
    protected ?int $max;
    protected ?int $step;
    protected ?string $list;

    public function __construct(string $formName, string $name, array $options)
    {
        parent::__construct($formName,$name, $options);

        $this->min = $options['min'] ?? null;
        $this->max = $options['max'] ?? null;
        $this->step = $options['step'] ?? null;
        $this->list = $options['list'] ?? null;
    }

    public function view($old_value) : string
    {
        $required = $this->isRequired ? 'required' : '';
        return "
            <label class='$this->labelClass'>$this->label</label>
            <input type='number' 
                    name='$this->formName[$this->name]' 
                    list='$this->list' 
                    min='$this->min' max='$this->max' step='$this->step' 
                    value='$old_value' 
                    placeholder='$this->placeholder' 
                    class='$this->class' $required>
        ";
    }
}   