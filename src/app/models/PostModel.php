<?php

namespace app\models;

use Ordo\Database\Model;
use Ordo\Database\QueryBuilder;

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

    public function querySmth()
    {
        $qBuilder = new QueryBuilder;
        $query = $qBuilder
                    ->delete('users', 'u')
                    ->andWhere('u.name = :name')
                    ->andWhere('u.age > 18')
                    ->orWhere('u.age < 10')
                    ->setParameter(':name', 'Name')
                    ->getQuery()
            ;

        dd($query);
    }
}

// class PostModel extends Model
// {
//     static protected string $tableName = 'posts';
//     private string $repository = PostRepository::class;

//     private int $number;
//     private string $message;

//     public array $validationRules = [
//         'message' => [
//             'Choice' => [
//                 'choices' => ['Alex','Anna'],
//                 'max'=>2,
//                 'multiple' => true,
//                 'multipleMessage' => 'Your values: {{ value }}',
//             ],
//             // 'NotBlank' => [ theye do not expect an array to be passed!
//             //     'message' => 'Not blank should it be!',
//             // ],
//             // 'Regex' => [
//             //     'pattern' => '/^[a-zA-Z]+$/',
//             //     'match' => true,
//             //     'message' => 'Your username should only contain letters, numbers and spaces',
//             // ],
//         ],
//         'number' => [
//             'Range' => [
//                 'min' => 3,
//                 'max' => 5,
//                 'NotInRangeMessage' => 'Value given: {{ value }} min: {{ min }}, max: {{ max }}',
//             ],
//             'LessThanOrEqual' => [
//                 'value' => 15,
//             ],
//             'NegativeOrZero',
//             'EqualTo' => [
//                 'value' => 17,
//                 'message' => 'This value should be equal to {{ compared_value }}, present {{ value }}',
//             ],
//             'NotEqualTo' => [
//                 'value' => 17,
//             ]
//         ]
//     ];


// }

// class PostRepository extends ModelRepository
// {
//     private string $model = PostModel::class;

//     public function querySmth()
//     {
//         $qBuilder = new QueryBuilder;
//         $query = $qBuilder
//                     ->delete('users', 'u')
//                     ->andWhere('u.name = :name')
//                     ->andWhere('u.age > 18')
//                     ->orWhere('u.age < 10')
//                     ->setParameter(':name', 'Name')
//                     ->getQuery()
//             ;

//         dd($query);
//     }
// }