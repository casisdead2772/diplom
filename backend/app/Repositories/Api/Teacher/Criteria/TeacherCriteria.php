<?php

namespace App\Repositories\Api\Teacher\Criteria;

use App\Repositories\Api\Teacher\Filter\TeacherFilter;
use App\Repositories\Criteria\AbstractCriteria;
use Doctrine\Common\Collections\Criteria;

class TeacherCriteria extends AbstractCriteria
{
    /**
     * @var TeacherFilter
     */
    private TeacherFilter $teacherFilter;

    /**
     * UserCriteria constructor.
     * @param TeacherFilter $teacherFilter
     */
    public function __construct(TeacherFilter $teacherFilter)
    {
        parent::__construct($teacherFilter);
        $this->teacherFilter = $teacherFilter;
    }

    public function forSubjectId(): Criteria
    {
        $criteria = Criteria::create();
        $expr = Criteria::expr();

        $subjectId = $this->teacherFilter->getSubjectId();

        $criteria->andWhere($expr->eq('ti.specialty', $subjectId));

        return $criteria;
    }

    public function forPricePerHour(): Criteria
    {
        $criteria = Criteria::create();
        $expr = Criteria::expr();

        $perHourFrom = $this->teacherFilter->getPricePerHourFrom();
        $perHourTo = $this->teacherFilter->getPricePerHourTo();

        $criteria->andWhere($expr->gte('ti.pricePerHour', $perHourFrom));
        $criteria->andWhere($expr->lte('ti.pricePerHour', $perHourTo));

        return $criteria;
    }

    public function forCountryIds(): Criteria
    {
        $criteria = Criteria::create();
        $expr = Criteria::expr();

        $countryIds = $this->teacherFilter->getCountryIds();

        if ($countryIds !== null) {
            $criteria->andWhere($expr->in('ti.country', $countryIds));
        }

        return $criteria;
    }
}