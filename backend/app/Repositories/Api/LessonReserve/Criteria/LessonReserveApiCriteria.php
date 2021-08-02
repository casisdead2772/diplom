<?php

namespace App\Repositories\Api\LessonReserve\Criteria;

use App\Repositories\Api\LessonReserve\Filter\LessonReserveApiFilter;
use App\Repositories\Criteria\AbstractCriteria;

class LessonReserveApiCriteria extends AbstractCriteria
{
    private LessonReserveApiFilter $lessonReserveFilter;

    /**
     * UserCriteria constructor.
     * @param LessonReserveApiFilter $lessonReserveFilter
     */
    public function __construct(LessonReserveApiFilter $lessonReserveFilter)
    {
        parent::__construct($lessonReserveFilter);
    }
}