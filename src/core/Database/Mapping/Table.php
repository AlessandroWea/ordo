<?php

namespace Ordo\Database\Mapping;

use Attribute;
use Ordo\Database\Mapping\MappingAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Table implements MappingAttribute
{
	public function __construct(
		public readonly string|null $name = null;
	){
	}
}