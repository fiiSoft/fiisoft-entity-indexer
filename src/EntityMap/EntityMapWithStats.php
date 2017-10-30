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

final class EntityMapWithStats implements EntityMap
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
    
    /** @var EntityMapStats */
    private $stats;
    
    /** @var EntityMapStatsView */
    private $statsView;
    
    /**
     * @param array $indexBy
     * @param KeyMaker|null $keyMaker
     * @param EntityMapStats|null $stats
     * @param string|null $name
     * @throws InvalidArgumentException
     */
    public function __construct(
        array $indexBy = [],
        KeyMaker $keyMaker = null,
        EntityMapStats $stats = null,
        $name = null
    ){
        $this->name = (string) $name;
        $this->stats = $stats ?: new EntityMapStats();
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
    }
    
    /**
     * @return EntityMapStatsView
     */
    public function stats()
    {
        if (!$this->statsView) {
            $this->statsView = new SingleEntityMapStatsView($this->stats);
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
            $this->stats->foundByKey($key);
            return $this->entities[$key];
        }
        
        $this->stats->notFoundByKey($key);
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
            $key = $this->keyMaker->makeKey($key->value());
        } else {
            $key = $this->keyMaker->makeKey($key);
        }
        
        if (isset($this->entities[$key]) && $entity !== $this->entities[$key]) {
            throw new RuntimeException('Violation of uniqueness (key '.$key.') in EntityMap '.$this->name);
        }
        
        $this->entities[$key] = $entity;
        
        foreach ($this->indexByUniqueOne as $index => $prop) {
            $uKey = $this->keyMaker->makeKey($entity->get($prop));
            
            if (isset($this->uniqueOne[$index][$uKey]) && $this->uniqueOne[$index][$uKey] !== $key) {
                throw new RuntimeException(
                    'Violation of uniqueness ('.$index.')=('.$uKey.') in EntityMap '.$this->name
                );
            }
            
            $this->uniqueOne[$index][$uKey] = $key;
        }
        
        foreach ($this->indexByUniqueTwo as $index => $props) {
            $uKey = $this->makeKeyFromEntity($entity, $props);
            
            if (isset($this->uniqueTwo[$index][$uKey]) && $this->uniqueTwo[$index][$uKey] !== $key) {
                throw new RuntimeException(
                    'Violation of uniqueness ('.$index.')=('.$uKey.') in EntityMap '.$this->name
                );
            }
            
            $this->uniqueTwo[$index][$uKey] = $key;
        }
        
        foreach ($this->indexByUniqueThree as $index => $props) {
            $uKey = $this->makeKeyFromEntity($entity, $props);
            
            if (isset($this->uniqueThree[$index][$uKey]) && $this->uniqueThree[$index][$uKey] !== $key) {
                throw new RuntimeException(
                    'Violation of uniqueness ('.$index.')=('.$uKey.') in EntityMap '.$this->name
                );
            }
            
            $this->uniqueThree[$index][$uKey] = $key;
        }
        
        foreach ($this->indexByUniqueFour as $index => $props) {
            $uKey = $this->makeKeyFromEntity($entity, $props);
            
            if (isset($this->uniqueFour[$index][$uKey]) && $this->uniqueFour[$index][$uKey] !== $key) {
                throw new RuntimeException(
                    'Violation of uniqueness ('.$index.')=('.$uKey.') in EntityMap '.$this->name
                );
            }
            
            $this->uniqueFour[$index][$uKey] = $key;
        }
        
        foreach ($this->indexByMultiOne as $index => $prop) {
            $this->multipleOne[$index][$this->keyMaker->makeKey($entity->get($prop))][] = $key;
        }
        
        foreach ($this->indexByMultiTwo as $index => $props) {
            $this->multipleTwo[$index][$this->makeKeyFromEntity($entity, $props)][] = $key;
        }
        
        foreach ($this->indexByMultiThree as $index => $props) {
            $this->multipleThree[$index][$this->makeKeyFromEntity($entity, $props)][] = $key;
        }
        
        foreach ($this->indexByMultiFour as $index => $props) {
            $this->multipleFour[$index][$this->makeKeyFromEntity($entity, $props)][] = $key;
        }

        return $entity;
    }
    
    /**
     * @param array $conditions
     * @return IndexableEntity|null
     */
    public function findOneEntity(array $conditions)
    {
        if ($this->isTurnOff) {
            return null;
        }
        
        if (empty($this->entities)) {
            $this->stats->findOneFailed();
            return null;
        }
        
        if (empty($conditions)) {
            return reset($this->entities);
        }
        
        $candidates = [];
        
        if (!empty($this->uniqueOne)) {
            $this->stats->searchInUniqueOne();
            $isStrict = true;
            
            foreach ($conditions as $index => $value) {
                $key = $this->keyMaker->makeKey($value);
                if (isset($this->uniqueOne[$index][$key])) {
                    $candidates[$this->uniqueOne[$index][$key]] = true;
                } elseif (isset($this->uniqueOne[$index])) {
                    $this->stats->impossibleToMatchForUniqueOne();
                    return null;
                } else {
                    $isStrict = false;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    $this->stats->ambiguousFoundInUniqueOne();
                    return null;
                }
                
                if ($isStrict) {
                    $this->stats->strictFoundOneInUniqueOne();
                    return $this->entities[key($candidates)];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    $this->stats->candidateOfUniqueOneMatches();
                    return $entity;
                }
                
                $this->stats->candidateOfUniqueOneDoesNotMatch();
                return null;
            }
            
            $this->stats->notFoundInUniqueOne();
        }
        
        $cnt = count($conditions);
        
        if (!empty($this->uniqueTwo) && $cnt > 1) {
            $this->stats->searchInUniqueTwo();
            
            foreach ($this->indexByUniqueTwo as $index => list($p1, $p2)) {
                if (array_key_exists($p1, $conditions) && array_key_exists($p2, $conditions)) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2]);
                } else {
                    $this->stats->conditionsNotCompleteForUniqueTwo();
                    continue;
                }
                
                if (isset($this->uniqueTwo[$index][$key])) {
                    $candidates[$this->uniqueTwo[$index][$key]] = true;
                } else {
                    $this->stats->missedFindOneUniqueTwo();
                    return null;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    $this->stats->ambiguousFoundInUniqueTwo();
                    return null;
                }
                
                if ($cnt === 2) {
                    $this->stats->strictFoundOneInUniqueTwo();
                    return $this->entities[key($candidates)];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    $this->stats->candidateOfUniqueTwoMatches();
                    return $entity;
                }
                
                $this->stats->candidateOfUniqueTwoDoesNotMatch();
                return null;
            }
        }
        
        if (!empty($this->uniqueThree) && $cnt > 2) {
            $this->stats->searchInUniqueThree();
            
            foreach ($this->indexByUniqueThree as $index => list($p1, $p2, $p3)) {
                if (array_key_exists($p1, $conditions)
                    && array_key_exists($p2, $conditions)
                    && array_key_exists($p3, $conditions)
                ) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2])
                        .','.$this->keyMaker->makeKey($conditions[$p3]);
                } else {
                    $this->stats->conditionsNotCompleteForUniqueThree();
                    continue;
                }
                
                if (isset($this->uniqueThree[$index][$key])) {
                    $candidates[$this->uniqueThree[$index][$key]] = true;
                } else {
                    $this->stats->missedFindOneUniqueThree();
                    return null;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    $this->stats->ambiguousFoundInUniqueThree();
                    return null;
                }
                
                if ($cnt === 3) {
                    $this->stats->strictFoundOneInUniqueThree();
                    return $this->entities[key($candidates)];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    $this->stats->candidateOfUniqueThreeMatches();
                    return $entity;
                }
                
                $this->stats->candidateOfUniqueThreeDoesNotMatch();
                return null;
            }
        }
        
        if (!empty($this->uniqueFour) && $cnt > 3) {
            $this->stats->searchInUniqueFour();
            
            foreach ($this->indexByUniqueFour as $index => list($p1, $p2, $p3, $p4)) {
                if (array_key_exists($p1, $conditions)
                    && array_key_exists($p2, $conditions)
                    && array_key_exists($p3, $conditions)
                    && array_key_exists($p4, $conditions)
                ) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2])
                        .','.$this->keyMaker->makeKey($conditions[$p3])
                        .','.$this->keyMaker->makeKey($conditions[$p4]);
                } else {
                    $this->stats->conditionsNotCompleteForUniqueFour();
                    continue;
                }
                
                if (isset($this->uniqueFour[$index][$key])) {
                    $candidates[$this->uniqueFour[$index][$key]] = true;
                } else {
                    $this->stats->missedFindOneUniqueFour();
                    return null;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    $this->stats->ambiguousFoundInUniqueFour();
                    return null;
                }
                
                if ($cnt === 4) {
                    $this->stats->strictFoundOneInUniqueFour();
                    return $this->entities[key($candidates)];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    $this->stats->candidateOfUniqueFourMatches();
                    return $entity;
                }
                
                $this->stats->candidateOfUniqueFourDoesNotMatch();
                return null;
            }
        }
        
        $case = min(4, $cnt);
        $isStrict = false;
        $checkIsStrict = true;
        
        switch ($case) {
            case 4:
                if (!empty($this->multipleFour)) {
                    $this->stats->searchInMultipleFour();
                    
                    foreach ($this->indexByMultiFour as $index => list($p1, $p2, $p3, $p4)) {
                        if (array_key_exists($p1, $conditions)
                            && array_key_exists($p2, $conditions)
                            && array_key_exists($p3, $conditions)
                            && array_key_exists($p4, $conditions)
                        ) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2])
                                .','.$this->keyMaker->makeKey($conditions[$p3])
                                .','.$this->keyMaker->makeKey($conditions[$p4]);
                        } else {
                            $this->stats->conditionsNotCompleteForMultipleFour();
                            continue;
                        }
                        
                        if (isset($this->multipleFour[$index][$key])) {
                            $candidates[] = $this->multipleFour[$index][$key];
                        } else {
                            $this->stats->impossibleToMatchForMultipleFour();
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
                    $this->stats->searchInMultipleThree();
                    
                    foreach ($this->indexByMultiThree as $index => list($p1, $p2, $p3)) {
                        if (array_key_exists($p1, $conditions)
                            && array_key_exists($p2, $conditions)
                            && array_key_exists($p3, $conditions)
                        ) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2])
                                .','.$this->keyMaker->makeKey($conditions[$p3]);
                        } else {
                            $this->stats->conditionsNotCompleteForMultipleThree();
                            continue;
                        }
                        
                        if (isset($this->multipleThree[$index][$key])) {
                            $candidates[] = $this->multipleThree[$index][$key];
                        } else {
                            $this->stats->impossibleToMatchForMultipleThree();
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
                    $this->stats->searchInMultipleTwo();
                    
                    foreach ($this->indexByMultiTwo as $index => list($p1, $p2)) {
                        if (array_key_exists($p1, $conditions) && array_key_exists($p2, $conditions)) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2]);
                        } else {
                            $this->stats->conditionsNotCompleteForMultipleTwo();
                            continue;
                        }
                        
                        if (isset($this->multipleTwo[$index][$key])) {
                            $candidates[] = $this->multipleTwo[$index][$key];
                        } else {
                            $this->stats->impossibleToMatchForMultipleTwo();
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
                    $this->stats->searchInMultipleOne();
                    
                    foreach ($this->indexByMultiOne as $index) {
                        if (array_key_exists($index, $conditions)) {
                            $key = $this->keyMaker->makeKey($conditions[$index]);
                        } else {
                            $this->stats->conditionsNotCompleteForMultipleOne();
                            continue;
                        }
                        
                        if (isset($this->multipleOne[$index][$key])) {
                            $candidates[] = $this->multipleOne[$index][$key];
                        } else {
                            $this->stats->impossibleToMatchForMultipleOne();
                            return null;
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 1;
                        }
                    }
                }
        }
        
        if (empty($candidates)) {
            foreach ($this->entities as $entity) {
                if ($entity->satisfies($conditions)) {
                    $this->stats->foundOneInCollection();
                    return $entity;
                }
            }
            
            $this->stats->notFoundOneInCollection();
            return null;
        }
        
        if (count($candidates) === 1) {
            $winners = $candidates[0];
        } else {
            $winners = array_intersect(...$candidates);
        }
        
        if (empty($winners)) {
            $this->stats->noWinnersFromMultipleCandidatesInFindOne();
            return null;
        }
        
        if ($isStrict) {
            $this->stats->winnerStrictFromMultipleCandidatesInFindOne();
            return $this->entities[current($winners)];
        }
        
        /* @var $entity IndexableEntity */
        foreach ($winners as $key) {
            $entity = $this->entities[$key];
            if ($entity->satisfies($conditions)) {
                $this->stats->winnerFromMultipleCandidatesSatisfiesConditionsInFindOne();
                return $entity;
            }
        }
        
        $this->stats->winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne();
        return null;
    }
    
    /**
     * @param array $conditions
     * @return IndexableEntity[]
     */
    public function findAllEntities(array $conditions)
    {
        if ($this->isTurnOff) {
            return [];
        }
        
        if (empty($this->entities)) {
            $this->stats->findAllFailed();
            return [];
        }
        
        if (empty($conditions)) {
            return $this->entities;
        }
        
        $candidates = [];
        
        if (!empty($this->uniqueOne)) {
            $this->stats->searchAllInUniqueOne();
            $isStrict = true;
            
            foreach ($conditions as $index => $value) {
                $key = $this->keyMaker->makeKey($value);
                if (isset($this->uniqueOne[$index][$key])) {
                    $candidates[$this->uniqueOne[$index][$key]] = true;
                } elseif (isset($this->uniqueOne[$index])) {
                    $this->stats->impossibleToMatchForAllInUniqueOne();
                    return [];
                } else {
                    $isStrict = false;
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    $this->stats->ambiguousFoundForAllInUniqueOne();
                    return [];
                }
                
                if ($isStrict) {
                    $this->stats->strictFoundAllInUniqueOne();
                    return [$this->entities[key($candidates)]];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    $this->stats->candidateForAllOfUniqueOneMatches();
                    return [$entity];
                }
                
                $this->stats->candidateForAllOfUniqueOneDoesNotMatch();
                return [];
            }
            
            $this->stats->notFoundAllInUniqueOne();
        }
        
        $cnt = count($conditions);
        
        if (!empty($this->uniqueTwo) && $cnt > 1) {
            $this->stats->searchAllInUniqueTwo();
            
            foreach ($this->indexByUniqueTwo as $index => list($p1, $p2)) {
                if (array_key_exists($p1, $conditions) && array_key_exists($p2, $conditions)) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2]);
                } else {
                    $this->stats->conditionsForAllNotCompleteInUniqueTwo();
                    continue;
                }
                
                if (isset($this->uniqueTwo[$index][$key])) {
                    $candidates[$this->uniqueTwo[$index][$key]] = true;
                } else {
                    $this->stats->missedFindAllUniqueTwo();
                    return [];
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    $this->stats->ambiguousFoundForAllInUniqueTwo();
                    return [];
                }
                
                if ($cnt === 2) {
                    $this->stats->strictFoundAllInUniqueTwo();
                    return [$this->entities[key($candidates)]];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    $this->stats->candidateForAllOfUniqueTwoMatches();
                    return [$entity];
                }
                
                $this->stats->candidateForAllOfUniqueTwoDoesNotMatch();
                return [];
            }
        }
        
        if (!empty($this->uniqueThree) && $cnt > 2) {
            $this->stats->searchAllInUniqueThree();
            
            foreach ($this->indexByUniqueThree as $index => list($p1, $p2, $p3)) {
                if (array_key_exists($p1, $conditions)
                    && array_key_exists($p2, $conditions)
                    && array_key_exists($p3, $conditions)
                ) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2])
                        .','.$this->keyMaker->makeKey($conditions[$p3]);
                } else {
                    $this->stats->conditionsForAllNotCompleteInUniqueThree();
                    continue;
                }
                
                if (isset($this->uniqueThree[$index][$key])) {
                    $candidates[$this->uniqueThree[$index][$key]] = true;
                } else {
                    $this->stats->missedFindAllUniqueThree();
                    return [];
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    $this->stats->ambiguousFoundForAllInUniqueThree();
                    return [];
                }
                
                if ($cnt === 3) {
                    $this->stats->strictFoundAllInUniqueThree();
                    return [$this->entities[key($candidates)]];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    $this->stats->candidateForAllOfUniqueThreeMatches();
                    return [$entity];
                }
                
                $this->stats->candidateForAllOfUniqueThreeDoesNotMatch();
                return [];
            }
        }
        
        if (!empty($this->uniqueFour) && $cnt > 3) {
            $this->stats->searchAllInUniqueFour();
            
            foreach ($this->indexByUniqueFour as $index => list($p1, $p2, $p3, $p4)) {
                if (array_key_exists($p1, $conditions)
                    && array_key_exists($p2, $conditions)
                    && array_key_exists($p3, $conditions)
                    && array_key_exists($p4, $conditions)
                ) {
                    $key = $this->keyMaker->makeKey($conditions[$p1])
                        .','.$this->keyMaker->makeKey($conditions[$p2])
                        .','.$this->keyMaker->makeKey($conditions[$p3])
                        .','.$this->keyMaker->makeKey($conditions[$p4]);
                } else {
                    $this->stats->conditionsForAllNotCompleteInUniqueFour();
                    continue;
                }
                
                if (isset($this->uniqueFour[$index][$key])) {
                    $candidates[$this->uniqueFour[$index][$key]] = true;
                } else {
                    $this->stats->missedFindAllUniqueFour();
                    return [];
                }
            }
            
            if (!empty($candidates)) {
                if (count($candidates) > 1) {
                    $this->stats->ambiguousFoundForAllInUniqueFour();
                    return [];
                }
                
                if ($cnt === 4) {
                    $this->stats->strictFoundAllInUniqueFour();
                    return [$this->entities[key($candidates)]];
                }
                
                $entity = $this->entities[key($candidates)];
                if ($entity->satisfies($conditions)) {
                    $this->stats->candidateForAllOfUniqueFourMatches();
                    return [$entity];
                }
                
                $this->stats->candidateForAllOfUniqueFourDoesNotMatch();
                return [];
            }
        }
        
        $case = min(4, $cnt);
        $isStrict = false;
        $checkIsStrict = true;
        
        switch ($case) {
            case 4:
                if (!empty($this->multipleFour)) {
                    $this->stats->searchAllInMultipleFour();
                    
                    foreach ($this->indexByMultiFour as $index => list($p1, $p2, $p3, $p4)) {
                        if (array_key_exists($p1, $conditions)
                            && array_key_exists($p2, $conditions)
                            && array_key_exists($p3, $conditions)
                            && array_key_exists($p4, $conditions)
                        ) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2])
                                .','.$this->keyMaker->makeKey($conditions[$p3])
                                .','.$this->keyMaker->makeKey($conditions[$p4]);
                        } else {
                            $this->stats->conditionsForAllNotCompleteInMultipleFour();
                            continue;
                        }
                        
                        if (isset($this->multipleFour[$index][$key])) {
                            $candidates[] = $this->multipleFour[$index][$key];
                        } else {
                            $this->stats->impossibleToMatchForAllInMultipleFour();
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
                    $this->stats->searchAllInMultipleThree();
                    
                    foreach ($this->indexByMultiThree as $index => list($p1, $p2, $p3)) {
                        if (array_key_exists($p1, $conditions)
                            && array_key_exists($p2, $conditions)
                            && array_key_exists($p3, $conditions)
                        ) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2])
                                .','.$this->keyMaker->makeKey($conditions[$p3]);
                        } else {
                            $this->stats->conditionsForAllNotCompleteInMultipleThree();
                            continue;
                        }
                        
                        if (isset($this->multipleThree[$index][$key])) {
                            $candidates[] = $this->multipleThree[$index][$key];
                        } else {
                            $this->stats->impossibleToMatchForAllInMultipleThree();
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
                    $this->stats->searchAllInMultipleTwo();
                    
                    foreach ($this->indexByMultiTwo as $index => list($p1, $p2)) {
                        if (array_key_exists($p1, $conditions) && array_key_exists($p2, $conditions)) {
                            $key = $this->keyMaker->makeKey($conditions[$p1])
                                .','.$this->keyMaker->makeKey($conditions[$p2]);
                        } else {
                            $this->stats->conditionsForAllNotCompleteInMultipleTwo();
                            continue;
                        }
                        
                        if (isset($this->multipleTwo[$index][$key])) {
                            $candidates[] = $this->multipleTwo[$index][$key];
                        } else {
                            $this->stats->impossibleToMatchForAllInMultipleTwo();
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
                    $this->stats->searchAllInMultipleOne();
                    
                    foreach ($this->indexByMultiOne as $index) {
                        if (array_key_exists($index, $conditions)) {
                            $key = $this->keyMaker->makeKey($conditions[$index]);
                        } else {
                            $this->stats->conditionsForAllNotCompleteInMultipleOne();
                            continue;
                        }
                        
                        if (isset($this->multipleOne[$index][$key])) {
                            $candidates[] = $this->multipleOne[$index][$key];
                        } else {
                            $this->stats->impossibleToMatchForAllInMultipleOne();
                            return [];
                        }
                        
                        if ($checkIsStrict) {
                            $isStrict = $cnt === 1;
                        }
                    }
                }
        }
        
        if (empty($candidates)) {
            $entities = [];
            foreach ($this->entities as $entity) {
                if ($entity->satisfies($conditions)) {
                    $entities[] = $entity;
                }
            }
            
            if (empty($entities)) {
                $this->stats->notFoundAnyInCollection();
                return [];
            }
            
            $this->stats->foundSomeInCollection();
            return $entities;
        }
        
        if (count($candidates) === 1) {
            $winners = $candidates[0];
        } else {
            $winners = array_intersect(...$candidates);
        }
        
        if (empty($winners)) {
            $this->stats->noWinnersFromMultipleCandidatesInFindAll();
            return [];
        }
        
        if ($isStrict) {
            $this->stats->winnerStrictFromMultipleCandidatesInFindAll();
            $entities = [];
            foreach ($winners as $key) {
                $entities[] = $this->entities[$key];
            }
            
            return $entities;
        }
        
        $entities = [];
        foreach ($winners as $key) {
            $entity = $this->entities[$key];
            if ($entity->satisfies($conditions)) {
                $entities[] = $entity;
            }
        }
        
        if (empty($entities)) {
            $this->stats->noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll();
            return [];
        }
        
        $this->stats->someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll();
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
            $key = $this->keyMaker->makeKey($key->value());
        } else {
            $key = $this->keyMaker->makeKey($key);
        }
        
        if (isset($this->entities[$key])) {
            unset($this->entities[$key]);
        }
        
        foreach ($this->indexByUniqueOne as $index => $prop) {
            unset($this->uniqueOne[$index][$this->keyMaker->makeKey($entity->get($prop))]);
        }
        
        foreach ($this->indexByUniqueTwo as $index => $props) {
            unset($this->uniqueTwo[$index][$this->makeKeyFromEntity($entity, $props)]);
        }
        
        foreach ($this->indexByUniqueThree as $index => $props) {
            unset($this->uniqueThree[$index][$this->makeKeyFromEntity($entity, $props)]);
        }
        
        foreach ($this->indexByUniqueFour as $index => $props) {
            unset($this->uniqueFour[$index][$this->makeKeyFromEntity($entity, $props)]);
        }
        
        foreach ($this->indexByMultiOne as $index => $prop) {
            $mKey = $this->keyMaker->makeKey($entity->get($prop));
            foreach ($this->multipleOne[$index][$mKey] as $i => $iKey) {
                if ($iKey === $key) {
                    unset($this->multipleOne[$index][$mKey][$i]);
                    break;
                }
            }
        }
        
        foreach ($this->indexByMultiTwo as $index => $props) {
            $mKey = $this->makeKeyFromEntity($entity, $props);
            foreach ($this->multipleTwo[$index][$mKey] as $i => $iKey) {
                if ($iKey === $key) {
                    unset($this->multipleTwo[$index][$mKey][$i]);
                    break;
                }
            }
        }
        
        foreach ($this->indexByMultiThree as $index => $props) {
            $mKey = $this->makeKeyFromEntity($entity, $props);
            foreach ($this->multipleThree[$index][$mKey] as $i => $iKey) {
                if ($iKey === $key) {
                    unset($this->multipleThree[$index][$mKey][$i]);
                    break;
                }
            }
        }
        
        foreach ($this->indexByMultiFour as $index => $props) {
            $mKey = $this->makeKeyFromEntity($entity, $props);
            foreach ($this->multipleFour[$index][$mKey] as $i => $iKey) {
                if ($iKey === $i) {
                    unset($this->multipleFour[$index][$mKey][$i]);
                    break;
                }
            }
        }
    }
    
    /**
     * @param IndexableEntity $entity
     * @param array $props
     * @throws \InvalidArgumentException
     * @return string
     */
    private function makeKeyFromEntity(IndexableEntity $entity, array $props)
    {
        return implode(',', array_map(function ($prop) use ($entity) {
            return $this->keyMaker->makeKey($entity->get($prop));
        }, $props));
    }
}