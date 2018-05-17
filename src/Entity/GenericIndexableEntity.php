<?php

namespace FiiSoft\EntityIndexer\Entity;

use DateTimeInterface;
use FiiSoft\Tools\DateTime\Date;
use FiiSoft\Tools\Id\Id;
use FiiSoft\Tools\Entity\GenericEntity;

class GenericIndexableEntity extends GenericEntity implements IndexableEntity
{
    /**
     * Return true if all data from conditions are equal to appropriate properties of entity.
     *
     * @param array $conditions if empty than result should be true
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function satisfies(array $conditions)
    {
        foreach ($conditions as $prop => $value) {
            if (array_key_exists($prop, $this->properties)
                && $this->areValuesEqual($value, $this->properties[$prop])
            ) {
                continue;
            }
            
            return false;
        }
        
        return true;
    }
    
    /**
     * @param mixed $value1
     * @param mixed $value2
     * @throws \InvalidArgumentException
     * @return bool
     */
    protected function areValuesEqual($value1, $value2)
    {
        if ($value1 instanceof Id) {
            return $value1->equals($value2);
        }
    
        if ($value2 instanceof Id) {
            return $value2->equals($value1);
        }
    
        if ($value1 instanceof DateTimeInterface || $value2 instanceof DateTimeInterface) {
            return Date::areEqual($value1, $value2);
        }
    
        if (is_int($value1) && is_int($value2)) {
            return $value1 === $value2;
        }
        
        if (is_numeric($value1) && is_numeric($value2)) {
            return abs($value1 - $value2) <= 0.000000001;
        }
        
        return $value1 === $value2;
    }
}