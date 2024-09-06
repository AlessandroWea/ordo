<?php

namespace Ordo\Validators;

use Ordo\Validators\Interfaces\ValidatorInterface;
use Ordo\Database\Mapping\Entity;
use Ordo\Validators\Interfaces\ConstraintAttribute;
use Ordo\Validators\Exceptions\ConstraintValidatorException;

class MainValidator implements ValidatorInterface 
{
    private array $errors = [];

    public function validate(object $obj)
    {
        $reflection = new \ReflectionClass($obj);
        $entityAttributes = $reflection->getAttributes(Entity::class);

        if(!$entityAttributes)
            throw new ConstraintValidatorException('Object given is not an entity: ' . $obj::class);

        $props = $reflection->getProperties();
        foreach($props as $prop)
        {
            $propName = $prop->getName();
            $get = 'get' . ucfirst($propName);

            if(!method_exists($obj, $get))
                throw new ConstraintValidatorException('Method ' . $get . '() is not implemented in ' . $obj::class);

            $propValue = $obj->$get();
            $attrs = $prop->getAttributes();

            foreach($attrs as $attr)
            {
                if( ( new \ReflectionClass($attr->getName()) )->implementsInterface(ConstraintAttribute::class) )
                {
                    $validator = new ($attr->getName() . 'Validator');
                    $constraint = $attr->newInstance();
                    $ret = $validator->validate($propValue, $constraint);
                    if(!$ret)
                        $this->errors[$propName][] = $constraint->message;
                }
            }
        }

        return $this->errors;
    }
}