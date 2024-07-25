<?php

namespace Ordo;

class Container
{
    private array $objects = [
    ];
    private array $config = [];

    private array $excludedTypes = [
        'string','array'
    ];

    function __construct()
    {
        $this->objects['Ordo\Container'] = $this;
        $this->config = require '../src/container_config.php';
        dd($this->config);
    }

    public function get(string $class)
    {
        return isset($this->objects[$class]) ? $this->objects[$class] : $this->prepare($class);
    }

    public function prepare(string $class)
    {
        $classReflector = new \ReflectionClass($class);

        $constructReflector = $classReflector->getConstructor();
        if (empty($constructReflector)) {
            $obj = new $class;
            $this->objects[$class] = $obj;
            return $obj;
        }

        $constructArguments = $constructReflector->getParameters();
        if (empty($constructArguments)) {
            $obj = new $class;
            $this->objects[$class] = $obj;
            return $obj;
        }
        $args = [];
        foreach ($constructArguments as $argument) {
            $argumentType = $argument->getType();

            if(!$argumentType || in_array($argumentType->getName(), $this->excludedTypes))
            {
                $argName = $argument->getName();
                $args[$argName] = $this->config['services'][$class]['args'][$argName] ?? false;
                if($args[$argName] === false)
                    throw new \Exception('Cannot resolve dependencies in ' . $class);
            }
            else
            {
                $argumentType = $argumentType->getName();
                $args[$argument->getName()] = $this->get($argumentType);
            }
        }
        $obj = new $class(...$args);
        $this->objects[$class] = $obj;
        return $obj;
    }

}