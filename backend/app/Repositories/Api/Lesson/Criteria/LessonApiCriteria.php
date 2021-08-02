<?php

namespace App\Repositories\Api\Lesson\Criteria;

use App\Repositories\Api\Lesson\Filter\LessonApiFilter;
use App\Repositories\Criteria\AbstractCriteria;

class LessonApiCriteria extends AbstractCriteria
{
    private LessonApiFilter $lessonFilter;

    /**
     * UserCriteria constructor.
     * @param LessonApiFilter $lessonFilter
     */
    public function __construct(LessonApiFilter $lessonFilter)
    {
        parent::__construct($lessonFilter);
    }
}