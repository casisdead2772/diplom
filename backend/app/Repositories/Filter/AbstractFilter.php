<?php

namespace App\Repositories\Filter;

use Illuminate\Support\Arr;

abstract class AbstractFilter
{
    private ?int $page;
    private ?int $limit;

    private string $sort;

    private ?int $fromDate;
    private ?int $toDate;

    /**
     * AbstractFilter constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->page = Arr::get($data, 'page', 1);
        $this->limit = Arr::get($data, 'limit', 25);
        $this->fromDate = Arr::get($data, 'from_date', null);
        $this->toDate = Arr::get($data, 'to_date', null);
        $this->sort = Arr::get($data, 'sort', 'id');
    }

    /**
     * @return array|\ArrayAccess|int|mixed|null
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return array|\ArrayAccess|int|mixed|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return array|\ArrayAccess|int|mixed|null
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @return array|\ArrayAccess|int|mixed|null
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }
}
