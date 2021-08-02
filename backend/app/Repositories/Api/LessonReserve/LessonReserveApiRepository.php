<?php

namespace App\Repositories\Api\LessonReserve;

use App\Entities\User;
use App\Repositories\Api\LessonReserve\Filter\LessonReserveApiFilter;
use App\Repositories\Common\LessonReserve\LessonReserveRepository;

interface LessonReserveApiRepository extends LessonReserveRepository
{
    public function findAllByWithPaginated(User $user, LessonReserveApiFilter $filter);
    public function findReservedCount(User $user);
}
