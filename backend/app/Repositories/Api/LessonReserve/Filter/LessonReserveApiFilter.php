<?php

namespace App\Repositories\Api\LessonReserve\Filter;

use App\Repositories\Filter\AbstractFilter;

class LessonReserveApiFilter extends AbstractFilter
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