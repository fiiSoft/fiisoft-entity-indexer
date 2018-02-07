<?php

namespace FiiSoft\Test\EntityIndexer\EntityMap;

use FiiSoft\EntityIndexer\EntityMap\EntityMapWithStats;
use FiiSoft\EntityIndexer\KeyMaker\DefaultKeyMaker;
use FiiSoft\EntityIndexer\MapStats\EntityMapStatsView;
use FiiSoft\Test\EntityIndexer\Doubles\FakeEntity;
use FiiSoft\Test\EntityIndexer\Doubles\FakeIntegerId;

class EntityMapWithStatsTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_is_enabled_by_default_and_can_be_turn_off_and_turn_on()
    {
        $map = new EntityMapWithStats();
        self::assertTrue($map->isEnabled());
        
        $map->turnOff();
        self::assertFalse($map->isEnabled());
        
        $map->turnOn();
        self::assertTrue($map->isEnabled());
    }
    
    public function test_it_can_retrieve_statistics()
    {
        $map = new EntityMapWithStats();
        
        $stats = $map->stats();
        self::assertInstanceOf(EntityMapStatsView::class, $stats);
        self::assertSame($stats, $map->stats()); //each call of method stats() gets the same object
        
        //all initial statistics are equal zero
        self::assertSame(0, $stats->foundByKeyTotal());
        self::assertSame(0, $stats->notFoundByKeyTotal());
        self::assertSame(0, $stats->findOneFailed());
    }
    
    public function test_it_has_no_entities_after_create()
    {
        $map = new EntityMapWithStats();
        self::assertSame(0, $map->countEntities());
    }
    
    public function test_it_can_remember_entity_with_substituted_key()
    {
        //given
        $map = new EntityMapWithStats();
        $entity = new FakeEntity();
    
        self::assertNull($map->getEntity('fakeKey'));
        
        //when
        self::assertSame($entity, $map->rememberEntity($entity, 'fakeKey'));
        //then
        self::assertSame($entity, $map->getEntity('fakeKey'));
        self::assertSame(1, $map->countEntities());
        
        //when
        $map->forgetEntity($entity, 'fakeKey');
        //then
        self::assertNull($map->getEntity('fakeKey'));
        self::assertSame(0, $map->countEntities());
    }
    
    public function test_it_cen_remember_entity_with_its_own_id()
    {
        //given
        $map = new EntityMapWithStats();
        
        $id = new FakeIntegerId();
        $entity = new FakeEntity($id);
        
        $keyMaker = new DefaultKeyMaker();
        $key = $keyMaker->makeKey($id->value());
    
        self::assertNull($map->getEntity($key));
        
        //when
        self::assertSame($entity, $map->rememberEntity($entity));
        //then
        self::assertSame($entity, $map->getEntity($key));
        self::assertSame(1, $map->countEntities());
    
        //when
        $map->forgetEntity($entity);
        //then
        self::assertNull($map->getEntity($key));
        self::assertSame(0, $map->countEntities());
    }
    
    public function test_add_the_same_entity_more_then_once_is_allowed()
    {
        //given
        $map = new EntityMapWithStats(['unique' => 'name']);
        $entity = new FakeEntity(new FakeIntegerId(), ['name' => 'ela']);
        $keyMaker = new DefaultKeyMaker();
        
        //when
        $map->rememberEntity($entity);
        $map->rememberEntity($entity);
        
        //then
        self::assertSame(1, $map->countEntities());
        self::assertSame($entity, $map->getEntity($keyMaker->makeKey($entity->id())));
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function test_add_different_entities_with_the_same_id_is_prohibited()
    {
        $map = new EntityMapWithStats();
        $id = new FakeIntegerId();
    
        $map->rememberEntity(new FakeEntity($id));
        $map->rememberEntity(new FakeEntity($id));
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function test_add_different_entities_with_the_same_uniqe_property_is_prohibited()
    {
        $map = new EntityMapWithStats(['unique' => 'age']);
    
        $map->rememberEntity(new FakeEntity(new FakeIntegerId(1), ['age' => 13]));
        $map->rememberEntity(new FakeEntity(new FakeIntegerId(2), ['age' => 13]));
    }
    
    public function test_it_can_count_hits_and_misses_by_key()
    {
        //given
        $map = new EntityMapWithStats();
        $stats = $map->stats();
        $entity = new FakeEntity();
        
        //when
        self::assertNull($map->getEntity('fakeKey'));
        //then
        $expected['notFoundByKeyTotal'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entity, $map->rememberEntity($entity, 'fakeKey'));
        self::assertSame($entity, $map->getEntity('fakeKey'));
        //then
        $expected['foundByKeyTotal'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        $map->forgetEntity($entity, 'fakeKey');
        self::assertNull($map->getEntity('fakeKey'));
        //then
        $expected['notFoundByKeyTotal'] += 1; //2
        $this->checkStats($stats, $expected);
    }
    
    public function test_entity_can_by_indexed_by_single_unique_value()
    {
        //given
        $map = new EntityMapWithStats([
            'unique' => [
                'name' //index entities by name
            ],
        ]);
    
        $stats = $map->stats();
        $entity = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 15]);
    
        //when
        self::assertNull($map->findOneEntity(['name' => 'ala']));
        self::assertNull($map->findOneEntity(['name' => 'ola']));
        self::assertNull($map->findOneEntity(['age' => 13]));
        self::assertNull($map->findOneEntity(['age' => 15]));
        //then
        $expected['findOneFailed'] = 4;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entity, $map->rememberEntity($entity));
        //then
        self::assertSame(1, $map->countEntities());
        
        //when
        self::assertSame($entity, $map->findOneEntity(['name' => 'ala']));
        //then
        $expected['findOneSucceeded'] = 1;
        $expected['searchInUniqueOne'] = 1;
        $expected['strictFoundOneInUniqueOne'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['name' => 'ola']));
        //then
        $expected['searchInUniqueOne'] += 1; //2
        $expected['findOneFailed'] += 1; //5
        $expected['impossibleToMatchForUniqueOne'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entity, $map->findOneEntity(['name' => 'ala', 'age' => 15]));
        self::assertSame($entity, $map->findOneEntity(['age' => 15]));
        //then
        $expected['findOneSucceeded'] += 2; //3
        $expected['searchInUniqueOne'] += 2; //4
        $expected['notFoundInUniqueOne'] = 1;
        $expected['candidateOfUniqueOneMatches'] = 1;
        $expected['foundOneInCollection'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['age' => 13]));
        self::assertNull($map->findOneEntity(['name' => 'ula']));
        self::assertNull($map->findOneEntity(['name' => 'ala', 'age' => 13]));
        //then
        $expected['findOneFailed'] += 3; //8
        $expected['searchInUniqueOne'] += 3; //7
        $expected['notFoundInUniqueOne'] += 1; //2
        $expected['impossibleToMatchForUniqueOne'] += 1; //2
        $expected['candidateOfUniqueOneDoesNotMatch'] = 1;
        $expected['notFoundOneInCollection'] = 1;
        $this->checkStats($stats, $expected);
    }
    
    public function test_entity_can_be_indexed_by_more_then_one_uniqe_values()
    {
        //given
        $map = new EntityMapWithStats([
            'unique' => [
                'name', 'age' //index entities by two separated indexes
            ],
        ]);
    
        $stats = $map->stats();
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 15]);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17]);
    
        //when
        self::assertNull($map->findOneEntity(['name' => 'ala']));
        self::assertNull($map->findOneEntity(['name' => 'ola']));
        self::assertNull($map->findOneEntity(['age' => 15]));
        self::assertNull($map->findOneEntity(['age' => 17]));
        //then
        $expected['findOneFailed'] = 4;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entityOne, $map->rememberEntity($entityOne));
        self::assertSame($entityTwo, $map->rememberEntity($entityTwo));
        //then
        self::assertSame(2, $map->countEntities());
        
        //when
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala']));
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala', 'age' => 15]));
        self::assertSame($entityOne, $map->findOneEntity(['age' => 15]));
        //then
        $expected['findOneSucceeded'] = 3;
        $expected['searchInUniqueOne'] = 3;
        $expected['strictFoundOneInUniqueOne'] = 3;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entityTwo, $map->findOneEntity(['name' => 'ola']));
        self::assertSame($entityTwo, $map->findOneEntity(['name' => 'ola', 'age' => 17]));
        self::assertSame($entityTwo, $map->findOneEntity(['age' => 17]));
        //then
        $expected['findOneSucceeded'] += 3; //6
        $expected['searchInUniqueOne'] += 3; //6
        $expected['strictFoundOneInUniqueOne'] += 3; //6
        $this->checkStats($stats, $expected);
    
        //when
        self::assertNull($map->findOneEntity(['age' => 13]));
        self::assertNull($map->findOneEntity(['name' => 'ula']));
        self::assertNull($map->findOneEntity(['name' => 'ala', 'age' => 13]));
        self::assertNull($map->findOneEntity(['name' => 'ula', 'age' => 15]));
        //then
        $expected['findOneFailed'] += 4; //8
        $expected['searchInUniqueOne'] += 4; //10
        $expected['impossibleToMatchForUniqueOne'] = 4;
        $this->checkStats($stats, $expected);
    }
    
    public function test_entity_can_be_indexed_by_two_element_index()
    {
        //given
        $map = new EntityMapWithStats([
            'unique' => [
                ['name', 'age'] //index entities with single index based on two properties
            ],
        ]);
    
        $stats = $map->stats();
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 15, 'symbol' => 'x']);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17, 'symbol' => 'y']);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 15, 'symbol' => 'z']);
    
        //when
        self::assertNull($map->findOneEntity(['name' => 'ala']));
        self::assertNull($map->findOneEntity(['name' => 'ola']));
        self::assertNull($map->findOneEntity(['age' => 15]));
        self::assertNull($map->findOneEntity(['age' => 17]));
        //then
        $expected['findOneFailed'] = 4;
        $this->checkStats($stats, $expected);
    
        //when
        self::assertSame($entityOne, $map->rememberEntity($entityOne));
        self::assertSame($entityTwo, $map->rememberEntity($entityTwo));
        self::assertSame($entityThree, $map->rememberEntity($entityThree));
        //then
        self::assertSame(3, $map->countEntities());
        
        //when
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala']));
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala', 'age' => 15]));
        self::assertSame($entityOne, $map->findOneEntity(['symbol' => 'x']));
        self::assertSame($entityOne, $map->findOneEntity(['age' => 15]));
        //then
        $expected['findOneSucceeded'] = 4;
        $expected['searchInUniqueTwo'] = 1;
        $expected['foundOneInCollection'] = 3;
        $expected['strictFoundOneInUniqueTwo'] = 1;
        $this->checkStats($stats, $expected);

        //when
        self::assertSame($entityTwo, $map->findOneEntity(['name' => 'ola']));
        self::assertSame($entityTwo, $map->findOneEntity(['name' => 'ola', 'age' => 17]));
        self::assertSame($entityTwo, $map->findOneEntity(['symbol' => 'y']));
        self::assertSame($entityTwo, $map->findOneEntity(['age' => 17]));
        //then
        $expected['findOneSucceeded'] += 4; //8
        $expected['searchInUniqueTwo'] += 1; //2
        $expected['foundOneInCollection'] += 3; //6
        $expected['strictFoundOneInUniqueTwo'] += 1; //2
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entityThree, $map->findOneEntity(['name' => 'ola', 'symbol' => 'z']));
        self::assertSame($entityThree, $map->findOneEntity(['name' => 'ola', 'age' => 15]));
        self::assertSame($entityThree, $map->findOneEntity(['symbol' => 'z']));
        //then
        $expected['findOneSucceeded'] += 3; //11
        $expected['searchInUniqueTwo'] += 2; //4
        $expected['foundOneInCollection'] += 2; //8
        $expected['strictFoundOneInUniqueTwo'] += 1; //3
        $expected['conditionsNotCompleteForUniqueTwo'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['age' => 13]));
        self::assertNull($map->findOneEntity(['name' => 'ula']));
        self::assertNull($map->findOneEntity(['name' => 'ala', 'age' => 13]));
        self::assertNull($map->findOneEntity(['name' => 'ula', 'age' => 15]));
        self::assertNull($map->findOneEntity(['name' => 'ala', 'symbol' => 'z']));
        //then
        $expected['findOneFailed'] += 5; //9
        $expected['searchInUniqueTwo'] += 3; //7
        $expected['conditionsNotCompleteForUniqueTwo'] += 1; //2
        $expected['notFoundOneInCollection'] = 3;
        $expected['missedFindOneUniqueTwo'] = 2;
        $this->checkStats($stats, $expected);
    }
    
    public function test_entity_can_be_indexed_by_three_element_index()
    {
        //given
        $map = new EntityMapWithStats([
            'unique' => [
                ['name', 'age', 'symbol'] //index entities with single index based on three properties
            ],
        ]);
    
        $stats = $map->stats();
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 15, 'symbol' => 'x']);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17, 'symbol' => 'y']);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 15, 'symbol' => 'z']);
    
        //when
        self::assertNull($map->findOneEntity(['name' => 'ala']));
        self::assertNull($map->findOneEntity(['age' => 15]));
        self::assertNull($map->findOneEntity(['symbol' => 'z']));
        //then
        $expected['findOneFailed'] = 3;
        $this->checkStats($stats, $expected);
    
        //when
        self::assertSame($entityOne, $map->rememberEntity($entityOne));
        self::assertSame($entityTwo, $map->rememberEntity($entityTwo));
        self::assertSame($entityThree, $map->rememberEntity($entityThree));
        //then
        self::assertSame(3, $map->countEntities());
        
        //when
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala']));
        self::assertSame($entityOne, $map->findOneEntity(['age' => 15]));
        self::assertSame($entityOne, $map->findOneEntity(['symbol' => 'x']));
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala', 'age' => 15]));
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala', 'symbol' => 'x']));
        self::assertSame($entityOne, $map->findOneEntity(['age' => 15, 'symbol' => 'x']));
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala', 'age' => 15, 'symbol' => 'x']));
        //then
        $expected['findOneFailed'] = 3;
        $expected['findOneSucceeded'] = 7;
        $expected['searchInUniqueThree'] = 1;
        $expected['foundOneInCollection'] = 6;
        $expected['strictFoundOneInUniqueThree'] = 1;
        $this->checkStats($stats, $expected);

        //when
        self::assertSame($entityTwo, $map->findOneEntity(['name' => 'ola']));
        self::assertSame($entityTwo, $map->findOneEntity(['name' => 'ola', 'age' => 17]));
        self::assertSame($entityTwo, $map->findOneEntity(['symbol' => 'y']));
        self::assertSame($entityTwo, $map->findOneEntity(['age' => 17]));
        self::assertSame($entityTwo, $map->findOneEntity(['name' => 'ola', 'age' => 17, 'symbol' => 'y']));
        //then
        $expected['findOneSucceeded'] += 5; //12
        $expected['searchInUniqueThree'] += 1;
        $expected['foundOneInCollection'] += 4;
        $expected['strictFoundOneInUniqueThree'] += 1;
        $this->checkStats($stats, $expected);

        //when
        self::assertSame($entityThree, $map->findOneEntity(['name' => 'ola', 'age' => 15, 'symbol' => 'z']));
        self::assertSame($entityThree, $map->findOneEntity(['name' => 'ola', 'symbol' => 'z']));
        self::assertSame($entityThree, $map->findOneEntity(['name' => 'ola', 'age' => 15]));
        self::assertSame($entityThree, $map->findOneEntity(['symbol' => 'z']));
        //then
        $expected['findOneSucceeded'] += 4; //16
        $expected['searchInUniqueThree'] += 1; //3
        $expected['foundOneInCollection'] += 3; //13
        $expected['strictFoundOneInUniqueThree'] += 1; //3
        $this->checkStats($stats, $expected);

        //when
        self::assertNull($map->findOneEntity(['name' => 'ala', 'age' => 17, 'symbol' => 'x']));
        self::assertNull($map->findOneEntity(['name' => 'ala', 'age' => 17, 'sex' => 'F']));
        //then
        $expected['findOneFailed'] += 2; //5
        $expected['searchInUniqueThree'] += 2; //5
        $expected['notFoundOneInCollection'] = 1;
        $expected['missedFindOneUniqueThree'] = 1;
        $expected['conditionsNotCompleteForUniqueThree'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['age' => 13]));
        self::assertNull($map->findOneEntity(['name' => 'ula']));
        self::assertNull($map->findOneEntity(['name' => 'ala', 'age' => 13]));
        self::assertNull($map->findOneEntity(['name' => 'ula', 'age' => 15]));
        self::assertNull($map->findOneEntity(['name' => 'ala', 'symbol' => 'z']));
        //then
        $expected['findOneFailed'] += 5; //10
        $expected['notFoundOneInCollection'] += 5; //6
        $this->checkStats($stats, $expected);
        
        //given
        $entityFour = new FakeEntity(new FakeIntegerId(), ['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'F']);
        self::assertSame($entityFour, $map->rememberEntity($entityFour));
        //when
        self::assertSame($entityFour, $map->findOneEntity(['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'F']));
        //then
        $expected['findOneSucceeded'] += 1; //17
        $expected['searchInUniqueThree'] += 1; //6
        $expected['candidateOfUniqueThreeMatches'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'M']));
        //then
        $expected['findOneFailed'] += 1; //11
        $expected['searchInUniqueThree'] += 1; //7
        $expected['candidateOfUniqueThreeDoesNotMatch'] = 1;
        $this->checkStats($stats, $expected);
    }
    
    public function test_entity_can_be_indexed_by_four_element_index()
    {
        //given
        $map = new EntityMapWithStats([
            'unique' => [
                ['name', 'age', 'symbol', 'sex'] //index entities with single index based on four properties
            ],
        ]);
    
        $stats = $map->stats();
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 16, 'symbol' => 'x', 'sex' => 'f']);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17, 'symbol' => 'y', 'sex' => 'f']);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        $entityFour = new FakeEntity(new FakeIntegerId(), ['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
    
        //when
        self::assertNull($map->findOneEntity(['name' => 'ala']));
        self::assertNull($map->findOneEntity(['age' => 15]));
        self::assertNull($map->findOneEntity(['symbol' => 'z']));
        self::assertNull($map->findOneEntity(['sex' => 'f']));
        //then
        $expected['findOneFailed'] = 4;
        $this->checkStats($stats, $expected);
    
        //when
        self::assertSame($entityOne, $map->rememberEntity($entityOne));
        self::assertSame($entityTwo, $map->rememberEntity($entityTwo));
        self::assertSame($entityThree, $map->rememberEntity($entityThree));
        self::assertSame($entityFour, $map->rememberEntity($entityFour));
        //then
        self::assertSame(4, $map->countEntities());
        
        //when
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala']));
        self::assertSame($entityTwo, $map->findOneEntity(['name' => 'ola', 'age' => 17]));
        self::assertSame($entityThree, $map->findOneEntity(['name' => 'ola', 'age' => 15, 'symbol' => 'z']));
        self::assertSame($entityFour, $map->findOneEntity(['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']));
        //then
        $expected['findOneSucceeded'] = 4;
        $expected['searchInUniqueFour'] = 1;
        $expected['foundOneInCollection'] = 3;
        $expected['strictFoundOneInUniqueFour'] = 1;
        $this->checkStats($stats, $expected);

        //when
        self::assertNull($map->findOneEntity(['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'm']));
        //then
        $expected['searchInUniqueFour'] += 1;
        $expected['strictFoundOneInUniqueFour'] = 1;
        $expected['findOneFailed'] = 5;
        $expected['missedFindOneUniqueFour'] = 1;
        $this->checkStats($stats, $expected);
    }
    
    public function test_entity_can_be_indexed_with_nonunique_one_value_index()
    {
        //given
        $map = new EntityMapWithStats([
            'multi' => [
                'name'
            ],
        ]);
    
        $stats = $map->stats();
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 16, 'symbol' => 'x', 'sex' => 'f']);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17, 'symbol' => 'y', 'sex' => 'f']);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        $entityFour = new FakeEntity(new FakeIntegerId(), ['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        
        //when
        self::assertNull($map->findOneEntity(['name' => 'ala']));
        //then
        $expected = ['findOneFailed' => 1];
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entityOne, $map->rememberEntity($entityOne));
        self::assertSame($entityTwo, $map->rememberEntity($entityTwo));
        self::assertSame($entityThree, $map->rememberEntity($entityThree));
        self::assertSame($entityFour, $map->rememberEntity($entityFour));
        //then
        self::assertSame(4, $map->countEntities());
        
        //when
        $keyMaker = new DefaultKeyMaker();
        $key = $keyMaker->makeKey($entityOne->id());
        self::assertSame($entityOne, $map->getEntity($key));
        //then
        $expected['foundByKeyTotal'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['lang' => 'pl']));
        //then
        $expected['findOneFailed'] += 1;
        $expected['searchInMultipleOne'] = 1;
        $expected['conditionsNotCompleteForMultipleOne'] = 1;
        $expected['notFoundOneInCollection'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['name' => 'ula']));
        //then
        $expected['findOneFailed'] += 1;
        $expected['searchInMultipleOne'] += 1;
        $expected['impossibleToMatchForMultipleOne'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entityOne, $map->findOneEntity(['name' => 'ala']));
        //then
        $expected['findOneSucceeded'] = 1;
        $expected['searchInMultipleOne'] += 1;
        $expected['winnerStrictFromMultipleCandidatesInFindOne'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entityTwo, $map->findOneEntity(['name' => 'ola']));
        //then
        $expected['findOneSucceeded'] += 1;
        $expected['searchInMultipleOne'] += 1;
        $expected['winnerStrictFromMultipleCandidatesInFindOne'] += 1;
        $this->checkStats($stats, $expected);
    
        //when
        self::assertSame($entityThree, $map->findOneEntity(['name' => 'ola', 'age' => 15]));
        //then
        $expected['findOneSucceeded'] += 1;
        $expected['searchInMultipleOne'] += 1;
        $expected['winnerFromMultipleCandidatesSatisfiesConditionsInFindOne'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['name' => 'ola', 'age' => 13]));
        //then
        $expected['findOneFailed'] += 1;
        $expected['searchInMultipleOne'] += 1;
        $expected['winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne'] = 1;
        $this->checkStats($stats, $expected);
    }
    
    public function test_entity_can_be_indexed_by_different_indexes_at_once()
    {
        //given
        $map = new EntityMapWithStats([
            'multi' => [
                //three indexes: first by name, second by age nad symbol, third by sex
                'name', ['age', 'symbol'], 'sex'
            ],
        ]);
    
        $stats = $map->stats();
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 16, 'symbol' => 'x', 'sex' => 'f']);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17, 'symbol' => 'y', 'sex' => 'f']);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        $entityFour = new FakeEntity(new FakeIntegerId(), ['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
    
        self::assertSame($entityOne, $map->rememberEntity($entityOne));
        self::assertSame($entityTwo, $map->rememberEntity($entityTwo));
        self::assertSame($entityThree, $map->rememberEntity($entityThree));
        self::assertSame($entityFour, $map->rememberEntity($entityFour));
        
        //when
        self::assertSame($entityThree, $map->findOneEntity(['name' => 'ola', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']));
        //then
        $expected['findOneSucceeded'] = 1;
        $expected['searchInMultipleOne'] = 1;
        $expected['searchInMultipleTwo'] = 1;
        $expected['winnerFromMultipleCandidatesSatisfiesConditionsInFindOne'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['name' => 'ala', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']));
        //then
        $expected['findOneFailed'] = 1;
        $expected['searchInMultipleTwo'] += 1; //2
        $expected['searchInMultipleOne'] += 1; //2
        $expected['noWinnersFromMultipleCandidatesInFindOne'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame($entityTwo, $map->findOneEntity(['age' => 17, 'symbol' => 'y']));
        //then
        $expected['findOneSucceeded'] += 1; //2
        $expected['searchInMultipleTwo'] += 1; //3
        $expected['searchInMultipleOne'] += 1; //3
        $expected['conditionsNotCompleteForMultipleOne'] = 2;
        $expected['winnerStrictFromMultipleCandidatesInFindOne'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertNull($map->findOneEntity(['name' => 'ula', 'age' => 17, 'symbol' => 'y']));
        //then
        $expected['searchInMultipleTwo'] += 1; //4
        $expected['searchInMultipleOne'] += 1; //4
        $expected['impossibleToMatchForMultipleOne'] = 1;
        $expected['findOneFailed'] += 1; //2
        $this->checkStats($stats, $expected);
    }
    
    public function test_many_entities_can_be_found_by_uniqe_one_index()
    {
        //given
        $map = new EntityMapWithStats([
            'unique' => [
                'name'
            ],
        ]);
    
        $stats = $map->stats();
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 16]);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17]);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => 'ula', 'age' => 15]);
        $entityFour = new FakeEntity(new FakeIntegerId(), ['name' => 'ela', 'age' => 15]);
    
        self::assertSame($entityOne, $map->rememberEntity($entityOne));
        self::assertSame($entityTwo, $map->rememberEntity($entityTwo));
        self::assertSame($entityThree, $map->rememberEntity($entityThree));
        self::assertSame($entityFour, $map->rememberEntity($entityFour));
    
        //when
        self::assertEmpty($map->findAllEntities(['name' => 'zenek']));
        //then
        $expected = [
            'searchAllInUniqueOne' => 1,
            'impossibleToMatchForAllInUniqueOne' => 1,
            'findAllFailed' => 1,
        ];
        $this->checkStats($stats, $expected);
    }
    
    public function test_map_can_find_many_entities()
    {
        //given
        $map = new EntityMapWithStats([
            'multi' => [
                'name', 'symbol'
            ],
        ]);
    
        $stats = $map->stats();
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 16, 'symbol' => 'x', 'sex' => 'f']);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17, 'symbol' => 'y', 'sex' => 'f']);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        $entityFour = new FakeEntity(new FakeIntegerId(), ['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
    
        self::assertSame($entityOne, $map->rememberEntity($entityOne));
        self::assertSame($entityTwo, $map->rememberEntity($entityTwo));
        self::assertSame($entityThree, $map->rememberEntity($entityThree));
        self::assertSame($entityFour, $map->rememberEntity($entityFour));
        
        //when
        self::assertEmpty($map->findAllEntities(['name' => 'ula']));
        //then
        $expected = [
            'searchAllInMultipleOne' => 1,
            'impossibleToMatchForAllInMultipleOne' => 1,
            'findAllFailed' => 1,
        ];
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame([$entityTwo, $entityThree], $map->findAllEntities(['name' => 'ola']));
        //then
        $expected['searchAllInMultipleOne'] += 1;
        $expected['conditionsForAllNotCompleteInMultipleOne'] = 1;
        $expected['winnerStrictFromMultipleCandidatesInFindAll'] = 1;
        $expected['findAllSucceeded'] = 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame([$entityThree], $map->findAllEntities(['name' => 'ola', 'symbol' => 'z']));
        //then
        $expected['searchAllInMultipleOne'] += 1;
        $expected['someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll'] = 1;
        $expected['findAllSucceeded'] += 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame([], $map->findAllEntities(['name' => 'ola', 'symbol' => 'w']));
        //then
        $expected['searchAllInMultipleOne'] += 1;
        $expected['impossibleToMatchForAllInMultipleOne'] += 1;
        $expected['findAllFailed'] += 1;
        $this->checkStats($stats, $expected);
        
        //when
        self::assertSame([$entityTwo], $map->findAllEntities(['name' => 'ola', 'age' => 17]));
        //then
        $expected['searchAllInMultipleOne'] += 1;
        $expected['conditionsForAllNotCompleteInMultipleOne'] += 1;
        $expected['someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll'] += 1;
        $expected['findAllSucceeded'] += 1;
        $this->checkStats($stats, $expected);
    }
    
    public function test_it_can_index_by_many_various_indexes_at_the_same_time()
    {
        //given
        $map = new EntityMapWithStats([
            'unique' => [
                ['name', 'age', 'symbol'],
            ],
            'multi' => [
                'name',
                ['name', 'symbol'],
            ],
        ]);
    
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 16, 'symbol' => 'x', 'sex' => 'f']);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17, 'symbol' => 'y', 'sex' => 'f']);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        $entityFour = new FakeEntity(new FakeIntegerId(), ['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        $entityFive = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 15, 'symbol' => 'y', 'sex' => 'f']);
        $entitySix = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 18, 'symbol' => 'z', 'sex' => 'f']);

        //when
        $map->rememberEntity($entityOne);
        $map->rememberEntity($entityTwo);
        $map->rememberEntity($entityThree);
        $map->rememberEntity($entityFour);
        $map->rememberEntity($entityFive);
        $map->rememberEntity($entitySix);
        
        //then
        $foundOne = $map->findOneEntity(['age' => 15, 'name' => 'ala', 'symbol' => 'y']);
        self::assertSame($entityFive, $foundOne);
        
        $foundAll = $map->findAllEntities(['age' => 15, 'name' => 'ala', 'symbol' => 'y']);
        self::assertSame([$entityFive], $foundAll);
        
        $foundAll = $map->findAllEntities(['name' => 'ola', 'symbol' => 'z']);
        self::assertSame([$entityThree, $entitySix], $foundAll);
        
        $foundOne = $map->findOneEntity(['name' => 'ala', 'age' => 15]);
        self::assertSame($entityFive, $foundOne);
        
        $foundAll = $map->findAllEntities(['name' => 'ola', 'age' => 15]);
        self::assertSame([$entityThree], $foundAll);
    }
    
    public function test_it_can_forget_particular_indexed_entity()
    {
        $map = new EntityMapWithStats([
            'unique' => [
                ['name', 'age', 'symbol'],
            ],
            'multi' => [
                'name',
                ['name', 'symbol'],
            ],
        ]);
    
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 16, 'symbol' => 'x', 'sex' => 'f']);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17, 'symbol' => 'y', 'sex' => 'f']);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        $entityFour = new FakeEntity(new FakeIntegerId(), ['name' => 'ela', 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        $entityFive = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 15, 'symbol' => 'y', 'sex' => 'f']);
        $entitySix = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 18, 'symbol' => 'z', 'sex' => 'f']);
    
        $map->rememberEntity($entityOne);
        $map->rememberEntity($entityTwo);
        $map->rememberEntity($entityThree);
        $map->rememberEntity($entityFour);
        $map->rememberEntity($entityFive);
        $map->rememberEntity($entitySix);
    
        $foundOne = $map->findOneEntity(['name' => 'ala', 'age' => 15]);
        self::assertSame($entityFive, $foundOne);
        
        $map->forgetEntity($entityFive);
        
        self::assertNull($map->findOneEntity(['name' => 'ala', 'age' => 15]));
        self::assertSame([$entityOne], $map->findAllEntities(['name' => 'ala']));
    }
    
    /**
     * @param EntityMapStatsView $stats
     * @param array $expected
     * @return void
     */
    private function checkStats(EntityMapStatsView $stats, array $expected)
    {
        $keys = [
            'foundByKeyTotal',
            'notFoundByKeyTotal',
            'findOneFailed',
            'searchInUniqueOne',
            'notFoundInUniqueOne',
            'ambiguousFoundInUniqueOne',
            'candidateOfUniqueOneDoesNotMatch',
            'findOneSucceeded',
            'strictFoundOneInUniqueOne',
            'candidateOfUniqueOneMatches',
            'impossibleToMatchForUniqueOne',
            'missedFindOneUniqueTwo',
            'ambiguousFoundInUniqueTwo',
            'searchInUniqueTwo',
            'notFoundOneInCollection',
            'candidateOfUniqueTwoMatches',
            'foundOneInCollection',
            'candidateOfUniqueTwoDoesNotMatch',
            'conditionsNotCompleteForUniqueTwo',
            'strictFoundOneInUniqueTwo',
            'searchInUniqueThree',
            'conditionsNotCompleteForUniqueThree',
            'missedFindOneUniqueThree',
            'ambiguousFoundInUniqueThree',
            'strictFoundOneInUniqueThree',
            'candidateOfUniqueThreeMatches',
            'candidateOfUniqueThreeDoesNotMatch',
            'searchInUniqueFour',
            'conditionsNotCompleteForUniqueFour',
            'missedFindOneUniqueFour',
            'ambiguousFoundInUniqueFour',
            'strictFoundOneInUniqueFour',
            'candidateOfUniqueFourMatches',
            'candidateOfUniqueFourDoesNotMatch',
            'searchInMultipleFour',
            'conditionsNotCompleteForMultipleFour',
            'impossibleToMatchForMultipleFour',
            'searchInMultipleThree',
            'conditionsNotCompleteForMultipleThree',
            'impossibleToMatchForMultipleThree',
            'searchInMultipleTwo',
            'conditionsNotCompleteForMultipleTwo',
            'impossibleToMatchForMultipleTwo',
            'searchInMultipleOne',
            'conditionsNotCompleteForMultipleOne',
            'impossibleToMatchForMultipleOne',
            'noWinnersFromMultipleCandidatesInFindOne',
            'winnerStrictFromMultipleCandidatesInFindOne',
            'winnerFromMultipleCandidatesSatisfiesConditionsInFindOne',
            'winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne',
            'findAllFailed',
            'searchAllInUniqueOne',
            'impossibleToMatchForAllInUniqueOne',
            'ambiguousFoundForAllInUniqueOne',
            'findAllSucceeded',
            'strictFoundAllInUniqueOne',
            'candidateForAllOfUniqueOneMatches',
            'candidateForAllOfUniqueOneDoesNotMatch',
            'notFoundAllInUniqueOne',
            'searchAllInUniqueTwo',
            'conditionsForAllNotCompleteInUniqueTwo',
            'missedFindAllUniqueTwo',
            'ambiguousFoundForAllInUniqueTwo',
            'strictFoundAllInUniqueTwo',
            'candidateForAllOfUniqueTwoMatches',
            'candidateForAllOfUniqueTwoDoesNotMatch',
            'searchAllInUniqueThree',
            'conditionsForAllNotCompleteInUniqueThree',
            'missedFindAllUniqueThree',
            'ambiguousFoundForAllInUniqueThree',
            'strictFoundAllInUniqueThree',
            'candidateForAllOfUniqueThreeMatches',
            'candidateForAllOfUniqueThreeDoesNotMatch',
            'searchAllInUniqueFour',
            'conditionsForAllNotCompleteInUniqueFour',
            'missedFindAllUniqueFour',
            'ambiguousFoundForAllInUniqueFour',
            'strictFoundAllInUniqueFour',
            'candidateForAllOfUniqueFourMatches',
            'candidateForAllOfUniqueFourDoesNotMatch',
            'searchAllInMultipleFour',
            'conditionsForAllNotCompleteInMultipleFour',
            'impossibleToMatchForAllInMultipleFour',
            'searchAllInMultipleThree',
            'conditionsForAllNotCompleteInMultipleThree',
            'impossibleToMatchForAllInMultipleThree',
            'searchAllInMultipleTwo',
            'conditionsForAllNotCompleteInMultipleTwo',
            'impossibleToMatchForAllInMultipleTwo',
            'searchAllInMultipleOne',
            'conditionsForAllNotCompleteInMultipleOne',
            'impossibleToMatchForAllInMultipleOne',
            'notFoundAnyInCollection',
            'foundSomeInCollection',
            'noWinnersFromMultipleCandidatesInFindAll',
            'winnerStrictFromMultipleCandidatesInFindAll',
            'noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll',
            'someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll',
        ];
        
        $expected = array_merge(array_fill_keys($keys, 0), $expected);
        
        foreach ($expected as $method => $value) {
            self::assertSame($value, $stats->{$method}(), $method);
        }
    }
    
    public function test_float_numbers_as_keys_in_array()
    {
        $arr = [];
        $key1 = 5;
        $key2 = 5.43;
        $key3 = '5';
        $key4 = '5.43';
        $key5 = '5,43';
        
        $arr[$key1] = 1;
        self::assertSame([5 => 1], $arr);
        
        $arr[$key2] = 2;
        self::assertSame([5 => 2], $arr);
        
        $arr[$key3] = 3;
        self::assertSame([5 => 3], $arr);
        
        $arr[$key4] = 4;
        self::assertSame([5 => 3, '5.43' => 4], $arr);
        
        $arr[$key5] = 5;
        self::assertSame([5 => 3, '5.43' => 4, '5,43' => 5], $arr);
    }
}
