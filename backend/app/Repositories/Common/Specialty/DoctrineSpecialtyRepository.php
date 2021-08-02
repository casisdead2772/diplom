<?php

namespace App\Repositories\Common\Specialty;

use App\Repositories\DoctrineRepository;

class DoctrineSpecialtyRepository extends DoctrineRepository implements SpecialtyRepository
{
    /**
     * @return int|mixed|string
     */
    public function getList()
    {
        $qb = $this->createQueryBuilder('t')
            ->select(['t.id', 't.name', 't.code']);

        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}
