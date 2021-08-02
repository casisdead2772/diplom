<?php


namespace App\Repositories\Api\Teacher\Filter;
use App\Repositories\Filter\AbstractFilter;

class TeacherApiFilter extends AbstractFilter
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
