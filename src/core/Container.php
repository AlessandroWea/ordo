<?php

namespace Ordo;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    static private Container|null $instance = null;

    private array $objects = [];
    private array $entries = [];

    private function __construct() {}

    public static function instance()
    {
        if(static::$instance == null)
            static::$instance = new Container();

        return static::$instance;
    }

    public function get(string $id)
    {
        if($this->has($id))
            return $this->objects[$id];

        $entry = $id;
        if($this->has_entries($id))
        {
            if(is_callable($this->entries[$id]))
                return $this->entries[$id]($this);

            $entry = $this->entries[$id];
        }

        return $this->prepare($entry);

    }

    public function has(string $id) : bool
    {
        return isset($this->objects[$id]);
    }

    public function has_entries(string $id) : bool
    {
        return isset($this->entries[$id]);
    }

    public function bind(string $id, callable|string $arg)
    {
        $this->entries[$id] = $arg;
    }

    public function prepare(string $class)
    {
        if(!class_exists($class))
            throw new \Exception('Container::prepare: Class ' . $class . ' doesnt exist');
        
        $classReflector = new \ReflectionClass($class);
        if($classReflector->isInterface())
            throw new \Exception('Cannot resolve dependencies for ' . $class);

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

        if($this->has_entries($class))
        {
            $obj = $this->get($class);
            $this->objects[$class] = $obj;
            return $obj;
        }

        $args = [];
        foreach ($constructArguments as $argument) {
            if(!$argument->hasType())
            {
                throw new NotSpecifiedTypeContainerException('The type should be specified in ' . $class);
            }

            $argumentType = $argument->getType();
            if(!$argumentType instanceof \ReflectionNamedType || $argumentType->isBuiltin())
            {
                throw new \Exception('Cannot resolve dependencies in ' . $class);
            }

            $args[] = $this->get($argumentType->getName());
            
        }
        $obj = new $class(...$args);
        $this->objects[$class] = $obj;
        return $obj;
    }

}