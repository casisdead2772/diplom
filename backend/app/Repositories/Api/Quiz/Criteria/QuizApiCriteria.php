<?php

namespace App\Repositories\Api\Quiz\Criteria;

use App\Repositories\Api\Quiz\Filter\QuizApiFilter;
use App\Repositories\Criteria\AbstractCriteria;

class QuizApiCriteria extends AbstractCriteria
{
    private QuizApiFilter $quizFilter;

    /**
     * UserCriteria constructor.
     * @param QuizApiFilter $quizFilter
     */
    public function __construct(QuizApiFilter $quizFilter)
    {
        parent::__construct($quizFilter);
    }
}
