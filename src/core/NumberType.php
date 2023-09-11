<?php

namespace Ordo;

class NumberType extends AbstractFieldType
{
    protected ?int $min;
    protected ?int $max;
    protected ?int $step;
    protected ?string $list;
    protected bool $isRequired;

    public function __construct(string $formName, string $name, array $options)
    {
        parent::__construct($formName,$name, $options);

        $this->min = $options['min'] ?? null;
        $this->max = $options['max'] ?? null;
        $this->step = $options['step'] ?? null;
        $this->list = $options['list'] ?? null;
        $this->isRequired = $options['required'] ?? true;

    }

    public function view() : string
    {
        $old_value = $_POST[$this->name] ?? '';
        $required = $this->isRequired ? 'required' : '';
        return "
            <label>$this->name</label>
            <input type='number' name='$this->formName[$this->name]' list='$this->list' min='$this->min' max='$this->max' step='$this->step' value='$old_value' placeholder='$this->placeholder' class='$this->class' $required>
        ";
    }
}