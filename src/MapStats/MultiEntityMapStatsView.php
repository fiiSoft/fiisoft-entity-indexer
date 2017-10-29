<?php

namespace FiiSoft\EntityIndexer\MapStats;

use Closure;

final class MultiEntityMapStatsView implements EntityMapStatsView
{
    /** @var MultiEntityMapStatsView */
    private static $instance;
    
    /** @var EntityMapStats[] */
    private $stats = [];
    
    /**
     * @return MultiEntityMapStatsView singleton
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * @param EntityMapStats $stats
     * @return void
     */
    public function add(EntityMapStats $stats)
    {
        $this->stats[spl_object_hash($stats)] = $stats;
    }
    
    /**
     * @return void
     */
    public function clear()
    {
        foreach ($this->stats as $stat) {
            $stat->clear();
        }
    }
    
    /**
     * @return int
     */
    public function foundByKeyTotal()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->foundByKeyTotal; });
    }
    
    /**
     * @return int
     */
    public function notFoundByKeyTotal()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->notFoundByKeyTotal; });
    }
    
    /**
     * @return int
     */
    public function findOneFailed()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->findOneFailed; });
    }
    
    /**
     * @return int
     */
    public function searchInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchInUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function notFoundInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->notFoundInUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->ambiguousFoundInUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueOneDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateOfUniqueOneDoesNotMatch; });
    }
    
    /**
     * @return int
     */
    public function findOneSucceeded()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->findOneSucceeded; });
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->strictFoundOneInUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueOneMatches()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateOfUniqueOneMatches; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function missedFindOneUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->missedFindOneUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->ambiguousFoundInUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function searchInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchInUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function notFoundOneInCollection()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->notFoundOneInCollection; });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueTwoMatches()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateOfUniqueTwoMatches; });
    }
    
    /**
     * @return int
     */
    public function foundOneInCollection()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->foundOneInCollection; });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueTwoDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateOfUniqueTwoDoesNotMatch; });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsNotCompleteForUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->strictFoundOneInUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function searchInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchInUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsNotCompleteForUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function missedFindOneUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->missedFindOneUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->ambiguousFoundInUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->strictFoundOneInUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueThreeMatches()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateOfUniqueThreeMatches; });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueThreeDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateOfUniqueThreeDoesNotMatch; });
    }
    
    /**
     * @return int
     */
    public function searchInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchInUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsNotCompleteForUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function missedFindOneUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->missedFindOneUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->ambiguousFoundInUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->strictFoundOneInUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueFourMatches()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateOfUniqueFourMatches; });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueFourDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateOfUniqueFourDoesNotMatch; });
    }
    
    /**
     * @return int
     */
    public function searchInMultipleFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchInMultipleFour; });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsNotCompleteForMultipleFour; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForMultipleFour; });
    }
    
    /**
     * @return int
     */
    public function searchInMultipleThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchInMultipleThree; });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsNotCompleteForMultipleThree; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForMultipleThree; });
    }
    
    /**
     * @return int
     */
    public function searchInMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchInMultipleTwo; });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsNotCompleteForMultipleTwo; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForMultipleTwo; });
    }
    
    /**
     * @return int
     */
    public function searchInMultipleOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchInMultipleOne; });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsNotCompleteForMultipleOne; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForMultipleOne; });
    }
    
    /**
     * @return int
     */
    public function noWinnersFromMultipleCandidatesInFindOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->noWinnersFromMultipleCandidatesInFindOne; });
    }
    
    /**
     * @return int
     */
    public function winnerStrictFromMultipleCandidatesInFindOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->winnerStrictFromMultipleCandidatesInFindOne; });
    }
    
    /**
     * @return int
     */
    public function winnerFromMultipleCandidatesSatisfiesConditionsInFindOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->winnerFromMultipleCandidatesSatisfiesConditionsInFindOne; });
    }
    
    /**
     * @return int
     */
    public function winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne; });
    }
    
    /**
     * @return int
     */
    public function findAllFailed()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->findAllFailed; });
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchAllInUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForAllInUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->ambiguousFoundForAllInUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function findAllSucceeded()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->findAllSucceeded; });
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->strictFoundAllInUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueOneMatches()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateForAllOfUniqueOneMatches; });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueOneDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateForAllOfUniqueOneDoesNotMatch; });
    }
    
    /**
     * @return int
     */
    public function notFoundAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->notFoundAllInUniqueOne; });
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchAllInUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsForAllNotCompleteInUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function missedFindAllUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->missedFindAllUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->ambiguousFoundForAllInUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->strictFoundAllInUniqueTwo; });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueTwoMatches()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateForAllOfUniqueTwoMatches; });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueTwoDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateForAllOfUniqueTwoDoesNotMatch; });
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchAllInUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsForAllNotCompleteInUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function missedFindAllUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->missedFindAllUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->ambiguousFoundForAllInUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->strictFoundAllInUniqueThree; });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueThreeMatches()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateForAllOfUniqueThreeMatches; });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueThreeDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateForAllOfUniqueThreeDoesNotMatch; });
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchAllInUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsForAllNotCompleteInUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function missedFindAllUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->missedFindAllUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->ambiguousFoundForAllInUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->strictFoundAllInUniqueFour; });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueFourMatches()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateForAllOfUniqueFourMatches; });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueFourDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->candidateForAllOfUniqueFourDoesNotMatch; });
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchAllInMultipleFour; });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsForAllNotCompleteInMultipleFour; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleFour()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForAllInMultipleFour; });
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchAllInMultipleThree; });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsForAllNotCompleteInMultipleThree; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleThree()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForAllInMultipleThree; });
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchAllInMultipleTwo; });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsForAllNotCompleteInMultipleTwo; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForAllInMultipleTwo; });
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->searchAllInMultipleOne; });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->conditionsForAllNotCompleteInMultipleOne; });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleOne()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->impossibleToMatchForAllInMultipleOne; });
    }
    
    /**
     * @return int
     */
    public function notFoundAnyInCollection()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->notFoundAnyInCollection; });
    }
    
    /**
     * @return int
     */
    public function foundSomeInCollection()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->foundSomeInCollection; });
    }
    
    /**
     * @return int
     */
    public function noWinnersFromMultipleCandidatesInFindAll()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->noWinnersFromMultipleCandidatesInFindAll; });
    }
    
    /**
     * @return int
     */
    public function winnerStrictFromMultipleCandidatesInFindAll()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->winnerStrictFromMultipleCandidatesInFindAll; });
    }
    
    /**
     * @return int
     */
    public function noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll; });
    }
    
    /**
     * @return int
     */
    public function someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll()
    {
        return $this->sumBy(function (EntityMapStats $stats) { return $stats->someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll; });
    }
    
    /**
     * @param Closure $getValue
     * @return int
     */
    private function sumBy(Closure $getValue)
    {
        return array_reduce($this->stats, function ($total, EntityMapStats $stats) use ($getValue) {
            return $total + $getValue($stats);
        }, 0);
    }
}