<?php

namespace FiiSoft\EntityIndexer\MapStats;

abstract class BaseEntityMapStatsView implements EntityMapStatsView
{
    /** @var array */
    private static $keys = [];
    
    /**
     * @throws \ReflectionException
     * @return array array with all stats as keys and counts as values
     */
    public function toArray()
    {
        if (empty(self::$keys)) {
            $refl = new \ReflectionClass(EntityMapStatsView::class);
            foreach ($refl->getMethods() as $method) {
                $name = $method->getShortName();
                if ($name !== 'clear' && $name !== 'toArray') {
                    self::$keys[] = $name;
                }
            }
        }
        
        $stats = [];
        foreach (self::$keys as $key) {
            $stats[$key] = $this->$key();
        }
        
        return $stats;
    }
}