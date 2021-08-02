<?php

namespace App\Repositories\Common\Lesson;

use App\Repositories\InterfaceRepository;

interface LessonRepository extends InterfaceRepository
{
    const STATUS_NEW = 1;
    const STATUS_STARTED = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_MISSED = 4;
    const STATUS_CANCELED = 5;
}
