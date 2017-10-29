<?php

namespace FiiSoft\EntityIndexer\Entity;

use FiiSoft\Tools\Id\Id;

interface Entity
{
    /**
     * Get ID of entity (or null if has no ID).
     *
     * @return Id|null
     */
    public function id();
    
    /**
     * Get value of given property of entity.
     *
     * @param string $property
     * @throws \InvalidArgumentException if entity has no such property
     * @return mixed value of property
     */
    public function get($property);
}