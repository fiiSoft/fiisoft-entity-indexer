<?php

namespace FiiSoft\EntityIndexer\MapStats;

final class EntityMapStats
{
    /** @var array <string => int> */
    public $foundByKey = [];
    
    /** @var array <string => int> */
    public $notFoundByKey = [];
    
    /** @var int */
    public $foundByKeyTotal = 0;
    
    /** @var int */
    public $notFoundByKeyTotal = 0;
    
    /** @var int */
    public $findOneFailed = 0;
    
    /** @var int */
    public $searchInUniqueOne = 0;
    
    /** @var int */
    public $notFoundInUniqueOne = 0;
    
    /** @var int */
    public $ambiguousFoundInUniqueOne = 0;
    
    /** @var int */
    public $candidateOfUniqueOneDoesNotMatch = 0;
    
    /** @var int */
    public $findOneSucceeded = 0;
    
    /** @var int */
    public $strictFoundOneInUniqueOne = 0;
    
    /** @var int */
    public $candidateOfUniqueOneMatches = 0;
    
    /** @var int */
    public $foundOneInCollection = 0;
    
    /** @var int */
    public $notFoundOneInCollection = 0;
    
    /** @var int */
    public $impossibleToMatchForUniqueOne = 0;
    
    /** @var int */
    public $missedFindOneUniqueTwo = 0;
    
    /** @var int */
    public $ambiguousFoundInUniqueTwo = 0;
    
    /** @var int */
    public $searchInUniqueTwo = 0;
    
    /** @var int */
    public $candidateOfUniqueTwoMatches = 0;
    
    /** @var int */
    public $candidateOfUniqueTwoDoesNotMatch = 0;
    
    /** @var int */
    public $conditionsNotCompleteForUniqueTwo = 0;
    
    /** @var int */
    public $strictFoundOneInUniqueTwo = 0;
    
    /** @var int */
    public $searchInUniqueThree = 0;
    
    /** @var int */
    public $conditionsNotCompleteForUniqueThree = 0;
    
    /** @var int */
    public $missedFindOneUniqueThree = 0;
    
    /** @var int */
    public $ambiguousFoundInUniqueThree = 0;
    
    /** @var int */
    public $strictFoundOneInUniqueThree = 0;
    
    /** @var int */
    public $candidateOfUniqueThreeMatches = 0;
    
    /** @var int */
    public $candidateOfUniqueThreeDoesNotMatch = 0;
    
    /** @var int */
    public $searchInUniqueFour = 0;
    
    /** @var int */
    public $conditionsNotCompleteForUniqueFour = 0;
    
    /** @var int */
    public $missedFindOneUniqueFour = 0;
    
    /** @var int */
    public $ambiguousFoundInUniqueFour = 0;
    
    /** @var int */
    public $strictFoundOneInUniqueFour = 0;
    
    /** @var int */
    public $candidateOfUniqueFourMatches = 0;
    
    /** @var int */
    public $candidateOfUniqueFourDoesNotMatch = 0;
    
    /** @var int */
    public $searchInMultipleFour = 0;
    
    /** @var int */
    public $conditionsNotCompleteForMultipleFour = 0;
    
    /** @var int */
    public $impossibleToMatchForMultipleFour = 0;
    
    /** @var int */
    public $searchInMultipleThree = 0;
    
    /** @var int */
    public $conditionsNotCompleteForMultipleThree = 0;
    
    /** @var int */
    public $impossibleToMatchForMultipleThree = 0;
    
    /** @var int */
    public $searchInMultipleTwo = 0;
    
    /** @var int */
    public $conditionsNotCompleteForMultipleTwo = 0;
    
    /** @var int */
    public $impossibleToMatchForMultipleTwo = 0;
    
    /** @var int */
    public $searchInMultipleOne = 0;
    
    /** @var int */
    public $conditionsNotCompleteForMultipleOne = 0;
    
    /** @var int */
    public $impossibleToMatchForMultipleOne = 0;
    
    /** @var int */
    public $noWinnersFromMultipleCandidatesInFindOne = 0;
    
    /** @var int */
    public $winnerStrictFromMultipleCandidatesInFindOne = 0;
    
    /** @var int */
    public $winnerFromMultipleCandidatesSatisfiesConditionsInFindOne = 0;
    
    /** @var int */
    public $winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne = 0;
    
    /** @var int */
    public $findAllFailed = 0;
    
    /** @var int */
    public $searchAllInUniqueOne = 0;
    
