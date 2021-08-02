<?php

namespace App\Repositories\Api\Teacher\Filter;

use App\Repositories\Filter\AbstractFilter;
use Illuminate\Support\Arr;

class TeacherFilter extends AbstractFilter
{
    protected int $subjectId;
    protected int $pricePerHourFrom;
    protected int $pricePerHourTo;
    protected ?array $countryIds;

    /**
     * UserFilter constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->subjectId = Arr::get($data, 'subject_id');
        $this->pricePerHourFrom = Arr::get($data, 'price_per_hour_from');
        $this->pricePerHourTo = Arr::get($data, 'price_per_hour_to');
        $this->countryIds = Arr::get($data, 'country_id', null);
    }

    public function getSubjectId()
    {
        return $this->subjectId;
    }

    public function getPricePerHourFrom()
    {
        return $this->pricePerHourFrom;
    }

    public function getPricePerHourTo()
    {
        return $this->pricePerHourTo;
    }

    public function getCountryIds()
    {
        return $this->countryIds;
    }
}