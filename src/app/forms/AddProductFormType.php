<?php

namespace app\forms;

use Ordo\FormBuilder;
use Ordo\FormTypeInterface;
use Ordo\NumberType;
use Ordo\RadioType;
use Ordo\TextType;
use Ordo\Validators\ChoiceValidator;
use Ordo\Validators\EqualToValidator;

class AddProductFormType implements FormTypeInterface
{
    public function viewSettings(FormBuilder $builder)
    {
        $builder
                ->add('name', TextType::class, [
                    'label' => 'Product name',
                    'placeholder' => 'Enter product name',
                    'class' => 'form-control',
                    'validation' => [
                        new ChoiceValidator([
                            'choices' => ['Apple', 'Banana']
                        ])
                    ]
                ])
                ->add('price', NumberType::class, [
                    'label' => 'Product price',
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
                ->add('enabled', RadioType::class, [
                    'label' => 'Is product enabled?',
                ]);
    }
}