<?php

namespace Ordo;

class FormBuilder
{
    private array $data = [];
    private string $formName = '';

    public function add(string $name, string $type, array $options)
    {
        $this->data[$name] = [
            'type' => $type,
            'options' => $options,
        ];
        return $this;
    }

    public function build(string $formType = '') : Form
    {
        $fields = [];
        if($formType)
        {
            (new $formType)->viewSettings($this);
            $tmp = explode('\\', $formType);
            $tmp = end($tmp);
            $this->formName = strtolower(str_replace('FormType', '', $tmp));
            dd($this->formName);
        }

        $names = array_keys($this->data);
        foreach($names as $name)
        {
            $fieldType = $this->data[$name]['type'];
            $fieldOptions = $this->data[$name]['options'];
            
            $fieldTypeObj = new $fieldType($this->formName, $name, $fieldOptions);

            $fields[$name] = $fieldTypeObj;
        }

        $form = new Form($this->formName,$fields);

        return $form;
    }

}