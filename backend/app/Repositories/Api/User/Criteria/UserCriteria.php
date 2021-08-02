<?php

namespace App\Repositories\Api\User\Criteria;

use App\Repositories\Api\User\Filter\UserFilter;
use App\Repositories\Criteria\AbstractCriteria;
use Doctrine\Common\Collections\Criteria;

class UserCriteria extends AbstractCriteria
{
    private UserFilter $userFilter;

    /**
     * UserCriteria constructor.
     * @param UserFilter $userFilter
     */
    public function __construct(UserFilter $userFilter)
    {
        $expr = Criteria::expr();
        $criteria = Criteria::create();
        parent::__construct($expr, $criteria, $userFilter);
        $this->userFilter = $userFilter;
    }
}