<?php

namespace FiiSoft\EntityIndexer\Entity;

use FiiSoft\Tools\Id\Id;
use InvalidArgumentException;

class GenericEntity implements Entity
{
    /** @var Id */
    protected $id;
    
    /** @var array */
    protected $properties = [];
    
    /**
     * @param Id|null $id
     * @param array $properties
     */
    public function __construct(Id $id = null, array $properties = [])
    {
        $this->id = $id;
        $this->properties = $properties;
    }
    
    /**
     * @return Id|null
     */
    public function id()
    {
        return $this->id;
    }
    
    /**
     * @param string $property
     * @throws InvalidArgumentException
     * @return mixed
     */
    public function get($property)
    {
        if (array_key_exists($property, $this->properties)) {
            return $this->properties[$property];
        }
        
        throw new InvalidArgumentException('Entity '.get_class($this).' has no property "'.$property.'"');
    }
}