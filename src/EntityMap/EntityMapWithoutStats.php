<?php

namespace FiiSoft\EntityIndexer\EntityMap;

use FiiSoft\EntityIndexer\Entity\IndexableEntity;
use FiiSoft\EntityIndexer\KeyMaker\DefaultKeyMaker;
use FiiSoft\EntityIndexer\KeyMaker\KeyMaker;
use FiiSoft\EntityIndexer\MapStats\EntityMapStats;
use FiiSoft\EntityIndexer\MapStats\EntityMapStatsView;
use FiiSoft\EntityIndexer\MapStats\SingleEntityMapStatsView;
use FiiSoft\Tools\Id\Id;
use InvalidArgumentException;
use RuntimeException;

final class EntityMapWithoutStats implements EntityMap
{
    /** @var IndexableEntity[] */
    private $entities = [];
    
    /** @var array */
    private $multipleOne = [];
    
    /** @var array */
    private $multipleTwo = [];
    
    /** @var array */
    private $multipleThree = [];
    
    /** @var array */
    private $multipleFour = [];
    
    /** @var array */
    private $uniqueOne = [];
    
    /** @var array */
    private $uniqueTwo = [];
    
    /** @var array */
    private $uniqueThree = [];
    
    /** @var array */
    private $uniqueFour = [];
    
    /** @var array */
    private $nullIndex = [];
    
    /** @var array */
    private $indexByUniqueOne = [];
    
    /** @var array */
    private $indexByUniqueTwo = [];
    
    /** @var array */
    private $indexByUniqueThree = [];
    
    /** @var array */
    private $indexByUniqueFour = [];
    
    /** @var array */
    private $indexByMultiOne = [];
    
    /** @var array */
    private $indexByMultiTwo = [];
    
    /** @var array */
    private $indexByMultiThree = [];
    
    /** @var array */
    private $indexByMultiFour = [];
    
    /** @var bool */
    private $isTurnOff = false;
    
    /** @var KeyMaker */
    private $keyMaker;

    /** @var string */
    private $name;
    
    /** @var EntityMapStatsView */
    private $statsView;
    
    /** @var string|int */
    private $key;
    
    /** @var IndexableEntity */
    private $entity;
    
    /** @var bool */
    private $isNull = false;
    
    /**
     * @param array $indexBy
     * @param KeyMaker|null $keyMaker
     * @param string|null $name
     * @throws InvalidArgumentException
     */
    public function __construct(array $indexBy = [], KeyMaker $keyMaker = null, $name = null)
    {
        $this->name = (string) $name;
        $this->keyMaker = $keyMaker ?: new DefaultKeyMaker();
        
        $this->setIndexes($indexBy);
    }
    
    /**
     * @param array $indexBy
     * @throws InvalidArgumentException
     * @return void
     */
    private function setIndexes(array $indexBy)
    {
        foreach ($indexBy as $key => $indexes) {
            if (is_string($indexes)) {
                $indexes = [$indexes];
            } elseif (!is_array($indexes)) {
                throw new InvalidArgumentException('Invalid param indexBy - each element must be an array');
            }
            
            if ($key === 'unique') {
                foreach ($indexes as $index) {
                    if (is_string($index)) {
                        $this->indexByUniqueOne[$index] = $index;
                    } elseif (is_array($index)) {
                        $cnt = count($index);
                        
                        if ($cnt === 1) {
                            $index = (string) reset($index);
                            $this->indexByUniqueOne[$index] = $index;
                        } elseif ($cnt === 2) {
                            $this->indexByUniqueTwo[implode(',', $index)] = $index;
                        } elseif ($cnt === 3) {
                            $this->indexByUniqueThree[implode(',', $index)] = $index;
                        } elseif ($cnt === 4) {
                            $this->indexByUniqueFour[implode(',', $index)] = $index;
                        } else {
                            throw new InvalidArgumentException('Invalid param indexBy (when key unique holds an array)');
                        }
                    } else {
                        throw new InvalidArgumentException('Invalid param indexBy (index for key unique)');
                    }
                }
            } elseif ($key === 'multi') {
                foreach ($indexes as $index) {
                    if (is_string($index)) {
                        $this->indexByMultiOne[$index] = $index;
                    } elseif (is_array($index)) {
                        $cnt = count($index);
                        
                        if ($cnt === 1) {
                            $index = (string) reset($index);
                            $this->indexByMultiOne[$index] = $index;
                        } elseif ($cnt === 2) {
                            $this->indexByMultiTwo[implode(',', $index)] = $index;
                        } elseif ($cnt === 3) {
                            $this->indexByMultiThree[implode(',', $index)] = $index;
                        } elseif ($cnt === 4) {
                            $this->indexByMultiFour[implode(',', $index)] = $index;
                        } else {
                            throw new InvalidArgumentException('Invalid param indexBy (when key multi holds an array)');
                        }
                    } else {
                        throw new InvalidArgumentException('Invalid param indexBy (index for key multi)');
                    }
                }
            } else {
                throw new InvalidArgumentException('Invalid param indexBy (invalid key)');
            }
        }
    }
    
