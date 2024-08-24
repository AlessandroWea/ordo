<?php

namespace Ordo;

use Ordo\Container;
use Ordo\Security\SecurityHandler;
use Ordo\Router;

class App
{
    private SecurityHandler $securityHandler;
    private Router $router;

    public function __construct()
    {
        $this->securityHandler = Container::instance()->get(SecurityHandler::class);
        $this->router = new Router();
        $this->init();
    }

    public function init()
    {
        $this->securityHandler->initUser();
    }

    public function run()
    {
        [$controller_name, $method_name, $parts] = $this->router->dispatch($_SERVER['REQUEST_URI']);

        if(!$this->securityHandler->checkPathPermission($controller_name, $method_name))
        {
            throw new \Exception('Access denied!');
        }

        $controllerObject = Container::instance()->get($controller_name);

        if(method_exists($controllerObject, 'runBefore'))
        {
            $controllerObject->runBefore();
        }

        return $controllerObject->$method_name(...$parts);
    }
}