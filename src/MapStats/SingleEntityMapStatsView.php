<?php

namespace FiiSoft\EntityIndexer\MapStats;

final class SingleEntityMapStatsView implements EntityMapStatsView
{
    /** @var EntityMapStats */
    private $stats;
    
    /**
     * @param EntityMapStats $stats
     */
    public function __construct(EntityMapStats $stats)
    {
        $this->stats = $stats;
    }
    
    /**
     * @return void
     */
    public function clear()
    {
        $this->stats->clear();
    }
    
    /**
     * @return int
     */
    public function foundByKeyTotal()
    {
        return $this->stats->foundByKeyTotal;
    }
    
    /**
     * @return int
     */
    public function notFoundByKeyTotal()
    {
        return $this->stats->notFoundByKeyTotal;
    }
    
    /**
     * @return int
     */
    public function findOneFailed()
    {
        return $this->stats->findOneFailed;
    }
    
    /**
     * @return int
     */
    public function searchInUniqueOne()
    {
        return $this->stats->searchInUniqueOne;
    }
    
    /**
     * @return int
     */
    public function notFoundInUniqueOne()
    {
        return $this->stats->notFoundInUniqueOne;
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueOne()
    {
        return $this->stats->ambiguousFoundInUniqueOne;
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueOneDoesNotMatch()
    {
        return $this->stats->candidateOfUniqueOneDoesNotMatch;
    }
    
    /**
     * @return int
     */
    public function findOneSucceeded()
    {
        return $this->stats->findOneSucceeded;
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueOne()
    {
        return $this->stats->strictFoundOneInUniqueOne;
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueOneMatches()
    {
        return $this->stats->candidateOfUniqueOneMatches;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForUniqueOne()
    {
        return $this->stats->impossibleToMatchForUniqueOne;
    }
    
    /**
     * @return int
     */
    public function missedFindOneUniqueTwo()
    {
        return $this->stats->missedFindOneUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueTwo()
    {
        return $this->stats->ambiguousFoundInUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function searchInUniqueTwo()
    {
        return $this->stats->searchInUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function notFoundOneInCollection()
    {
        return $this->stats->notFoundOneInCollection;
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueTwoMatches()
    {
        return $this->stats->candidateOfUniqueTwoMatches;
    }
    
    /**
     * @return int
     */
    public function foundOneInCollection()
    {
        return $this->stats->foundOneInCollection;
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueTwoDoesNotMatch()
    {
        return $this->stats->candidateOfUniqueTwoDoesNotMatch;
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueTwo()
    {
        return $this->stats->conditionsNotCompleteForUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueTwo()
    {
        return $this->stats->strictFoundOneInUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function searchInUniqueThree()
    {
        return $this->stats->searchInUniqueThree;
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueThree()
    {
        return $this->stats->conditionsNotCompleteForUniqueThree;
    }
    
    /**
     * @return int
     */
    public function missedFindOneUniqueThree()
    {
        return $this->stats->missedFindOneUniqueThree;
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueThree()
    {
        return $this->stats->ambiguousFoundInUniqueThree;
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueThree()
    {
        return $this->stats->strictFoundOneInUniqueThree;
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueThreeMatches()
    {
        return $this->stats->candidateOfUniqueThreeMatches;
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueThreeDoesNotMatch()
    {
        return $this->stats->candidateOfUniqueThreeDoesNotMatch;
    }
    
    /**
     * @return int
     */
    public function searchInUniqueFour()
    {
        return $this->stats->searchInUniqueFour;
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueFour()
    {
        return $this->stats->conditionsNotCompleteForUniqueFour;
    }
    
    /**
     * @return int
     */
    public function missedFindOneUniqueFour()
    {
        return $this->stats->missedFindOneUniqueFour;
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueFour()
    {
        return $this->stats->ambiguousFoundInUniqueFour;
    }
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueFour()
    {
        return $this->stats->strictFoundOneInUniqueFour;
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueFourMatches()
    {
        return $this->stats->candidateOfUniqueFourMatches;
    }
    
    /**
     * @return int
     */
    public function candidateOfUniqueFourDoesNotMatch()
    {
        return $this->stats->candidateOfUniqueFourDoesNotMatch;
    }
    
    /**
     * @return int
     */
    public function searchInMultipleFour()
    {
        return $this->stats->searchInMultipleFour;
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleFour()
    {
        return $this->stats->conditionsNotCompleteForMultipleFour;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleFour()
    {
        return $this->stats->impossibleToMatchForMultipleFour;
    }
    
    /**
     * @return int
     */
    public function searchInMultipleThree()
    {
        return $this->stats->searchInMultipleThree;
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleThree()
    {
        return $this->stats->conditionsNotCompleteForMultipleThree;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleThree()
    {
        return $this->stats->impossibleToMatchForMultipleThree;
    }
    
    /**
     * @return int
     */
    public function searchInMultipleTwo()
    {
        return $this->stats->searchInMultipleTwo;
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleTwo()
    {
        return $this->stats->conditionsNotCompleteForMultipleTwo;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleTwo()
    {
        return $this->stats->impossibleToMatchForMultipleTwo;
    }
    
    /**
     * @return int
     */
    public function searchInMultipleOne()
    {
        return $this->stats->searchInMultipleOne;
    }
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleOne()
    {
        return $this->stats->conditionsNotCompleteForMultipleOne;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleOne()
    {
        return $this->stats->impossibleToMatchForMultipleOne;
    }
    
    /**
     * @return int
     */
    public function noWinnersFromMultipleCandidatesInFindOne()
    {
        return $this->stats->noWinnersFromMultipleCandidatesInFindOne;
    }
    
    /**
     * @return int
     */
    public function winnerStrictFromMultipleCandidatesInFindOne()
    {
        return $this->stats->winnerStrictFromMultipleCandidatesInFindOne;
    }
    
    /**
     * @return int
     */
    public function winnerFromMultipleCandidatesSatisfiesConditionsInFindOne()
    {
        return $this->stats->winnerFromMultipleCandidatesSatisfiesConditionsInFindOne;
    }
    
    /**
     * @return int
     */
    public function winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne()
    {
        return $this->stats->winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne;
    }
    
    /**
     * @return int
     */
    public function findAllFailed()
    {
        return $this->stats->findAllFailed;
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueOne()
    {
        return $this->stats->searchAllInUniqueOne;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInUniqueOne()
    {
        return $this->stats->impossibleToMatchForAllInUniqueOne;
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueOne()
    {
        return $this->stats->ambiguousFoundForAllInUniqueOne;
    }
    
    /**
     * @return int
     */
    public function findAllSucceeded()
    {
        return $this->stats->findAllSucceeded;
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueOne()
    {
        return $this->stats->strictFoundAllInUniqueOne;
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueOneMatches()
    {
        return $this->stats->candidateForAllOfUniqueOneMatches;
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueOneDoesNotMatch()
    {
        return $this->stats->candidateForAllOfUniqueOneDoesNotMatch;
    }
    
    /**
     * @return int
     */
    public function notFoundAllInUniqueOne()
    {
        return $this->stats->notFoundAllInUniqueOne;
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueTwo()
    {
        return $this->stats->searchAllInUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueTwo()
    {
        return $this->stats->conditionsForAllNotCompleteInUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function missedFindAllUniqueTwo()
    {
        return $this->stats->missedFindAllUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueTwo()
    {
        return $this->stats->ambiguousFoundForAllInUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueTwo()
    {
        return $this->stats->strictFoundAllInUniqueTwo;
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueTwoMatches()
    {
        return $this->stats->candidateForAllOfUniqueTwoMatches;
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueTwoDoesNotMatch()
    {
        return $this->stats->candidateForAllOfUniqueTwoDoesNotMatch;
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueThree()
    {
        return $this->stats->searchAllInUniqueThree;
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueThree()
    {
        return $this->stats->conditionsForAllNotCompleteInUniqueThree;
    }
    
    /**
     * @return int
     */
    public function missedFindAllUniqueThree()
    {
        return $this->stats->missedFindAllUniqueThree;
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueThree()
    {
        return $this->stats->ambiguousFoundForAllInUniqueThree;
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueThree()
    {
        return $this->stats->strictFoundAllInUniqueThree;
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueThreeMatches()
    {
        return $this->stats->candidateForAllOfUniqueThreeMatches;
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueThreeDoesNotMatch()
    {
        return $this->stats->candidateForAllOfUniqueThreeDoesNotMatch;
    }
    
    /**
     * @return int
     */
    public function searchAllInUniqueFour()
    {
        return $this->stats->searchAllInUniqueFour;
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueFour()
    {
        return $this->stats->conditionsForAllNotCompleteInUniqueFour;
    }
    
    /**
     * @return int
     */
    public function missedFindAllUniqueFour()
    {
        return $this->stats->missedFindAllUniqueFour;
    }
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueFour()
    {
        return $this->stats->ambiguousFoundForAllInUniqueFour;
    }
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueFour()
    {
        return $this->stats->strictFoundAllInUniqueFour;
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueFourMatches()
    {
        return $this->stats->candidateForAllOfUniqueFourMatches;
    }
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueFourDoesNotMatch()
    {
        return $this->stats->candidateForAllOfUniqueFourDoesNotMatch;
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleFour()
    {
        return $this->stats->searchAllInMultipleFour;
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleFour()
    {
        return $this->stats->conditionsForAllNotCompleteInMultipleFour;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleFour()
    {
        return $this->stats->impossibleToMatchForAllInMultipleFour;
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleThree()
    {
        return $this->stats->searchAllInMultipleThree;
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleThree()
    {
        return $this->stats->conditionsForAllNotCompleteInMultipleThree;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleThree()
    {
        return $this->stats->impossibleToMatchForAllInMultipleThree;
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleTwo()
    {
        return $this->stats->searchAllInMultipleTwo;
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleTwo()
    {
        return $this->stats->conditionsForAllNotCompleteInMultipleTwo;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleTwo()
    {
        return $this->stats->impossibleToMatchForAllInMultipleTwo;
    }
    
    /**
     * @return int
     */
    public function searchAllInMultipleOne()
    {
        return $this->stats->searchAllInMultipleOne;
    }
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleOne()
    {
        return $this->stats->conditionsForAllNotCompleteInMultipleOne;
    }
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleOne()
    {
        return $this->stats->impossibleToMatchForAllInMultipleOne;
    }
    
    /**
     * @return int
     */
    public function notFoundAnyInCollection()
    {
        return $this->stats->notFoundAnyInCollection;
    }
    
    /**
     * @return int
     */
    public function foundSomeInCollection()
    {
        return $this->stats->foundSomeInCollection;
    }
    
    /**
     * @return int
     */
    public function noWinnersFromMultipleCandidatesInFindAll()
    {
        return $this->stats->noWinnersFromMultipleCandidatesInFindAll;
    }
    
    /**
     * @return int
     */
    public function winnerStrictFromMultipleCandidatesInFindAll()
    {
        return $this->stats->winnerStrictFromMultipleCandidatesInFindAll;
    }
    
    /**
     * @return int
     */
    public function noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll()
    {
        return $this->stats->noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll;
    }
    
    /**
     * @return int
     */
    public function someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll()
    {
        return $this->stats->someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll;
    }
}