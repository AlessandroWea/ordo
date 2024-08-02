<?php

namespace Ordo\Security\Attributes;

use Attribute;
use Ordo\Security\Attributes\SecurityAttribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class IsGranted implements SecurityAttribute
{
    public function __construct(
        public readonly string|null $level = null
    ){
    }
}