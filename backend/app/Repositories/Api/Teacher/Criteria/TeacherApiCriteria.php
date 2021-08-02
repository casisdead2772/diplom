<?php


namespace App\Repositories\Api\Teacher\Criteria;


use App\Repositories\Api\Quiz\Filter\QuizApiFilter;
use App\Repositories\Api\Teacher\Filter\TeacherApiFilter;
use App\Repositories\Criteria\AbstractCriteria;

class TeacherApiCriteria extends AbstractCriteria
{
    private TeacherApiFilter $teacherApiFilter;

    /**
     * UserCriteria constructor.
     * @param TeacherApiFilter $teacherApiFilter
     */
    public function __construct(TeacherApiFilter $teacherApiFilter)
    {
        parent::__construct($teacherApiFilter);
    }

}
