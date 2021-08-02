<?php

namespace App\Repositories\Api\Teacher;

use App\Repositories\Api\Teacher\Filter\TeacherApiFilter;
use App\Repositories\Api\Teacher\Filter\TeacherFilter;
use App\Repositories\Common\Teacher\TeacherRepository;
use Illuminate\Http\Request;

interface TeacherApiRepository extends TeacherRepository
{
    public function findTeachersWithPaginate(TeacherFilter $teacherFilter);
    public function findAllTeachers();
}