    /** @var int */
    public $impossibleToMatchForAllInUniqueOne = 0;
    
    /** @var int */
    public $ambiguousFoundForAllInUniqueOne = 0;
    
    /** @var int */
    public $strictFoundAllInUniqueOne = 0;
    
    /** @var int */
    public $findAllSucceeded = 0;
    
    /** @var int */
    public $candidateForAllOfUniqueOneMatches = 0;
    
    /** @var int */
    public $candidateForAllOfUniqueOneDoesNotMatch = 0;
    
    /** @var int */
    public $notFoundAllInUniqueOne = 0;
    
    /** @var int */
    public $searchAllInUniqueTwo = 0;
    
    /** @var int */
    public $conditionsForAllNotCompleteInUniqueTwo = 0;
    
    /** @var int */
    public $missedFindAllUniqueTwo = 0;
    
    /** @var int */
    public $ambiguousFoundForAllInUniqueTwo = 0;
    
    /** @var int */
    public $strictFoundAllInUniqueTwo = 0;
    
    /** @var int */
    public $candidateForAllOfUniqueTwoMatches = 0;
    
    /** @var int */
    public $candidateForAllOfUniqueTwoDoesNotMatch = 0;
    
    /** @var int */
    public $searchAllInUniqueThree = 0;
    
    /** @var int */
    public $conditionsForAllNotCompleteInUniqueThree = 0;
    
    /** @var int */
    public $missedFindAllUniqueThree = 0;
    
    /** @var int */
    public $ambiguousFoundForAllInUniqueThree = 0;
    
    /** @var int */
    public $strictFoundAllInUniqueThree = 0;
    
    /** @var int */
    public $candidateForAllOfUniqueThreeMatches = 0;
    
    /** @var int */
    public $candidateForAllOfUniqueThreeDoesNotMatch = 0;
    
    /** @var int */
    public $searchAllInUniqueFour = 0;
    
    /** @var int */
    public $conditionsForAllNotCompleteInUniqueFour = 0;
    
    /** @var int */
    public $missedFindAllUniqueFour = 0;
    
    /** @var int */
    public $ambiguousFoundForAllInUniqueFour = 0;
    
    /** @var int */
    public $strictFoundAllInUniqueFour = 0;
    
    /** @var int */
    public $candidateForAllOfUniqueFourMatches = 0;
    
    /** @var int */
    public $candidateForAllOfUniqueFourDoesNotMatch = 0;
    
    /** @var int */
    public $searchAllInMultipleFour = 0;
    
    /** @var int */
    public $conditionsForAllNotCompleteInMultipleFour = 0;
    
    /** @var int */
    public $impossibleToMatchForAllInMultipleFour = 0;
    
    /** @var int */
    public $searchAllInMultipleThree = 0;
    
    /** @var int */
    public $conditionsForAllNotCompleteInMultipleThree = 0;
    
    /** @var int */
    public $impossibleToMatchForAllInMultipleThree = 0;
    
    /** @var int */
    public $searchAllInMultipleTwo = 0;
    
    /** @var int */
    public $conditionsForAllNotCompleteInMultipleTwo = 0;
    
    /** @var int */
    public $impossibleToMatchForAllInMultipleTwo = 0;
    
    /** @var int */
    public $searchAllInMultipleOne = 0;
    
    /** @var int */
    public $conditionsForAllNotCompleteInMultipleOne = 0;
    
    /** @var int */
    public $impossibleToMatchForAllInMultipleOne = 0;
    
    /** @var int */
    public $notFoundAnyInCollection = 0;
    
    /** @var int */
    public $foundSomeInCollection = 0;
    
    /** @var int */
    public $noWinnersFromMultipleCandidatesInFindAll = 0;
    
    /** @var int */
    public $winnerStrictFromMultipleCandidatesInFindAll = 0;
    
    /** @var int */
    public $noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll = 0;
    
    /** @var int */
    public $someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll = 0;
    
