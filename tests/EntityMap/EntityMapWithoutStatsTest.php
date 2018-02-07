<?php

namespace FiiSoft\Test\EntityIndexer\EntityMap;

use FiiSoft\EntityIndexer\EntityMap\EntityMapWithoutStats;
use FiiSoft\Test\EntityIndexer\Doubles\FakeEntity;
use FiiSoft\Test\EntityIndexer\Doubles\FakeIntegerId;

class EntityMapWithoutStatsTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_can_index_entities_with_indexed_property_null()
    {
        $map = new EntityMapWithoutStats([
            'unique' => [
                ['name'],
                ['age', 'symbol'],
            ],
            'multi' => [
                ['symbol'],
            ],
        ]);
        
        $entityOne = new FakeEntity(new FakeIntegerId(), ['name' => 'ala', 'age' => 16, 'symbol' => 'x', 'sex' => 'f']);
        $entityTwo = new FakeEntity(new FakeIntegerId(), ['name' => 'ola', 'age' => 17, 'symbol' => 'y', 'sex' => 'f']);
        $entityThree = new FakeEntity(new FakeIntegerId(), ['name' => null, 'age' => 15, 'symbol' => 'z', 'sex' => 'f']);
        $entityFour = new FakeEntity(new FakeIntegerId(), ['name' => 'ela', 'age' => 15, 'symbol' => null, 'sex' => 'f']);
        $entityFive = new FakeEntity(new FakeIntegerId(), ['name' => null, 'age' => 15, 'symbol' => null, 'sex' => 'f']);
        $entitySix = new FakeEntity(new FakeIntegerId(), ['name' => null, 'age' => 18, 'symbol' => 'z', 'sex' => 'f']);
        
        $map->rememberEntity($entityOne);
        $map->rememberEntity($entityTwo);
        $map->rememberEntity($entityThree);
        $map->rememberEntity($entityFour);
        $map->rememberEntity($entityFive);
        $map->rememberEntity($entitySix);
        
        $findOneWithNameAla = $map->findOneEntity(['name' => 'ala']);
        self::assertSame($entityOne, $findOneWithNameAla);
        
        $findOneWithAge15AndSymbolZ = $map->findOneEntity(['age' => 15, 'symbol' => 'z']);
        self::assertSame($entityThree, $findOneWithAge15AndSymbolZ);
        
        $findOneWithNameNull = $map->findOneEntity(['name' => null]);
        self::assertSame($entityThree, $findOneWithNameNull);
        
        $findOneWithNameNullAndAge18 = $map->findOneEntity(['name' => null, 'age' => 18]);
        self::assertSame($entitySix, $findOneWithNameNullAndAge18);
        
        $findOneWithNameAlaAndSymbolX = $map->findOneEntity(['name' => 'ala', 'symbol' => 'x']);
        self::assertSame($entityOne, $findOneWithNameAlaAndSymbolX);
        
        $findAllWithNameAlaAndSymbolX = $map->findAllEntities(['name' => 'ala', 'symbol' => 'x']);
        $this->checkCollectionsOfEntities([$entityOne], $findAllWithNameAlaAndSymbolX);
        
        $findWithNameNullAndAge15 = $map->findAllEntities(['name' => null, 'age' => 15]);
        $this->checkCollectionsOfEntities([$entityThree, $entityFive], $findWithNameNullAndAge15);
        
        $findOneWithNameNullAndSymbolZ = $map->findOneEntity(['name' => null, 'symbol' => 'z']);
        self::assertSame($entityThree, $findOneWithNameNullAndSymbolZ);
        
        $findAllWithNameNullAndSymbolZ = $map->findAllEntities(['name' => null, 'symbol' => 'z']);
        $this->checkCollectionsOfEntities([$entityThree, $entitySix], $findAllWithNameNullAndSymbolZ);
        
        $findAllWithSymbolNull = $map->findAllEntities(['symbol' => null]);
        $this->checkCollectionsOfEntities([$entityFour, $entityFive], $findAllWithSymbolNull);
        
        $findOneWithSymbolNull = $map->findOneEntity(['symbol' => null]);
        self::assertSame($entityFour, $findOneWithSymbolNull);
        
        $findWithNameNull = $map->findAllEntities(['name' => null]);
        $this->checkCollectionsOfEntities([$entityThree, $entityFive, $entitySix], $findWithNameNull);
        
        $findByAge15 = $map->findAllEntities(['age' => 15]);
        $this->checkCollectionsOfEntities([$entityThree, $entityFour, $entityFive], $findByAge15);
        
        $findByAge15WithSymbolNull = $map->findAllEntities(['age' => 15, 'symbol' => null]);
        $this->checkCollectionsOfEntities([$entityFour, $entityFive], $findByAge15WithSymbolNull);
        
        $findBySymbolZ = $map->findAllEntities(['symbol' => 'z']);
        $this->checkCollectionsOfEntities([$entityThree, $entitySix], $findBySymbolZ);
        
        $map->forgetEntity($entityThree);
        self::assertEmpty($map->findAllEntities(['age' => 15, 'symbol' => 'z']));
        
        $map->forgetEntity($entitySix);
        $this->checkCollectionsOfEntities([$entityFive], $map->findAllEntities(['name' => null]));
    }
    
    /**
     * @param FakeEntity[] $expectedEntities
     * @param FakeEntity[] $actualEntities
     * @return void
     */
    private function checkCollectionsOfEntities(array $expectedEntities, array $actualEntities)
    {
        self::assertCount(count($expectedEntities), $actualEntities);
        
        foreach ($expectedEntities as $expected) {
            foreach ($actualEntities as $actual) {
                if ($expected === $actual) {
                    continue 2;
                }
            }
            self::fail('Expected entity '.$expected.' not found!');
        }
    }
}
