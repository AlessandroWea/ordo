<?php

namespace Ordo;

use Ordo\Container;
use Ordo\Security\SecurityHandler;

class App
{
    public string $default_controller = 'main';
    public string $default_method = 'index';
    public array $modules;

    public Container $container;
    private SecurityHandler $securityHandler;

    public function __construct()
    {
        $this->container = new Container();
        $this->securityHandler = $this->container->get(SecurityHandler::class);
        $this->modules = require '../src/modules.php';
        $this->init();
    }

    public function init()
    {
        $this->securityHandler->initUser();
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        dd($uri);
        $parts = explode('/',$uri);
        array_shift($parts);

        $module = '';

        $controller_name = $this->default_controller;
        $method_name = $this->default_method;
        if($parts[0] != ''){

            //check for modules
            if(in_array($parts[0], $this->modules)){
                $module = $parts[0];
                array_shift($parts);
            }

            if(count($parts) > 0){
                if(count($parts) < 2){
                    $controller_name = array_shift($parts);
                }else {
                    $controller_name = array_shift($parts);
                    $method_name = array_shift($parts);
                }               
            }


        }

        $controller_name = ucfirst($controller_name) . 'Controller';

        try
        {
            $module = ($module != '') ? ($module . '\\') : $module;
            $reflectionObject = new \ReflectionClass('app\controllers\\' . $module . $controller_name);

            $object = $reflectionObject->newInstanceArgs();
            $method = $reflectionObject->getMethod($method_name);

            if(!$this->securityHandler->checkPathPermission($reflectionObject, $method))
            {
                throw new \Exception('Access denied');
            }

            $params = $method->getParameters();
            $index = 0;
            foreach($params as $param){
                $type = $param->getType();
                if(!$type)
                {
                    $parts[$index] = $parts[$index] ?? false;
                    $index++;
                    continue; 
                }
                $type = $type->getName();
                $parts[$index++] = $this->container->get($type);
            }
            if(method_exists($object, 'runBefore'))
            {
                $beforeMethod = $reflectionObject->getMethod('runBefore');
                $beforeMethod->invoke($object);
            }

            if(!empty($parts[0])){
                return $method->invokeArgs($object, $parts ?? []);
            }
            else
            {
                return $method->invokeArgs($object, $parts);
            }
        }
        catch(\ReflectionException $e)
        {
            echo '<h1>404 Not found</h1>';
            echo '<p>' . $e->getMessage() . '</p>';
            //show 404 error page
            die;
        }
        catch(\Exception $e)
        {
            echo $e->getMessage();
            die;
        }

    }
}