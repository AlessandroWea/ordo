<?php

namespace Ordo;

abstract class AbstractFieldType
{
    protected string $name;
    protected string $placeholder;
    protected string $class;
    protected string $formName;
    protected array $validators;
    protected string $error = '';

    public function __construct(string $formName, string $name, array $options)
    {
        $this->formName = $formName;
        $this->name= $name;
        $this->placeholder = $options['placeholder'] ?? '';
        $this->class = $options['class'] ?? '';
        $this->validators = $options['validation'] ?? [];
    }

    public abstract function view() : string;

    public function __toString()
    {
        return $this->view();
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