<?php

namespace FiiSoft\Test\EntityIndexer\MapStats;

use FiiSoft\EntityIndexer\MapStats\EntityMapStats;
use FiiSoft\EntityIndexer\MapStats\SingleEntityMapStatsView;

class SingleEntityMapStatsViewTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_can_provide_collected_stats_as_array()
    {
        $stats = new EntityMapStats();
        $statsView = new SingleEntityMapStatsView($stats);
        
        $stats->foundSomeInCollection();
        
        self::assertSame(1, $statsView->foundSomeInCollection());
        self::assertSame(1, $statsView->findAllSucceeded());
        self::assertSame(0, $statsView->findAllFailed());
        
        $actual = $statsView->toArray();
        self::assertInternalType('array', $actual);
        
        $subset = [
            'foundSomeInCollection' => 1,
            'findAllSucceeded' => 1,
            'findAllFailed' => 0,
        ];
        self::assertArraySubset($subset, $actual);
        
        self::assertArrayNotHasKey('clear', $actual);
        self::assertArrayNotHasKey('toArray', $actual);
        
        echo print_r($actual, true);
    }
}
