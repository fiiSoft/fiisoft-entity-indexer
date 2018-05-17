<?php

namespace FiiSoft\EntityIndexer\Entity;

use FiiSoft\Tools\Entity\Entity;

interface IndexableEntity extends Entity
{
    /**
     * Return true if entity satisfies conditions.
     *
     * @param array $conditions if empty than result should be true
     * @return bool
     */
    public function satisfies(array $conditions);
}