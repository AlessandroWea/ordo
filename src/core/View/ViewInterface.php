<?php

namespace Ordo\View;

interface ViewInterface
{
	public function render($path, $vars = []);
}