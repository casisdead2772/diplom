<?php

namespace App\Repositories\Common\LanguageGrade;

use App\Repositories\DoctrineRepository;

class DoctrineLanguageGradeRepository extends DoctrineRepository implements LanguageGradeRepository
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