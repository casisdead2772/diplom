<?php

namespace App\Repositories\Common\LessonReserve;

use App\Repositories\InterfaceRepository;

interface LessonReserveRepository extends InterfaceRepository
{
    const STATUS_NEW = 1;
    const STATUS_APPROVED = 2;
    const STATUS_CANCELED = 3;
}
