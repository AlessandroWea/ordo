<?php

namespace Ordo\Form\FieldType;

abstract class AbstractFieldType
{
    protected string $name;
    protected string $placeholder;
    protected string $class;
    protected string $labelClass;
    protected string $formName;
    protected bool $isRequired;
    protected ?string $label;
    protected array $validators;
    protected string $error = '';

    public function __construct(string $formName, string $name, array $options)
    {
        $this->formName = $formName;
        $this->name= $name;
        $this->placeholder = $options['placeholder'] ?? '';
        $this->class = $options['class'] ?? '';
        $this->validators = $options['validation'] ?? [];
        $this->isRequired = $options['required'] ?? true;
        $this->label = $options['label'] ?? $this->name;
        $this->labelClass= $options['label-class'] ?? '';
    }  

    public abstract function view($old_value) : string;

    public function __toString()
    {
        $old_value = $_POST[$this->formName][$this->name] ?? '';
        return $this->view($old_value);
    }

    public function getError() : string
    {
        return $this->error;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function validate(mixed $value)
    {
        foreach($this->validators as $validator)
        {
            if(!$validator->run($value))
            {
                $this->error = $validator->message;
                return false;
            }
        }

        return true;
    }
}