<?php

namespace Ordo\Database;

class Mapper
{
    public function __construct()
    {
      
    }

    public function map(object $entity)
    {
        $ref = new \ReflectionClass($entity);
        $classTableAttr = $ref->getAttributes('Ordo\Database\Mapping\Table')[0];
        if($classTableAttr)
        {
            $attrArgs = $classTableAttr->getArguments();
            $tableName = $attrArgs['name'];
        }
        $props = $ref->getProperties();
        $obj = [];
        $obj['meta']['_table'] = $tableName;
        foreach($props as $prop)
        {
            $attrs = $prop->getAttributes('Ordo\Database\Mapping\Column');
            if($attrs){
                $key = $prop->getName();
                $methodName = 'get' . ucfirst($key);
                $obj['data'][$key] = $entity->$methodName();
            }
        }

        return $obj;
    }
}