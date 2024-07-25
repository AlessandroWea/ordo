<?php

namespace Ordo\Database;

use Ordo\Database\Mapping\Entity;

use Ordo\Container;
use Ordo\Database\QueryBuilder;
use Ordo\Database\Mapper;


class EntityManager
{
    private Container|null $container = null;
    public array $objectsToSave = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

   public function persist($entity) //app/models/User object
   {
        if(!is_object($entity))
        {
            throw new \Exception('The parameter of PERSIST should be an object!');
        }
        $this->objectsToSave[] = $entity;
   }


   //saves all created objects
   //if ID is declared it's an old object
   //id ID is not declared it's a new object
   public function flush()
   {
        $qBuilder = $this->container->get(QueryBuilder::class);
        $mapper = $this->container->get(Mapper::class);

        foreach($this->objectsToSave as $object)
        {
            $object = $mapper->map($object);
            if($object['data']['id'] != null)
            {
                 $query = $qBuilder
                            ->update($object['meta']['_table'])
                            ->set($object['data'])
                            ->getQuery();
                ;
            }
            else
            {
                 $query = $qBuilder
                            ->insert($object['meta']['_table'])
                            ->set($object['data'])
                            ->getQuery();
                ;
            }

            dd('EXECUTION!!!');
            dd($query);
            dd('EXECUTED!!!');
        }
   }

   public function getRepository(string $entity)
   {
        return $this->container->get($entity);
   }

   private function _getRepository($entity)
   {
        $repoName ='app\repositories\\' . @end(explode('\\', $entity::class)) . 'Repository';
        $repo = $this->container->get($repoName);
        return $repo;
   }
}