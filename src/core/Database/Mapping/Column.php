<?php

namespace Ordo\Database;

use Attribute;
use Ordo\Database\Mapping\MappingAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Column implements MappingAttribute
{
	public function __construct(
		public readonly string|null $name = null
	){
	}
}