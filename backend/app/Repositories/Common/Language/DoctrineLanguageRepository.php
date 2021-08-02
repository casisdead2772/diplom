<?php

namespace App\Repositories\Common\Language;

use App\Repositories\DoctrineRepository;

class DoctrineLanguageRepository extends DoctrineRepository implements LanguageRepository
{
    /**
     * @return int|mixed|string
     */
    public function getList()
    {
        $qb = $this->createQueryBuilder('t')
            ->select(['t.id', 't.name']);

        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}