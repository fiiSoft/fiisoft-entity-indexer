<?php

namespace FiiSoft\EntityIndexer\MapStats;

interface EntityMapStatsView
{
    /**
     * Reset (clear) stats and start counting from zero.
     *
     * @return void
     */
    public function clear();
    
    /**
     * @return int
     */
    public function foundByKeyTotal();
    
    /**
     * @return int
     */
    public function notFoundByKeyTotal();
    
    /**
     * @return int
     */
    public function findOneFailed();
    
    /**
     * @return int
     */
    public function searchInUniqueOne();
    
    /**
     * @return int
     */
    public function notFoundInUniqueOne();
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueOne();
    
    /**
     * @return int
     */
    public function candidateOfUniqueOneDoesNotMatch();
    
    /**
     * @return int
     */
    public function findOneSucceeded();
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueOne();
    
    /**
     * @return int
     */
    public function candidateOfUniqueOneMatches();
    
    /**
     * @return int
     */
    public function impossibleToMatchForUniqueOne();
    
    /**
     * @return int
     */
    public function missedFindOneUniqueTwo();
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueTwo();
    
    /**
     * @return int
     */
    public function searchInUniqueTwo();
    
    /**
     * @return int
     */
    public function notFoundOneInCollection();
    
    /**
     * @return int
     */
    public function candidateOfUniqueTwoMatches();
    
    /**
     * @return int
     */
    public function foundOneInCollection();
    
    /**
     * @return int
     */
    public function candidateOfUniqueTwoDoesNotMatch();
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueTwo();
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueTwo();
    
    /**
     * @return int
     */
    public function searchInUniqueThree();
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueThree();
    
    /**
     * @return int
     */
    public function missedFindOneUniqueThree();
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueThree();
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueThree();
    
    /**
     * @return int
     */
    public function candidateOfUniqueThreeMatches();
    
    /**
     * @return int
     */
    public function candidateOfUniqueThreeDoesNotMatch();
    
    /**
     * @return int
     */
    public function searchInUniqueFour();
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForUniqueFour();
    
    /**
     * @return int
     */
    public function missedFindOneUniqueFour();
    
    /**
     * @return int
     */
    public function ambiguousFoundInUniqueFour();
    
    /**
     * @return int
     */
    public function strictFoundOneInUniqueFour();
    
    /**
     * @return int
     */
    public function candidateOfUniqueFourMatches();
    
    /**
     * @return int
     */
    public function candidateOfUniqueFourDoesNotMatch();
    
    /**
     * @return int
     */
    public function searchInMultipleFour();
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleFour();
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleFour();
    
    /**
     * @return int
     */
    public function searchInMultipleThree();
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleThree();
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleThree();
    
    /**
     * @return int
     */
    public function searchInMultipleTwo();
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleTwo();
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleTwo();
    
    /**
     * @return int
     */
    public function searchInMultipleOne();
    
    /**
     * @return int
     */
    public function conditionsNotCompleteForMultipleOne();
    
    /**
     * @return int
     */
    public function impossibleToMatchForMultipleOne();
    
    /**
     * @return int
     */
    public function noWinnersFromMultipleCandidatesInFindOne();
    
    /**
     * @return int
     */
    public function winnerStrictFromMultipleCandidatesInFindOne();
    
    /**
     * @return int
     */
    public function winnerFromMultipleCandidatesSatisfiesConditionsInFindOne();
    
    /**
     * @return int
     */
    public function winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne();
    
    /**
     * @return int
     */
    public function findAllFailed();
    
    /**
     * @return int
     */
    public function searchAllInUniqueOne();
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInUniqueOne();
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueOne();
    
    /**
     * @return int
     */
    public function findAllSucceeded();
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueOne();
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueOneMatches();
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueOneDoesNotMatch();
    
    /**
     * @return int
     */
    public function notFoundAllInUniqueOne();
    
    /**
     * @return int
     */
    public function searchAllInUniqueTwo();
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueTwo();
    
    /**
     * @return int
     */
    public function missedFindAllUniqueTwo();
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueTwo();
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueTwo();
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueTwoMatches();
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueTwoDoesNotMatch();
    
    /**
     * @return int
     */
    public function searchAllInUniqueThree();
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueThree();
    
    /**
     * @return int
     */
    public function missedFindAllUniqueThree();
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueThree();
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueThree();
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueThreeMatches();
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueThreeDoesNotMatch();
    
    /**
     * @return int
     */
    public function searchAllInUniqueFour();
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInUniqueFour();
    
    /**
     * @return int
     */
    public function missedFindAllUniqueFour();
    
    /**
     * @return int
     */
    public function ambiguousFoundForAllInUniqueFour();
    
    /**
     * @return int
     */
    public function strictFoundAllInUniqueFour();
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueFourMatches();
    
    /**
     * @return int
     */
    public function candidateForAllOfUniqueFourDoesNotMatch();
    
    /**
     * @return int
     */
    public function searchAllInMultipleFour();
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleFour();
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleFour();
    
    /**
     * @return int
     */
    public function searchAllInMultipleThree();
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleThree();
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleThree();
    
    /**
     * @return int
     */
    public function searchAllInMultipleTwo();
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleTwo();
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleTwo();
    
    /**
     * @return int
     */
    public function searchAllInMultipleOne();
    
    /**
     * @return int
     */
    public function conditionsForAllNotCompleteInMultipleOne();
    
    /**
     * @return int
     */
    public function impossibleToMatchForAllInMultipleOne();
    
    /**
     * @return int
     */
    public function notFoundAnyInCollection();
    
    /**
     * @return int
     */
    public function foundSomeInCollection();
    
    /**
     * @return int
     */
    public function noWinnersFromMultipleCandidatesInFindAll();
    
    /**
     * @return int
     */
    public function winnerStrictFromMultipleCandidatesInFindAll();
    
    /**
     * @return int
     */
    public function noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll();
    
    /**
     * @return int
     */
    public function someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll();
}