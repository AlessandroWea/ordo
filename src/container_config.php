<?php

use Ordo\Container;
use Ordo\Form\Form;
use Ordo\Form\FormInterface;

$container = Container::instance();

$container->bind(FormInterface::class, Form::class);

$container->bind(Form::class, function(Container $c){
	return new Form('Unknown', [12,3,4]);
});

// $container->bind(FormInterface::class, function(Container $c){
// 	return new Form($c->get(DoingSomething::class), $c->get(DoingAnother::class));
// });

