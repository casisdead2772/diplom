<?php

namespace App\Repositories\Api\Lesson\Filter;

use App\Repositories\Filter\AbstractFilter;

class LessonApiFilter extends AbstractFilter
{
    /**
     * UserFilter constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
    }
}