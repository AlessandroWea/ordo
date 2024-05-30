<?php

namespace app\models;

use Ordo\Database\Model;

class PostModel extends Model
{
    static protected string $tableName = 'posts';
    static protected array $enabledCols = [];
    public array $validationRules = [
        'name' => [
            'Choice' => [
                'choices' => ['Alex','Anna'],
                'max'=>2,
                'multiple' => true,
                'multipleMessage' => 'Your values: {{ value }}',
            ],
            // 'NotBlank' => [ theye do not expect an array to be passed!
            //     'message' => 'Not blank should it be!',
            // ],
            // 'Regex' => [
            //     'pattern' => '/^[a-zA-Z]+$/',
            //     'match' => true,
            //     'message' => 'Your username should only contain letters, numbers and spaces',
            // ],
        ],
        'age' => [
            'Range' => [
                'min' => 3,
                'max' => 5,
                'NotInRangeMessage' => 'Value given: {{ value }} min: {{ min }}, max: {{ max }}',
            ],
            'LessThanOrEqual' => [
                'value' => 15,
            ],
            'NegativeOrZero',
            'EqualTo' => [
                'value' => 17,
                'message' => 'This value should be equal to {{ compared_value }}, present {{ value }}',
            ],
            'NotEqualTo' => [
                'value' => 17,
            ]
        ]
    ];
}