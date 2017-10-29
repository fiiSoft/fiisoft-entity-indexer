<?php

namespace FiiSoft\EntityIndexer\EntityMap;

use FiiSoft\EntityIndexer\Entity\IndexableEntity;
use FiiSoft\EntityIndexer\MapStats\EntityMapStatsView;
use FiiSoft\Tools\Id\Id;

interface EntityMap
{
    /**
     * @param IndexableEntity $entity
     * @param string|int|null $key if null then will be computed from $entity->id() - must be unique for each entity!
     * @return IndexableEntity returns $entity back
     */
    public function rememberEntity(IndexableEntity $entity, $key = null);
    
    /**
     * @param Id|array|string|int $key
     * @return IndexableEntity|null
     */
    public function getEntity($key);
    
    /**
     * @param array $conditions
     * @return IndexableEntity|null
     */
    public function findOneEntity(array $conditions);
    
    /**
     * @param array $conditions
     * @return IndexableEntity[]
     */
    public function findAllEntities(array $conditions);
    
    /**
     * @param IndexableEntity $entity
     * @param string|int|null $key if null then will be computed from $entity->id()
     * @return void
     */
    public function forgetEntity(IndexableEntity $entity, $key = null);
    
    /**
     * Forget all entities (remove them from cache).
     * Stats are not affected by this operation.
     *
     * @return void
     */
    public function forgetAll();
    
    /**
     * @return EntityMapStatsView
     */
    public function stats();
    
    /**
     * @return int
     */
    public function countEntities();
    
    /**
     * @return void
     */
    public function turnOn();
    
    /**
     * @return void
     */
    public function turnOff();
    
    /**
     * @return bool
     */
    public function isEnabled();
}