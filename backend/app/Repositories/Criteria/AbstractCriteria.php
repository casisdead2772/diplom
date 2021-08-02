<?php

namespace App\Repositories\Criteria;

use App\Repositories\Filter\AbstractFilter;

abstract class AbstractCriteria
{
    protected AbstractFilter $filter;

    /**
     * AbstractCriteria constructor.
     * @param \App\Repositories\Filter\AbstractFilter $filter
     */
    public function __construct(AbstractFilter $filter)
    {
        $this->filter = $filter;
    }
}
