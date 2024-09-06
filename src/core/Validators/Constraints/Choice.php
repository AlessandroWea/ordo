<?php

namespace Ordo\Validators\Constraints;

use Attribute;
use Ordo\Validators\Interfaces\ConstraintAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Choice implements ConstraintAttribute
{
    public function __construct(
    public array $choices = [],
    public ?int $max = null,
    public string $maxMessage = 'You must select at most {{ limit }} choices',
    public ?int $min = null,
    public string $minMessage = 'You must select at least {{ limit }} choices',
    public string $message = 'The value you selected is not a valid choice',
    public bool $multiple = false,
    public string $multipleMessage = 'One or more of the given values is invalid.',
    public bool $match = true
    ){
    }


}