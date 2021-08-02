<?php

namespace App\Repositories\Api\LessonReserve;

use App\Entities\User;
use App\Repositories\Api\LessonReserve\Criteria\LessonReserveApiCriteria;
use App\Repositories\Api\LessonReserve\Filter\LessonReserveApiFilter;
use App\Repositories\Common\LessonReserve\DoctrineLessonReserveRepository;
use App\Repositories\Common\LessonReserve\LessonReserveRepository;

class DoctrineLessonReserveApiRepository extends DoctrineLessonReserveRepository implements LessonReserveApiRepository
{
    /**
     * @param User $user
     * @param LessonReserveApiFilter $filter
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllByWithPaginated(User $user, LessonReserveApiFilter $filter)
    {
        $criteria = new LessonReserveApiCriteria($filter);

        $qb = $this->createQueryBuilder('t');

        $result = $qb->select(['t', 'u', 'ui'])
            ->innerJoin('t.user', 'u')
            ->innerJoin('u.userInformation', 'ui')
            ->where('t.teacher = :teacher')
            ->andWhere('t.status in (:statuses)')
            ->orderBy('t.' . $filter->getSort(), 'DESC')
            ->setParameters([
                'teacher' => $user,
                'statuses' => [LessonReserveRepository::STATUS_NEW]
            ]);
        $query = $result->getQuery();
        return $this->paginate($query, $filter->getLimit(), $filter->getPage(), true);
    }

    /**
     * @param User $user
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findReservedCount(User $user)
    {
        $qb = $this->createQueryBuilder('t');

        $result = $qb->select(['COUNT(t.id) AS reserved_count'])
            ->where('t.teacher = :teacher')
            ->andWhere('t.status = :status')
            ->setParameters([
                'teacher' => $user,
                'status' => LessonReserveRepository::STATUS_NEW,
            ]);

        return $result->getQuery()->getOneOrNullResult();
    }
}
