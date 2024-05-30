<?php

namespace app\forms;

use Ordo\Form\FieldType\CheckboxType;
use Ordo\Form\FormBuilder;
use Ordo\Form\FormTypeInterface;
use Ordo\Form\FieldType\NumberType;
use Ordo\Form\FieldType\SelectType;
use Ordo\Form\FieldType\TextType;
use Ordo\Validators\ChoiceValidator;
use Ordo\Validators\EqualToValidator;

class AddProductFormType implements FormTypeInterface
{
    public function viewSettings(FormBuilder $builder)
    {
        $builder
                ->add('name', TextType::class, [
                    'label' => 'Product name',
                    'label-class' => 'red',
                    'placeholder' => 'Enter product name',
                    'class' => 'red',
                    'validation' => [
                        new ChoiceValidator([
                            'choices' => ['Apple', 'Banana']
                        ])
                    ]
                ])
                ->add('price', NumberType::class, [
                    'label' => 'Product price',
                    'label-class' => 'red',
                    'placeholder' => 'Enter product price',
                    'list' => 'defaultNumbers',
                    'step' => '10',
                    'min' => 0,
                    'max' => 100,
                    'validation' => [
                        new EqualToValidator([
                            'value' => 100,
                        ])
                    ]
                ])
                ->add('enabled', CheckboxType::class, [
                    'label' => 'Is product enabled?',
                ])
                ->add('type', SelectType::class, [
                    'options' => [
                        'first' => 1,
                        'second' => 2,
                    ]
                ]);
    }
}