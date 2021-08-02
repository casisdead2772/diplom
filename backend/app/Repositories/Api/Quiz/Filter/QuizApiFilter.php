<?php

namespace App\Repositories\Api\Quiz\Filter;

use App\Repositories\Filter\AbstractFilter;

class QuizApiFilter extends AbstractFilter
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