    /**
     * @return void
     */
    public function turnOn()
    {
        $this->isTurnOff = false;
    }
    
    /**
     * @return void
     */
    public function turnOff()
    {
        $this->isTurnOff = true;
        
        $this->forgetAll();
    }
    
    /**
     * @return bool
     */
    public function isEnabled()
    {
        return !$this->isTurnOff;
    }
    
    /**
     * Forget all entities (remove them from cache).
     * Stats are not affected by this operation.
     *
     * @return void
     */
    public function forgetAll()
    {
        $this->entities = [];
        $this->uniqueOne = [];
        $this->uniqueTwo = [];
        $this->uniqueThree = [];
        $this->uniqueFour = [];
        $this->multipleOne = [];
        $this->multipleTwo = [];
        $this->multipleThree = [];
        $this->multipleFour = [];
        $this->nullIndex = [];
    }
    
    /**
     * @return EntityMapStatsView
     */
    public function stats()
    {
        if (!$this->statsView) {
            $this->statsView = new SingleEntityMapStatsView(new EntityMapStats());
        }
        
        return $this->statsView;
    }
    
    /**
     * @return int
     */
    public function countEntities()
    {
        return count($this->entities);
    }
    
    /**
     * @param Id|array|string|int $key
     * @return IndexableEntity|null
     */
    public function getEntity($key)
    {
        if ($this->isTurnOff) {
            return null;
        }
        
        if ($key instanceof Id) {
            $key = $this->keyMaker->makeKey($key->value());
        } else {
            $key = $this->keyMaker->makeKey($key);
        }
        
        if (isset($this->entities[$key])) {
            return $this->entities[$key];
        }
        
        return null;
    }
    
