<?php

namespace Ordo;

class Router
{
    private string $default_controller = 'main';
    private string $default_method = 'index';
    private static array $modules = [];

    public function dispatch(string $uri) : array
    {
        $parts = explode('/',$uri);
        array_shift($parts);

        $module = '';

        $controller_name = $this->default_controller;
        $method_name = $this->default_method;
        if($parts[0] != ''){

            //check for modules
            if(in_array($parts[0], static::$modules)){
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
        
        if(isset($parts[0]) && $parts[0] == '')
            $parts = [];

        $controller_name = ucfirst($controller_name) . 'Controller';
        $module = ($module != '') ? ($module . '\\') : $module;
        $controller_name = 'app\controllers\\' . $module . $controller_name;

        return [$controller_name, $method_name, $parts];

    }

    public static function registerModule(string $name)
    {
        if(is_numeric($name))
            throw new \Exception('Module name should not be numeric! (given: ' . $name . ')');
        static::$modules[] = $name;
    }

    public static function getModules() : array
    {
        return static::$modules;
    }

}