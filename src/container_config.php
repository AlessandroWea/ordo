<?php

use Ordo\Container;
use Ordo\Form\Form;
use Ordo\Form\FormInterface;
use Ordo\Validators\Interfaces\ValidatorInterface;
use Ordo\Validators\MainValidator;
use Ordo\View\ViewInterface;

$container = Container::instance();

$container->bind(ViewInterface::class, Ordo\View\ViewTwig::class);

$container->bind(FormInterface::class, Form::class);

$container->bind(Form::class, function(Container $c){
	return new Form('Unknown', [12,3,4]);
});

$container->bind(ValidatorInterface::class, MainValidator::class);

// $container->bind(FormInterface::class, function(Container $c){
// 	return new Form($c->get(DoingSomething::class), $c->get(DoingAnother::class));
// });

