<?php

namespace Ordo\Form;

class Form
{
    public array $fields = [];
    public string $formName;
    public string $method = 'post';
    public static string $GET = 'get';
    public static string $POST = 'post';

    public function __construct(string $formName, array $fields)
    {
        $this->formName = $formName;
        $this->fields = $fields;
    }

    public function __toString()
    {
        $form = $this->start();
        foreach($this->fields as $field)
        {
            $form .= $field;
        }
        $form .= $this->end();

        return $form;
    }

    public function isSubmitted()
    {
        return isset($_POST[$this->formName]);
    }

    public function isValid()
    {
        $is_valid = true;
        foreach($this->fields as $field)
        {
            $value = $_POST[$this->formName][$field->getName()] ?? null;
            if(!$field->validate($value))
                $is_valid = false;
        }
        return $is_valid;
    }

    public function error($fieldName)
    {
        return $this->fields[$fieldName]->getError();
    }

    public function getData()
    {
        return $_POST[$this->formName];
    }

    public function start()
    {
        return "<form method='$this->method'>";
    }

    public function end()
    {
        return '</form>';
    }

    public function __get($name)
    {
        return $this->fields[$name] ?? null;
    }
}