    /**
     * Clear stats.
     *
     * @return void
     */
    public function clear()
    {
        $this->foundByKey = [];
        $this->notFoundByKey = [];
        $this->foundByKeyTotal = 0;
        $this->notFoundByKeyTotal = 0;
        $this->findOneFailed = 0;
        $this->searchInUniqueOne = 0;
        $this->notFoundInUniqueOne = 0;
        $this->ambiguousFoundInUniqueOne = 0;
        $this->candidateOfUniqueOneDoesNotMatch = 0;
        $this->strictFoundOneInUniqueOne = 0;
        $this->findOneSucceeded = 0;
        $this->candidateOfUniqueOneMatches = 0;
        $this->foundOneInCollection = 0;
        $this->notFoundOneInCollection = 0;
        $this->impossibleToMatchForUniqueOne = 0;
        $this->missedFindOneUniqueTwo = 0;
        $this->ambiguousFoundInUniqueTwo = 0;
        $this->searchInUniqueTwo = 0;
        $this->candidateOfUniqueTwoMatches = 0;
        $this->candidateOfUniqueTwoDoesNotMatch = 0;
        $this->conditionsNotCompleteForUniqueTwo = 0;
        $this->strictFoundOneInUniqueTwo = 0;
        $this->searchInUniqueThree = 0;
        $this->conditionsNotCompleteForUniqueThree = 0;
        $this->missedFindOneUniqueThree = 0;
        $this->ambiguousFoundInUniqueThree = 0;
        $this->strictFoundOneInUniqueThree = 0;
        $this->candidateOfUniqueThreeMatches = 0;
        $this->candidateOfUniqueThreeDoesNotMatch = 0;
        $this->searchInUniqueFour = 0;
        $this->conditionsNotCompleteForUniqueFour = 0;
        $this->missedFindOneUniqueFour = 0;
        $this->ambiguousFoundInUniqueFour = 0;
        $this->strictFoundOneInUniqueFour = 0;
        $this->candidateOfUniqueFourMatches = 0;
        $this->candidateOfUniqueFourDoesNotMatch = 0;
        $this->searchInMultipleFour = 0;
        $this->conditionsNotCompleteForMultipleFour = 0;
        $this->impossibleToMatchForMultipleFour = 0;
        $this->searchInMultipleThree = 0;
        $this->conditionsNotCompleteForMultipleThree = 0;
        $this->impossibleToMatchForMultipleThree = 0;
        $this->searchInMultipleTwo = 0;
        $this->conditionsNotCompleteForMultipleTwo = 0;
        $this->impossibleToMatchForMultipleTwo = 0;
        $this->searchInMultipleOne = 0;
        $this->conditionsNotCompleteForMultipleOne = 0;
        $this->impossibleToMatchForMultipleOne = 0;
        $this->noWinnersFromMultipleCandidatesInFindOne = 0;
        $this->winnerStrictFromMultipleCandidatesInFindOne = 0;
        $this->winnerFromMultipleCandidatesSatisfiesConditionsInFindOne = 0;
        $this->winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne = 0;
        $this->findAllFailed = 0;
        $this->searchAllInUniqueOne = 0;
        $this->impossibleToMatchForAllInUniqueOne = 0;
        $this->ambiguousFoundForAllInUniqueOne = 0;
        $this->strictFoundAllInUniqueOne = 0;
        $this->findAllSucceeded = 0;
        $this->candidateForAllOfUniqueOneMatches = 0;
        $this->candidateForAllOfUniqueOneDoesNotMatch = 0;
        $this->notFoundAllInUniqueOne = 0;
        $this->searchAllInUniqueTwo = 0;
        $this->conditionsForAllNotCompleteInUniqueTwo = 0;
        $this->missedFindAllUniqueTwo = 0;
        $this->ambiguousFoundForAllInUniqueTwo = 0;
        $this->strictFoundAllInUniqueTwo = 0;
        $this->candidateForAllOfUniqueTwoMatches = 0;
        $this->candidateForAllOfUniqueTwoDoesNotMatch = 0;
        $this->searchAllInUniqueThree = 0;
        $this->conditionsForAllNotCompleteInUniqueThree = 0;
        $this->missedFindAllUniqueThree = 0;
        $this->ambiguousFoundForAllInUniqueThree = 0;
        $this->strictFoundAllInUniqueThree = 0;
        $this->candidateForAllOfUniqueThreeMatches = 0;
        $this->candidateForAllOfUniqueThreeDoesNotMatch = 0;
        $this->searchAllInUniqueFour = 0;
        $this->conditionsForAllNotCompleteInUniqueFour = 0;
        $this->missedFindAllUniqueFour = 0;
        $this->ambiguousFoundForAllInUniqueFour = 0;
        $this->strictFoundAllInUniqueFour = 0;
        $this->candidateForAllOfUniqueFourMatches = 0;
        $this->candidateForAllOfUniqueFourDoesNotMatch = 0;
        $this->searchAllInMultipleFour = 0;
        $this->conditionsForAllNotCompleteInMultipleFour = 0;
        $this->impossibleToMatchForAllInMultipleFour = 0;
        $this->searchAllInMultipleThree = 0;
        $this->conditionsForAllNotCompleteInMultipleThree = 0;
        $this->impossibleToMatchForAllInMultipleThree = 0;
        $this->searchAllInMultipleTwo = 0;
        $this->conditionsForAllNotCompleteInMultipleTwo = 0;
        $this->impossibleToMatchForAllInMultipleTwo = 0;
        $this->searchAllInMultipleOne = 0;
        $this->conditionsForAllNotCompleteInMultipleOne = 0;
        $this->impossibleToMatchForAllInMultipleOne = 0;
        $this->notFoundAnyInCollection = 0;
        $this->foundSomeInCollection = 0;
        $this->noWinnersFromMultipleCandidatesInFindAll = 0;
        $this->winnerStrictFromMultipleCandidatesInFindAll = 0;
        $this->noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll = 0;
        $this->someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll = 0;
    }
    
