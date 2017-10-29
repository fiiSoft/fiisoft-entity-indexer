<?php

namespace FiiSoft\EntityIndexer\KeyMaker;

use Closure;
use DateTimeInterface;
use FiiSoft\Tools\Id\Id;
use Traversable;

class DefaultKeyMaker implements KeyMaker
{
    /** @var Closure[] */
    private $converters = [];
    
    /**
     * @param Closure[] $converters
     */
    public function __construct(array $converters = [])
    {
        if (!empty($converters)) {
            $this->setConverters($converters);
        }
    }
    
    /**
     * @param Closure[] $converters
     * @return void
     */
    public function setConverters(array $converters)
    {
        $this->converters = [];
    
        foreach ($converters as $converter) {
            $this->addConverter($converter);
        }
    }
    
    /**
     * Custom converter must return true or false and gets two params: the first is value to be converted to key,
     * and the second is container for created key - this param must be marked as passed by reference!
     *
     * @param Closure $converter
     * @return void
     */
    public function addConverter(Closure $converter)
    {
        $this->converters[] = $converter;
    }
    
    /**
     * @param mixed $value
     * @return string|int
     */
    public function makeKey($value)
    {
        if (is_int($value)) {
            return $value;
        }
    
        if (is_float($value)) {
            return '_'.$value;
        }
        
        if (is_string($value)) {
            if (ctype_digit($value)) {
                return '_'.$value;
            }
            
            return $value;
        }
    
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        
        if ($value instanceof Id) {
            return $this->makeKey($value->value());
        }
    
        if ($value instanceof DateTimeInterface) {
            return $value->format('YmdHisT');
        }
    
        if (is_array($value)) {
            return implode(',', array_map(function ($item) {
                return $this->makeKey($item);
            }, $value));
        }
    
        if ($value instanceof Traversable) {
            return implode(',', array_map(function ($item) {
                return $this->makeKey($item);
            }, iterator_to_array($value)));
        }
    
        if (null === $value) {
            return '__null__';
        }
    
        if (!empty($this->converters)) {
            $custom = null;
            foreach ($this->converters as $converter) {
                if ($converter($value, $custom)) {
                    return $custom;
                }
            }
        }
        
        return (string) $value;
    }
}