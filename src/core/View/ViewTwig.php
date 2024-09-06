<?php

namespace Ordo\View;

use Ordo\View\ViewInterface;

class ViewTwig implements ViewInterface
{
	public $loader;
	public $twig;

	public function __construct()
	{
		$this->loader = new \Twig\Loader\FilesystemLoader(APP_VIEWS_FOLDER);
		$this->twig = new \Twig\Environment($this->loader, [
	    	'cache' => TEMPLATES_CACHE,
	    	'debug' => APP_IS_DEBUG,
		]);
	}

    public function render($path, $vars = [])
    {
		echo $this->twig->render($path, $vars);
    }
}