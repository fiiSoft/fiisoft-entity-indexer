<?php

namespace FiiSoft\EntityIndexer\EntityMap;

use FiiSoft\EntityIndexer\Entity\IndexableEntity;
use FiiSoft\EntityIndexer\MapStats\EntityMapStats;
use FiiSoft\EntityIndexer\MapStats\EntityMapStatsView;
use FiiSoft\EntityIndexer\MapStats\SingleEntityMapStatsView;
use FiiSoft\Tools\Id\Id;

final class NullEntityMap implements EntityMap
{
    /**
     * @param IndexableEntity $entity
     * @param string|int|null $key if null then will be computed from $entity->id() - must be unique for each entity!
     * @return IndexableEntity returns $entity back
     */
    public function rememberEntity(IndexableEntity $entity, $key = null)
    {
        return $entity;
    }
    
    /**
     * @param Id|array|string|int $key
     * @return IndexableEntity|null
     */
    public function getEntity($key)
    {
        return null;
    }
    
    /**
     * @param array $conditions
     * @return IndexableEntity|null
     */
    public function findOneEntity(array $conditions)
    {
        return null;
    }
    
    /**
     * @param array $conditions
     * @return IndexableEntity[]
     */
    public function findAllEntities(array $conditions)
    {
        return [];
    }
    
    /**
     * @param IndexableEntity $entity
     * @param string|int|null $key if null then will be computed from $entity->id()
     * @return void
     */
    public function forgetEntity(IndexableEntity $entity, $key = null)
    {
    }
    
    /**
     * Forget all entities (remove them from cache).
     * Stats are not affected by this operation.
     *
     * @return void
     */
    public function forgetAll()
    {
    }
    
    /**
     * @return EntityMapStatsView
     */
    public function stats()
    {
        return new SingleEntityMapStatsView(new EntityMapStats());
    }
    
    /**
     * @return int
     */
    public function countEntities()
    {
        return 0;
    }
    
    /**
     * @return void
     */
    public function turnOn()
    {
    }
    
    /**
     * @return void
     */
    public function turnOff()
    {
    }
    
    /**
     * @return bool
     */
    public function isEnabled()
    {
        return false;
    }
}