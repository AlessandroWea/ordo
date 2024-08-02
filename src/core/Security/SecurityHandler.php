<?php

namespace Ordo\Security;

use Ordo\Session;
use Exception;

class SecurityHandler
{
    private array $rules;
    private Session $session;

    function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function initUser()
    {
        if(!$this->session->get(USER_SESSION_KEY)){
             $user = [
                'name' => 'anon',
                'roles' => ['ROLE_USER']
            ];
            $this->session->set(USER_SESSION_KEY, $user);         
        }

        // init USER in the session with default values (anon, default role, etc)
    }

    public function getUser()
    {
        return $this->session->get(USER_SESSION_KEY);
    }


    /**
     * Checks using attribute from class or method if user can access them
     * @param \ReflectionClass $ref_class Reflection object of the controller
     * @param \ReflectionMethod $ref_method Reflection object of the action method
     * @return bool
     */
    public function checkPathPermission(\ReflectionClass $ref_class, \ReflectionMethod $ref_method)
    {
        $pass = true;
        $user = $this->getUser();
        $attr = $ref_class->getAttributes('Ordo\Security\Attributes\IsGranted');
        if($attr){
            $attr = $attr[0];
            $role = $attr->getArguments()['level'];
            if(!in_array($role, $user['role'])){
                $pass = false;
            }
        }
        else {
            $attr = $ref_method->getAttributes('Ordo\Security\Attributes\IsGranted');
            if($attr){
                $role = $attr->getArguments()['level'];
                if(!in_array($role, $user['role'])){
                    $pass = false;
                }               
            }
        }

        return $pass;
    }

}