    /**
     * @param IndexableEntity $entity
     * @param string|int|null $key if null then will be computed from $entity->id() - must be unique for each entity!
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @return IndexableEntity returns $entity back
     */
    public function rememberEntity(IndexableEntity $entity, $key = null)
    {
        if ($this->isTurnOff) {
            return $entity;
        }
        
        if (null === $key) {
            $key = $entity->id();
            if (null === $key) {
                throw new RuntimeException('Entity has no ID and no param key has been provided');
            }
            $this->key = $this->keyMaker->makeKey($key->value());
        } else {
            $this->key = $this->keyMaker->makeKey($key);
        }
        
        if (isset($this->entities[$this->key]) && $entity !== $this->entities[$this->key]) {
            throw new RuntimeException('Violation of uniqueness (key '.$this->key.') in EntityMap '.$this->name);
        }
        
        $this->entities[$this->key] = $this->entity = $entity;
        
        foreach ($this->indexByUniqueOne as $index => $prop) {
            $value = $entity->get($prop);
            if ($value !== null) {
                $uKey = $this->keyMaker->makeKey($value);
                
                if (isset($this->uniqueOne[$index][$uKey]) && $this->uniqueOne[$index][$uKey] !== $this->key) {
                    throw new RuntimeException(
                        'Violation of uniqueness ('.$index.')=('.$uKey.') in EntityMap '.$this->name
                    );
                }
                
                $this->uniqueOne[$index][$uKey] = $this->key;
            } else {
                $this->nullIndex[$prop][$this->key] = $this->key;
            }
        }
        
        foreach ($this->indexByUniqueTwo as $index => $props) {
            $uKey = $this->makeKeyFromEntity($props);
            if ($uKey !== null) {
                if (isset($this->uniqueTwo[$index][$uKey]) && $this->uniqueTwo[$index][$uKey] !== $this->key) {
                    throw new RuntimeException(
                        'Violation of uniqueness ('.$index.')=('.$uKey.') in EntityMap '.$this->name
                    );
                }
                
                $this->uniqueTwo[$index][$uKey] = $this->key;
            }
        }
        
        foreach ($this->indexByUniqueThree as $index => $props) {
            $uKey = $this->makeKeyFromEntity($props);
            if ($uKey !== null) {
                if (isset($this->uniqueThree[$index][$uKey]) && $this->uniqueThree[$index][$uKey] !== $this->key) {
                    throw new RuntimeException(
                        'Violation of uniqueness ('.$index.')=('.$uKey.') in EntityMap '.$this->name
                    );
                }
                
                $this->uniqueThree[$index][$uKey] = $this->key;
            }
        }
        
        foreach ($this->indexByUniqueFour as $index => $props) {
            $uKey = $this->makeKeyFromEntity($props);
            if ($uKey !== null) {
                if (isset($this->uniqueFour[$index][$uKey]) && $this->uniqueFour[$index][$uKey] !== $this->key) {
                    throw new RuntimeException(
                        'Violation of uniqueness ('.$index.')=('.$uKey.') in EntityMap '.$this->name
                    );
                }
                
                $this->uniqueFour[$index][$uKey] = $this->key;
            }
        }
        
        foreach ($this->indexByMultiOne as $index => $prop) {
            $value = $entity->get($prop);
            if ($value !== null) {
                $this->multipleOne[$index][$this->keyMaker->makeKey($value)][$this->key] = $this->key;
            } else {
                $this->nullIndex[$prop][$this->key] = $this->key;
            }
        }
        
        foreach ($this->indexByMultiTwo as $index => $props) {
            $uKey = $this->makeKeyFromEntity($props);
            if ($uKey !== null) {
                $this->multipleTwo[$index][$uKey][$this->key] = $this->key;
            }
        }
        
        foreach ($this->indexByMultiThree as $index => $props) {
            $uKey = $this->makeKeyFromEntity($props);
            if ($uKey !== null) {
                $this->multipleThree[$index][$uKey][$this->key] = $this->key;
            }
        }
        
        foreach ($this->indexByMultiFour as $index => $props) {
            $uKey = $this->makeKeyFromEntity($props);
            if ($uKey !== null) {
                $this->multipleFour[$index][$uKey][$this->key] = $this->key;
            }
        }

        return $entity;
    }
    
    /**
     * @param array $conditions
     * @return IndexableEntity|null
     */
    public function findOneEntity(array $conditions)
    {
        if ($this->isTurnOff || empty($this->entities)) {
            return null;
        }
        
        if (empty($conditions)) {
            return reset($this->entities);
        }
        
        $candidates = [];
        
        if (!empty($this->uniqueOne)) {
            $isStrict = true;
            
            foreach ($conditions as $index => $value) {
                if ($value === null) {
                    continue;
                }
                
                $key = $this->keyMaker->makeKey($value);
                if (isset($this->uniqueOne[$index][$key])) {
                    $candidates[$this->uniqueOne[$index][$key]] = true;
                } elseif (isset($this->uniqueOne[$index])) {
                    return null;
                } else {
                    $isStrict = false;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    return null;
                }
                
                if ($isStrict) {
                    return $this->entities[key($candidates)];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    return $entity;
                }
                
                return null;
            }
        }
        
        $cnt = count($conditions);
        
        if (!empty($this->uniqueTwo) && $cnt > 1) {
            
            foreach ($this->indexByUniqueTwo as $index => list($p1, $p2)) {
                if (isset($conditions[$p1], $conditions[$p2])) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2]);
                } else {
                    continue;
                }
                
                if (isset($this->uniqueTwo[$index][$key])) {
                    $candidates[$this->uniqueTwo[$index][$key]] = true;
                } else {
                    return null;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    return null;
                }
                
