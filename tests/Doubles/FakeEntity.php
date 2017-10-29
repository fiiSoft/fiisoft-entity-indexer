<?php

namespace FiiSoft\Test\EntityIndexer\Doubles;

use DateTimeInterface;
use FiiSoft\EntityIndexer\Entity\GenericIndexableEntity;
use FiiSoft\Tools\Id\Id;

final class FakeEntity extends GenericIndexableEntity
{
    public function __toString()
    {
        $data = [];
    
        foreach ($this->properties as $prop => $value) {
            $data[] = $prop.':'.$this->convertToScalar($value);
        }
        
        return implode('|', $data);
    }
    
    /**
     * @param mixed $value
     * @return string
     */
    private function convertToScalar($value)
    {
        if ($value instanceof Id) {
            return $value->asString();
        }
        
        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d H:i:s T');
        }
        
        if (is_array($value)) {
            return implode(',', $value);
        }
        
        return (string) $value;
    }
}