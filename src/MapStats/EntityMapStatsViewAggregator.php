<?php

namespace FiiSoft\EntityIndexer\MapStats;

use Closure;

final class EntityMapStatsViewAggregator extends BaseEntityMapStatsView
{
    /** @var EntityMapStatsViewAggregator */
    private static $instance;
    
    /** @var EntityMapStatsView[] */
    private $statsViews = [];
    
    /**
     * @return EntityMapStatsViewAggregator singleton
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * @param EntityMapStatsView $statsView
     * @return void
     */
    public function add(EntityMapStatsView $statsView)
    {
        $this->statsViews[spl_object_hash($statsView)] = $statsView;
    }
    
    /**
     * Reset (clear) stats and start counting from zero.
     *
     * @return void
     */
    public function clear()
    {
        foreach ($this->statsViews as $statsView) {
            $statsView->clear();
        }
    }
    
    /**
     * @return int
     */
    public function foundByKeyTotal()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->foundByKeyTotal(); });
    }
    
    /**
     * @return int
     */
    public function notFoundByKeyTotal()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->notFoundByKeyTotal(); });
    }
    
    /**
     * @return int
     */
    public function findOneFailed()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->findOneFailed(); });
    }
    
    /**
     * @return int
     */
    public function searchInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchInUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function notFoundInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->notFoundInUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->ambiguousFoundInUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueOneDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateOfUniqueOneDoesNotMatch(); });
    }
    
    /**
     * @return int
     */
    public function findOneSucceeded()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->findOneSucceeded(); });
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->strictFoundOneInUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueOneMatches()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateOfUniqueOneMatches(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function missedFindOneUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->missedFindOneUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->ambiguousFoundInUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function searchInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchInUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function notFoundOneInCollection()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->notFoundOneInCollection(); });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueTwoMatches()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateOfUniqueTwoMatches(); });
    }
    
    /**
     * @return int
     */
    public function foundOneInCollection()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->foundOneInCollection(); });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueTwoDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateOfUniqueTwoDoesNotMatch(); });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsNotCompleteForUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->strictFoundOneInUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function searchInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchInUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsNotCompleteForUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function missedFindOneUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->missedFindOneUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->ambiguousFoundInUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->strictFoundOneInUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueThreeMatches()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateOfUniqueThreeMatches(); });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueThreeDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateOfUniqueThreeDoesNotMatch(); });
    }
    
    /**
     * @return int
     */
    public function searchInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchInUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsNotCompleteForUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function missedFindOneUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->missedFindOneUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->ambiguousFoundInUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->strictFoundOneInUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueFourMatches()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateOfUniqueFourMatches(); });
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueFourDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateOfUniqueFourDoesNotMatch(); });
    }
    
    /**
     * @return int
     */
    public function searchInMultipleFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchInMultipleFour(); });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsNotCompleteForMultipleFour(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForMultipleFour(); });
    }
    
    /**
     * @return int
     */
    public function searchInMultipleThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchInMultipleThree(); });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsNotCompleteForMultipleThree(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForMultipleThree(); });
    }
    
    /**
     * @return int
     */
    public function searchInMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchInMultipleTwo(); });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsNotCompleteForMultipleTwo(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForMultipleTwo(); });
    }
    
    /**
     * @return int
     */
    public function searchInMultipleOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchInMultipleOne(); });
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsNotCompleteForMultipleOne(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForMultipleOne(); });
    }
    
    /**
     * @return int
     */
    public function noWinnersFromMultipleCandidatesInFindOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->noWinnersFromMultipleCandidatesInFindOne(); });
    }
    
    /**
     * @return int
     */
    public function winnerStrictFromMultipleCandidatesInFindOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->winnerStrictFromMultipleCandidatesInFindOne(); });
    }
    
    /**
     * @return int
     */
    public function winnerFromMultipleCandidatesSatisfiesConditionsInFindOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->winnerFromMultipleCandidatesSatisfiesConditionsInFindOne(); });
    }
    
    /**
     * @return int
     */
    public function winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne(); });
    }
    
    /**
     * @return int
     */
    public function findAllFailed()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->findAllFailed(); });
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchAllInUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForAllInUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->ambiguousFoundForAllInUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function findAllSucceeded()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->findAllSucceeded(); });
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->strictFoundAllInUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueOneMatches()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateForAllOfUniqueOneMatches(); });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueOneDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateForAllOfUniqueOneDoesNotMatch(); });
    }
    
    /**
     * @return int
     */
    public function notFoundAllInUniqueOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->notFoundAllInUniqueOne(); });
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchAllInUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsForAllNotCompleteInUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function missedFindAllUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->missedFindAllUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->ambiguousFoundForAllInUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->strictFoundAllInUniqueTwo(); });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueTwoMatches()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateForAllOfUniqueTwoMatches(); });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueTwoDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateForAllOfUniqueTwoDoesNotMatch(); });
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchAllInUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsForAllNotCompleteInUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function missedFindAllUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->missedFindAllUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->ambiguousFoundForAllInUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->strictFoundAllInUniqueThree(); });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueThreeMatches()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateForAllOfUniqueThreeMatches(); });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueThreeDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateForAllOfUniqueThreeDoesNotMatch(); });
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchAllInUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsForAllNotCompleteInUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function missedFindAllUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->missedFindAllUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->ambiguousFoundForAllInUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->strictFoundAllInUniqueFour(); });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueFourMatches()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateForAllOfUniqueFourMatches(); });
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueFourDoesNotMatch()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->candidateForAllOfUniqueFourDoesNotMatch(); });
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchAllInMultipleFour(); });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsForAllNotCompleteInMultipleFour(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleFour()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForAllInMultipleFour(); });
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchAllInMultipleThree(); });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsForAllNotCompleteInMultipleThree(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleThree()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForAllInMultipleThree(); });
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchAllInMultipleTwo(); });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsForAllNotCompleteInMultipleTwo(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleTwo()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForAllInMultipleTwo(); });
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->searchAllInMultipleOne(); });
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->conditionsForAllNotCompleteInMultipleOne(); });
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleOne()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->impossibleToMatchForAllInMultipleOne(); });
    }
    
    /**
     * @return int
     */
    public function notFoundAnyInCollection()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->notFoundAnyInCollection(); });
    }
    
    /**
     * @return int
     */
    public function foundSomeInCollection()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->foundSomeInCollection(); });
    }
    
    /**
     * @return int
     */
    public function noWinnersFromMultipleCandidatesInFindAll()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->noWinnersFromMultipleCandidatesInFindAll(); });
    }
    
    /**
     * @return int
     */
    public function winnerStrictFromMultipleCandidatesInFindAll()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->winnerStrictFromMultipleCandidatesInFindAll(); });
    }
    
    /**
     * @return int
     */
    public function noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll(); });
    }
    
    /**
     * @return int
     */
    public function someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll()
    {
        return $this->sumBy(function (EntityMapStatsView $statsView) { return $statsView->someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll(); });
    }
    
    /**
     * @param Closure $getValue
     * @return int
     */
    private function sumBy(Closure $getValue)
    {
        return array_reduce($this->statsViews, function ($total, EntityMapStatsView $statsView) use ($getValue) {
            return $total + $getValue($statsView);
        }, 0);
    }
}