                if ($cnt === 2) {
                    return $this->entities[key($candidates)];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    return $entity;
                }
                
                return null;
            }
        }
        
        if (!empty($this->uniqueThree) && $cnt > 2) {
            
            foreach ($this->indexByUniqueThree as $index => list($p1, $p2, $p3)) {
                if (isset($conditions[$p1], $conditions[$p2], $conditions[$p3])) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2])
                        .','.$this->keyMaker->makeKey($conditions[$p3]);
                } else {
                    continue;
                }
                
                if (isset($this->uniqueThree[$index][$key])) {
                    $candidates[$this->uniqueThree[$index][$key]] = true;
                } else {
                    return null;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    return null;
                }
                
                if ($cnt === 3) {
                    return $this->entities[key($candidates)];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    return $entity;
                }
                
                return null;
            }
        }
        
        if (!empty($this->uniqueFour) && $cnt > 3) {
            
            foreach ($this->indexByUniqueFour as $index => list($p1, $p2, $p3, $p4)) {
                if (isset($conditions[$p1], $conditions[$p2], $conditions[$p3], $conditions[$p4])) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2])
                        .','.$this->keyMaker->makeKey($conditions[$p3])
                        .','.$this->keyMaker->makeKey($conditions[$p4]);
                } else {
                    continue;
                }
                
                if (isset($this->uniqueFour[$index][$key])) {
                    $candidates[$this->uniqueFour[$index][$key]] = true;
                } else {
                    return null;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    return null;
                }
                
                if ($cnt === 4) {
                    return $this->entities[key($candidates)];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    return $entity;
                }
                
                return null;
            }
        }
        
        $case = min(4, $cnt);
        $isStrict = false;
        $checkIsStrict = true;
        
        switch ($case) {
            case 4:
                if (!empty($this->multipleFour)) {
                    
                    foreach ($this->indexByMultiFour as $index => list($p1, $p2, $p3, $p4)) {
                        if (isset($conditions[$p1], $conditions[$p2], $conditions[$p3], $conditions[$p4])) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2])
                                .','.$this->keyMaker->makeKey($conditions[$p3])
                                .','.$this->keyMaker->makeKey($conditions[$p4]);
                        } else {
                            continue;
                        }
                        
                        if (isset($this->multipleFour[$index][$key])) {
                            $candidates[] = $this->multipleFour[$index][$key];
                        } else {
                            return null;
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 4;
                            $checkIsStrict = false;
                        }
                    }
                }
            case 3:
                if (!empty($this->multipleThree)) {
                    
                    foreach ($this->indexByMultiThree as $index => list($p1, $p2, $p3)) {
                        if (isset($conditions[$p1], $conditions[$p2], $conditions[$p3])) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2])
                                .','.$this->keyMaker->makeKey($conditions[$p3]);
                        } else {
                            continue;
                        }
                        
                        if (isset($this->multipleThree[$index][$key])) {
                            $candidates[] = $this->multipleThree[$index][$key];
                        } else {
                            return null;
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 3;
                            $checkIsStrict = false;
                        }
                    }
                }
            case 2:
                if (!empty($this->multipleTwo)) {
                    
                    foreach ($this->indexByMultiTwo as $index => list($p1, $p2)) {
                        if (isset($conditions[$p1], $conditions[$p2])) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2]);
                        } else {
                            continue;
                        }
                        
                        if (isset($this->multipleTwo[$index][$key])) {
                            $candidates[] = $this->multipleTwo[$index][$key];
                        } else {
                            return null;
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 2;
                            $checkIsStrict = false;
                        }
                    }
                }
            case 1:
                if (!empty($this->multipleOne)) {
                    
                    foreach ($this->indexByMultiOne as $index) {
                        if (isset($conditions[$index])) {
                            $key = $this->keyMaker->makeKey($conditions[$index]);
                        } else {
                            continue;
                        }
                        
                        if (isset($this->multipleOne[$index][$key])) {
                            $candidates[] = $this->multipleOne[$index][$key];
                        } else {
                            return null;
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 1;
                        }
                    }
                }
        }
    
        if (empty($candidates)) {
            $indexes = [];
            
            foreach ($conditions as $index => $value) {
                if ($value === null && !empty($this->nullIndex[$index])) {
                    $indexes[] = $index;
                }
            }
    
            if (empty($indexes)) {
                foreach ($this->entities as $entity) {
                    if ($entity->satisfies($conditions)) {
                        return $entity;
                    }
                }
                
                return null;
            }
            
            if (count($indexes) === 1) {
                $winners = $this->nullIndex[$indexes[0]];
                $isStrict = $cnt === 1;
            } else {
                $winners = array_intersect(...array_map(function ($index) {
                    return $this->nullIndex[$index];
                }, $indexes));
    
                if (empty($winners)) {
                    return null;
                }
    
                $isStrict = $cnt === count($indexes);
            }
            
        } elseif (count($candidates) === 1) {
            $winners = $candidates[0];
        } else {
            $winners = array_intersect(...$candidates);
            if (empty($winners)) {
                return null;
            }
        }
        
        if ($isStrict) {
            return $this->entities[current($winners)];
        }
        
        /* @var $entity IndexableEntity */
        foreach ($winners as $key) {
            $entity = $this->entities[$key];
            if ($entity->satisfies($conditions)) {
                return $entity;
            }
        }
        
        return null;
    }
    
    /**
     * @param array $conditions
     * @return IndexableEntity[]
     */
    public function findAllEntities(array $conditions)
    {
        if ($this->isTurnOff || empty($this->entities)) {
            return [];
        }
        
        if (empty($conditions)) {
            return $this->entities;
        }
        
        $candidates = [];
        
        if (!empty($this->uniqueOne)) {
            $isStrict = true;
            
            foreach ($conditions as $index => $value) {
                if ($value === null) {
                    continue;
                }
                
                $key = $this->keyMaker->makeKey($value);
                if (isset($this->uniqueOne[$index][$key])) {
                    $candidates[$this->uniqueOne[$index][$key]] = true;
                } elseif (isset($this->uniqueOne[$index])) {
                    return [];
                } else {
                    $isStrict = false;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    return [];
                }
                
                if ($isStrict) {
                    return [$this->entities[key($candidates)]];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    return [$entity];
                }
                
                return [];
            }
        }
        
        $cnt = count($conditions);
        
        if (!empty($this->uniqueTwo) && $cnt > 1) {
            
            foreach ($this->indexByUniqueTwo as $index => list($p1, $p2)) {
                if (isset($conditions[$p1], $conditions[$p2])) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2]);
                } else {
                    continue;
                }
                
                if (isset($this->uniqueTwo[$index][$key])) {
                    $candidates[$this->uniqueTwo[$index][$key]] = true;
                } else {
                    return [];
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    return [];
                }
                
                if ($cnt === 2) {
                    return [$this->entities[key($candidates)]];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    return [$entity];
                }
                
                return [];
            }
        }
        
        if (!empty($this->uniqueThree) && $cnt > 2) {
            
            foreach ($this->indexByUniqueThree as $index => list($p1, $p2, $p3)) {
                if (isset($conditions[$p1], $conditions[$p2], $conditions[$p3])) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2])
                        .','.$this->keyMaker->makeKey($conditions[$p3]);
                } else {
                    continue;
                }
                
                if (isset($this->uniqueThree[$index][$key])) {
                    $candidates[$this->uniqueThree[$index][$key]] = true;
                } else {
                    return [];
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    return [];
                }
                
                if ($cnt === 3) {
                    return [$this->entities[key($candidates)]];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    return [$entity];
                }
                
                return [];
            }
        }
        
        if (!empty($this->uniqueFour) && $cnt > 3) {
            
            foreach ($this->indexByUniqueFour as $index => list($p1, $p2, $p3, $p4)) {
                if (isset($conditions[$p1], $conditions[$p2], $conditions[$p3], $conditions[$p4])) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2])
                        .','.$this->keyMaker->makeKey($conditions[$p3])
                        .','.$this->keyMaker->makeKey($conditions[$p4]);
                } else {
                    continue;
                }
                
                if (isset($this->uniqueFour[$index][$key])) {
                    $candidates[$this->uniqueFour[$index][$key]] = true;
                } else {
                    return [];
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    return [];
                }
                
                if ($cnt === 4) {
                    return [$this->entities[key($candidates)]];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    return [$entity];
                }
                
                return [];
            }
        }
        
        $case = min(4, $cnt);
        $isStrict = false;
        $checkIsStrict = true;
        
        switch ($case) {
            case 4:
                if (!empty($this->multipleFour)) {
                    
                    foreach ($this->indexByMultiFour as $index => list($p1, $p2, $p3, $p4)) {
                        if (isset($conditions[$p1], $conditions[$p2], $conditions[$p3], $conditions[$p4])) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2])
                                .','.$this->keyMaker->makeKey($conditions[$p3])
                                .','.$this->keyMaker->makeKey($conditions[$p4]);
                        } else {
                            continue;
                        }
                        
                        if (isset($this->multipleFour[$index][$key])) {
                            $candidates[] = $this->multipleFour[$index][$key];
                        } else {
                            return [];
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 4;
                            $checkIsStrict = false;
                        }
                    }
                }
            case 3:
                if (!empty($this->multipleThree)) {
                    
                    foreach ($this->indexByMultiThree as $index => list($p1, $p2, $p3)) {
                        if (isset($conditions[$p1], $conditions[$p2], $conditions[$p3])) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2])
                                .','.$this->keyMaker->makeKey($conditions[$p3]);
                        } else {
                            continue;
                        }
                        
                        if (isset($this->multipleThree[$index][$key])) {
                            $candidates[] = $this->multipleThree[$index][$key];
                        } else {
                            return [];
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 3;
                            $checkIsStrict = false;
                        }
                    }
                }
            case 2:
                if (!empty($this->multipleTwo)) {
                    
                    foreach ($this->indexByMultiTwo as $index => list($p1, $p2)) {
                        if (isset($conditions[$p1], $conditions[$p2])) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2]);
                        } else {
                            continue;
                        }
                        
                        if (isset($this->multipleTwo[$index][$key])) {
                            $candidates[] = $this->multipleTwo[$index][$key];
                        } else {
                            return [];
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 2;
                            $checkIsStrict = false;
                        }
                    }
                }
            case 1:
                if (!empty($this->multipleOne)) {
                    
                    foreach ($this->indexByMultiOne as $index) {
                        if (isset($conditions[$index])) {
                            $key = $this->keyMaker->makeKey($conditions[$index]);
                        } else {
                            continue;
                        }
                        
                        if (isset($this->multipleOne[$index][$key])) {
                            $candidates[] = $this->multipleOne[$index][$key];
                        } else {
                            return [];
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 1;
                        }
                    }
                }
        }
    
        if (empty($candidates)) {
            $indexes = [];
        
            foreach ($conditions as $index => $value) {
                if ($value === null && !empty($this->nullIndex[$index])) {
                    $indexes[] = $index;
                }
            }
        
            if (empty($indexes)) {
                $entities = [];
                foreach ($this->entities as $entity) {
                    if ($entity->satisfies($conditions)) {
                        $entities[] = $entity;
                    }
                }
                
                return $entities;
            }
        
            if (count($indexes) === 1) {
                $winners = $this->nullIndex[$indexes[0]];
                $isStrict = $cnt === 1;
            } else {
                $winners = array_intersect(...array_map(function ($index) {
                    return $this->nullIndex[$index];
                }, $indexes));
                
                if (empty($winners)) {
                    return [];
                }
    
                $isStrict = $cnt === count($indexes);
            }
        
        } elseif (count($candidates) === 1) {
            $winners = $candidates[0];
        } else {
            $winners = array_intersect(...$candidates);
            if (empty($winners)) {
                return [];
            }
        }
        
        $entities = [];
        
        if ($isStrict) {
            foreach ($winners as $key) {
                $entities[] = $this->entities[$key];
            }
        } else {
            foreach ($winners as $key) {
                $entity = $this->entities[$key];
                if ($entity->satisfies($conditions)) {
                    $entities[] = $entity;
                }
            }
        }
        
        return $entities;
    }
    
    /**
     * @param IndexableEntity $entity
     * @param string|int|null $key if null then will be computed from $entity->id()
     * @throws \InvalidArgumentException
     * @return void
     */
    public function forgetEntity(IndexableEntity $entity, $key = null)
    {
        if ($this->isTurnOff) {
            return;
        }
        
        if (null === $key) {
            $key = $entity->id();
            if (null === $key) {
                return;
            }
            $this->key = $this->keyMaker->makeKey($key->value());
        } else {
            $this->key = $this->keyMaker->makeKey($key);
        }
        
        $this->entity = $entity;
        
        if (isset($this->entities[$this->key])) {
            unset($this->entities[$this->key]);
        }
        
        //TODO searching indexes to remove should be done with help of key, not actual properties of entity
        
        foreach ($this->indexByUniqueOne as $index => $prop) {
            $value = $entity->get($prop);
            if ($value !== null) {
                unset($this->uniqueOne[$index][$this->keyMaker->makeKey($value)]);
            } else {
                unset($this->nullIndex[$prop][$this->key]);
            }
        }
        
        foreach ($this->indexByUniqueTwo as $index => $props) {
            $mKey = $this->makeKeyFromEntity($props, true);
            if ($mKey !== null) {
                unset($this->uniqueTwo[$index][$mKey]);
            }
        }
        
        foreach ($this->indexByUniqueThree as $index => $props) {
            $mKey = $this->makeKeyFromEntity($props, true);
            if ($mKey !== null) {
                unset($this->uniqueThree[$index][$mKey]);
            }
        }
        
        foreach ($this->indexByUniqueFour as $index => $props) {
            $mKey = $this->makeKeyFromEntity($props, true);
            if ($mKey !== null) {
                unset($this->uniqueFour[$index][$mKey]);
            }
        }
        
        foreach ($this->indexByMultiOne as $index => $prop) {
            $value = $entity->get($prop);
            if ($value !== null) {
                $mKey = $this->keyMaker->makeKey($value);
                foreach ($this->multipleOne[$index][$mKey] as $i => $iKey) {
                    if ($iKey === $this->key) {
                        unset($this->multipleOne[$index][$mKey][$i]);
                        break;
                    }
                }
            } else {
                unset($this->nullIndex[$prop][$this->key]);
            }
        }
        
        foreach ($this->indexByMultiTwo as $index => $props) {
            $mKey = $this->makeKeyFromEntity($props, true);
            if ($mKey !== null) {
                foreach ($this->multipleTwo[$index][$mKey] as $i => $iKey) {
                    if ($iKey === $this->key) {
                        unset($this->multipleTwo[$index][$mKey][$i]);
                        break;
                    }
                }
            }
        }
        
        foreach ($this->indexByMultiThree as $index => $props) {
            $mKey = $this->makeKeyFromEntity($props, true);
            if ($mKey !== null) {
                foreach ($this->multipleThree[$index][$mKey] as $i => $iKey) {
                    if ($iKey === $this->key) {
                        unset($this->multipleThree[$index][$mKey][$i]);
                        break;
                    }
                }
            }
        }
        
        foreach ($this->indexByMultiFour as $index => $props) {
            $mKey = $this->makeKeyFromEntity($props, true);
            if ($mKey !== null) {
                foreach ($this->multipleFour[$index][$mKey] as $i => $iKey) {
                    if ($iKey === $this->key) {
                        unset($this->multipleFour[$index][$mKey][$i]);
                        break;
                    }
                }
            }
        }
    }
    
    /**
     * @param array $props
     * @param bool $remove
     * @return string|null
     */
    private function makeKeyFromEntity(array $props, $remove = false)
    {
        $pieces = [];
        $this->isNull = false;
    
        foreach ($props as $prop) {
            $value = $this->entity->get($prop);
            
            if ($value === null) {
                $this->isNull = true;
                if ($remove) {
                    unset($this->nullIndex[$prop][$this->key]);
                } else {
                    $this->nullIndex[$prop][$this->key] = $this->key;
                }
            }
    
            if (!$this->isNull) {
                $pieces[] = $this->keyMaker->makeKey($value);
            }
        }
    
        return $this->isNull ? null : implode(',', $pieces);
    }
}