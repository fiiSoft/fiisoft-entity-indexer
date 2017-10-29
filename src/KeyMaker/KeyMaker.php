<?php

namespace FiiSoft\EntityIndexer\KeyMaker;

interface KeyMaker
{
    /**
     * @param mixed $value
     * @return string|int
     */
    public function makeKey($value);
}