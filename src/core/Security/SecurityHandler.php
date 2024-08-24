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
    }

    public function getUser()
    {
        return $this->session->get(USER_SESSION_KEY);
    }

    /**
     * Checks using attribute from class or method if user can access them
     * @param string $class the controller
     * @param string $method its action method
     * @return bool
     */
    public function checkPathPermission(string $class, string $method)
    {
        $ref_class = new \ReflectionClass($class);
        $ref_method = $ref_class->getMethod($method);

        $pass = true;
        $user = $this->getUser();
        
        $attr = $ref_class->getAttributes('Ordo\Security\Attributes\IsGranted');
        if($attr){
            $attr = $attr[0];
            $role = $attr->getArguments()['level'];
            if(!in_array($role, $user['roles'])){
                $pass = false;
            }
        }
        else {
            $attr = $ref_method->getAttributes('Ordo\Security\Attributes\IsGranted');
            if($attr){
                $role = $attr->getArguments()['level'];
                if(!in_array($role, $user['roles'])){
                    $pass = false;
                }               
            }
        }

        return $pass;
    }

}