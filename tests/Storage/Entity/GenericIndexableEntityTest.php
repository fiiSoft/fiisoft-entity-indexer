<?php

namespace FiiSoft\Test\EntityIndexer\Entity;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use FiiSoft\EntityIndexer\Entity\GenericIndexableEntity;
use FiiSoft\Test\EntityIndexer\Doubles\FakeIntegerId;

class GenericIndexableEntityTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_has_no_id_if_not_set()
    {
        $entity = new GenericIndexableEntity();
        
        self::assertNull($entity->id());
    }
    
    public function test_it_returns_id_if_set()
    {
        $id = new FakeIntegerId(15);
        $entity = new GenericIndexableEntity($id);
        
        self::assertSame($id, $entity->id());
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_throws_exception_when_try_to_get_property_which_does_not_have()
    {
        $entity = new GenericIndexableEntity();
        $entity->get('not-existing');
    }
    
    public function test_it_is_always_equal_to_empty_conditions()
    {
        $entity = new GenericIndexableEntity();
        self::assertTrue($entity->satisfies([]));
    }
    
    public function test_it_can_return_property_value()
    {
        $date = new DateTime();
        
        $entity = new GenericIndexableEntity(null, [
            'first' => 'foo',
            'second' => 8,
            'third' => $date,
        ]);
        
        self::assertSame('foo', $entity->get('first'));
        self::assertSame(8, $entity->get('second'));
        self::assertSame($date, $entity->get('third'));
    }
    
    public function test_it_can_tell_if_has_properties_equal_to_parameters()
    {
        $date = new DateTimeImmutable();
    
        $entity = new GenericIndexableEntity(null, [
            'first' => 'foo',
            'second' => 8,
            'third' => $date,
        ]);
        
        $set1 = [
            'other' => 4,
            'first' => 'foo',
        ];
        self::assertFalse($entity->satisfies($set1));
        
        $set2 = [
            'first' => 'foo',
        ];
        self::assertTrue($entity->satisfies($set2));
        
        $set3 = [
            'second' => 8,
            'third' => clone $date,
        ];
        self::assertTrue($entity->satisfies($set3));
        
        $set4 = [
            'first' => 'foo',
            'second' => 8,
            'third' => $date->add(new DateInterval('PT1S')),
        ];
        self::assertFalse($entity->satisfies($set4));
    }
}
