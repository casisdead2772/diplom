<?php

namespace App\Repositories\Common\Country;

use App\Repositories\DoctrineRepository;

class DoctrineCountryRepository extends DoctrineRepository implements CountryRepository
{
    public function getList()
    {
        $qb = $this->createQueryBuilder('t')
            ->select(['t.id', 't.name']);

        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}