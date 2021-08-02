<?php

namespace App\Repositories\Api\Lesson;

use App\Entities\User;
use App\Repositories\Api\Lesson\Filter\LessonApiFilter;
use App\Repositories\Common\Lesson\LessonRepository;

interface LessonApiRepository extends LessonRepository
{
    public function findAllByWithPaginated(User $user, LessonApiFilter $filter);
}