    /**
     * @param string|int $key
     * @return void
     */
    public function foundByKey($key)
    {
        ++$this->foundByKeyTotal;

        if (isset($this->foundByKey[$key])) {
            ++$this->foundByKey[$key];
        } else {
            $this->foundByKey[$key] = 1;
        }
    }

    /**
     * @param string|int $key
     * @return void
     */
    public function notFoundByKey($key)
    {
        ++$this->notFoundByKeyTotal;

        if (isset($this->notFoundByKey[$key])) {
            ++$this->notFoundByKey[$key];
        } else {
            $this->notFoundByKey[$key] = 1;
        }
    }

    /**
     * @return void
     */
    public function findOneFailed()
    {
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function searchInUniqueOne()
    {
        ++$this->searchInUniqueOne;
    }

    /**
     * @return void
     */
    public function notFoundInUniqueOne()
    {
        ++$this->notFoundInUniqueOne;
    }

    /**
     * @return void
     */
    public function ambiguousFoundInUniqueOne()
    {
        ++$this->ambiguousFoundInUniqueOne;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function candidateOfUniqueOneDoesNotMatch()
    {
        ++$this->candidateOfUniqueOneDoesNotMatch;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function strictFoundOneInUniqueOne()
    {
        ++$this->strictFoundOneInUniqueOne;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function candidateOfUniqueOneMatches()
    {
        ++$this->candidateOfUniqueOneMatches;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function foundOneInCollection()
    {
        ++$this->foundOneInCollection;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function notFoundOneInCollection()
    {
        ++$this->notFoundOneInCollection;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForUniqueOne()
    {
        ++$this->impossibleToMatchForUniqueOne;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function missedFindOneUniqueTwo()
    {
        ++$this->missedFindOneUniqueTwo;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function ambiguousFoundInUniqueTwo()
    {
        ++$this->ambiguousFoundInUniqueTwo;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function searchInUniqueTwo()
    {
        ++$this->searchInUniqueTwo;
    }

    /**
     * @return void
     */
    public function candidateOfUniqueTwoMatches()
    {
        ++$this->candidateOfUniqueTwoMatches;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function candidateOfUniqueTwoDoesNotMatch()
    {
        ++$this->candidateOfUniqueTwoDoesNotMatch;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function conditionsNotCompleteForUniqueTwo()
    {
        ++$this->conditionsNotCompleteForUniqueTwo;
    }

    /**
     * @return void
     */
    public function strictFoundOneInUniqueTwo()
    {
        ++$this->strictFoundOneInUniqueTwo;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function searchInUniqueThree()
    {
        ++$this->searchInUniqueThree;
    }

    /**
     * @return void
     */
    public function conditionsNotCompleteForUniqueThree()
    {
        ++$this->conditionsNotCompleteForUniqueThree;
    }

    /**
     * @return void
     */
    public function missedFindOneUniqueThree()
    {
        ++$this->missedFindOneUniqueThree;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function ambiguousFoundInUniqueThree()
    {
        ++$this->ambiguousFoundInUniqueThree;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function strictFoundOneInUniqueThree()
    {
        ++$this->strictFoundOneInUniqueThree;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function candidateOfUniqueThreeMatches()
    {
        ++$this->candidateOfUniqueThreeMatches;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function candidateOfUniqueThreeDoesNotMatch()
    {
        ++$this->candidateOfUniqueThreeDoesNotMatch;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function searchInUniqueFour()
    {
        ++$this->searchInUniqueFour;
    }

    /**
     * @return void
     */
    public function conditionsNotCompleteForUniqueFour()
    {
        ++$this->conditionsNotCompleteForUniqueFour;
    }

    /**
     * @return void
     */
    public function missedFindOneUniqueFour()
    {
        ++$this->missedFindOneUniqueFour;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function ambiguousFoundInUniqueFour()
    {
        ++$this->ambiguousFoundInUniqueFour;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function strictFoundOneInUniqueFour()
    {
        ++$this->strictFoundOneInUniqueFour;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function candidateOfUniqueFourMatches()
    {
        ++$this->candidateOfUniqueFourMatches;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function candidateOfUniqueFourDoesNotMatch()
    {
        ++$this->candidateOfUniqueFourDoesNotMatch;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function searchInMultipleFour()
    {
        ++$this->searchInMultipleFour;
    }

    /**
     * @return void
     */
    public function conditionsNotCompleteForMultipleFour()
    {
        ++$this->conditionsNotCompleteForMultipleFour;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForMultipleFour()
    {
        ++$this->impossibleToMatchForMultipleFour;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function searchInMultipleThree()
    {
        ++$this->searchInMultipleThree;
    }

    /**
     * @return void
     */
    public function conditionsNotCompleteForMultipleThree()
    {
        ++$this->conditionsNotCompleteForMultipleThree;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForMultipleThree()
    {
        ++$this->impossibleToMatchForMultipleThree;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function searchInMultipleTwo()
    {
        ++$this->searchInMultipleTwo;
    }

    /**
     * @return void
     */
    public function conditionsNotCompleteForMultipleTwo()
    {
        ++$this->conditionsNotCompleteForMultipleTwo;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForMultipleTwo()
    {
        ++$this->impossibleToMatchForMultipleTwo;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function searchInMultipleOne()
    {
        ++$this->searchInMultipleOne;
    }

    /**
     * @return void
     */
    public function conditionsNotCompleteForMultipleOne()
    {
        ++$this->conditionsNotCompleteForMultipleOne;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForMultipleOne()
    {
        ++$this->impossibleToMatchForMultipleOne;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function noWinnersFromMultipleCandidatesInFindOne()
    {
        ++$this->noWinnersFromMultipleCandidatesInFindOne;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function winnerStrictFromMultipleCandidatesInFindOne()
    {
        ++$this->winnerStrictFromMultipleCandidatesInFindOne;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function winnerFromMultipleCandidatesSatisfiesConditionsInFindOne()
    {
        ++$this->winnerFromMultipleCandidatesSatisfiesConditionsInFindOne;
        ++$this->findOneSucceeded;
    }

    /**
     * @return void
     */
    public function winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne()
    {
        ++$this->winnerFromMultipleCandidatesDoesNotSatisfyConditionsInFindOne;
        ++$this->findOneFailed;
    }

    /**
     * @return void
     */
    public function findAllFailed()
    {
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function searchAllInUniqueOne()
    {
        ++$this->searchAllInUniqueOne;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForAllInUniqueOne()
    {
        ++$this->impossibleToMatchForAllInUniqueOne;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function ambiguousFoundForAllInUniqueOne()
    {
        ++$this->ambiguousFoundForAllInUniqueOne;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function strictFoundAllInUniqueOne()
    {
        ++$this->strictFoundAllInUniqueOne;
        ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function candidateForAllOfUniqueOneMatches()
    {
        ++$this->candidateForAllOfUniqueOneMatches;
        ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function candidateForAllOfUniqueOneDoesNotMatch()
    {
        ++$this->candidateForAllOfUniqueOneDoesNotMatch;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function notFoundAllInUniqueOne()
    {
        ++$this->notFoundAllInUniqueOne;
    }

    /**
     * @return void
     */
    public function searchAllInUniqueTwo()
    {
        ++$this->searchAllInUniqueTwo;
    }

    /**
     * @return void
     */
    public function conditionsForAllNotCompleteInUniqueTwo()
    {
        ++$this->conditionsForAllNotCompleteInUniqueTwo;
    }

    /**
     * @return void
     */
    public function missedFindAllUniqueTwo()
    {
        ++$this->missedFindAllUniqueTwo;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function ambiguousFoundForAllInUniqueTwo()
    {
        ++$this->ambiguousFoundForAllInUniqueTwo;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function strictFoundAllInUniqueTwo()
    {
        ++$this->strictFoundAllInUniqueTwo;
        ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function candidateForAllOfUniqueTwoMatches()
    {
        ++$this->candidateForAllOfUniqueTwoMatches;
        ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function candidateForAllOfUniqueTwoDoesNotMatch()
    {
        ++$this->candidateForAllOfUniqueTwoDoesNotMatch;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function searchAllInUniqueThree()
    {
        ++$this->searchAllInUniqueThree;
    }

    /**
     * @return void
     */
    public function conditionsForAllNotCompleteInUniqueThree()
    {
        ++$this->conditionsForAllNotCompleteInUniqueThree;
    }

    /**
     * @return void
     */
    public function missedFindAllUniqueThree()
    {
        ++$this->missedFindAllUniqueThree;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function ambiguousFoundForAllInUniqueThree()
    {
        ++$this->ambiguousFoundForAllInUniqueThree;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function strictFoundAllInUniqueThree()
    {
        ++$this->strictFoundAllInUniqueThree;
        ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function candidateForAllOfUniqueThreeMatches()
    {
        ++$this->candidateForAllOfUniqueThreeMatches;
        ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function candidateForAllOfUniqueThreeDoesNotMatch()
    {
        ++$this->candidateForAllOfUniqueThreeDoesNotMatch;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function searchAllInUniqueFour()
    {
        ++$this->searchAllInUniqueFour;
    }

    /**
     * @return void
     */
    public function conditionsForAllNotCompleteInUniqueFour()
    {
        ++$this->conditionsForAllNotCompleteInUniqueFour;
    }

    /**
     * @return void
     */
    public function missedFindAllUniqueFour()
    {
        ++$this->missedFindAllUniqueFour;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function ambiguousFoundForAllInUniqueFour()
    {
        ++$this->ambiguousFoundForAllInUniqueFour;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function strictFoundAllInUniqueFour()
    {
        ++$this->strictFoundAllInUniqueFour;
        ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function candidateForAllOfUniqueFourMatches()
    {
        ++$this->candidateForAllOfUniqueFourMatches;
        ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function candidateForAllOfUniqueFourDoesNotMatch()
    {
        ++$this->candidateForAllOfUniqueFourDoesNotMatch;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function searchAllInMultipleFour()
    {
        ++$this->searchAllInMultipleFour;
    }

    /**
     * @return void
     */
    public function conditionsForAllNotCompleteInMultipleFour()
    {
        ++$this->conditionsForAllNotCompleteInMultipleFour;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForAllInMultipleFour()
    {
        ++$this->impossibleToMatchForAllInMultipleFour;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function searchAllInMultipleThree()
    {
        ++$this->searchAllInMultipleThree;
    }

    /**
     * @return void
     */
    public function conditionsForAllNotCompleteInMultipleThree()
    {
        ++$this->conditionsForAllNotCompleteInMultipleThree;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForAllInMultipleThree()
    {
        ++$this->impossibleToMatchForAllInMultipleThree;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function searchAllInMultipleTwo()
    {
        ++$this->searchAllInMultipleTwo;
    }

    /**
     * @return void
     */
    public function conditionsForAllNotCompleteInMultipleTwo()
    {
        ++$this->conditionsForAllNotCompleteInMultipleTwo;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForAllInMultipleTwo()
    {
        ++$this->impossibleToMatchForAllInMultipleTwo;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function searchAllInMultipleOne()
    {
        ++$this->searchAllInMultipleOne;
    }

    /**
     * @return void
     */
    public function conditionsForAllNotCompleteInMultipleOne()
    {
        ++$this->conditionsForAllNotCompleteInMultipleOne;
    }

    /**
     * @return void
     */
    public function impossibleToMatchForAllInMultipleOne()
    {
        ++$this->impossibleToMatchForAllInMultipleOne;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function notFoundAnyInCollection()
    {
        ++$this->notFoundAnyInCollection;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function foundSomeInCollection()
    {
       ++$this->foundSomeInCollection;
       ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function noWinnersFromMultipleCandidatesInFindAll()
    {
        ++$this->noWinnersFromMultipleCandidatesInFindAll;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function winnerStrictFromMultipleCandidatesInFindAll()
    {
        ++$this->winnerStrictFromMultipleCandidatesInFindAll;
        ++$this->findAllSucceeded;
    }

    /**
     * @return void
     */
    public function noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll()
    {
        ++$this->noWinnerFromMultipleCandidatesSatisfiesConditionsInFindAll;
        ++$this->findAllFailed;
    }

    /**
     * @return void
     */
    public function someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll()
    {
        ++$this->someWinnersFromMultipleCandidatesSatisfiesConditionsInFindAll;
        ++$this->findAllSucceeded;
    }
}
