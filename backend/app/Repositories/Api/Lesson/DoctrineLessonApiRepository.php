<?php

namespace App\Repositories\Api\Lesson;

use App\Entities\User;
use App\Repositories\Api\Lesson\Criteria\LessonApiCriteria;
use App\Repositories\Api\Lesson\Filter\LessonApiFilter;
use App\Repositories\Api\LessonReserve\Filter\LessonReserveApiFilter;
use App\Repositories\Common\Acl\RoleRepository;
use App\Repositories\Common\Lesson\DoctrineLessonRepository;
use App\Repositories\Common\Lesson\LessonRepository;

class DoctrineLessonApiRepository extends DoctrineLessonRepository implements LessonApiRepository
{
    /**
     * @param User $user
     * @param LessonReserveApiFilter $filter
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllByWithPaginated(User $user, LessonApiFilter $filter)
    {
        $criteria = new LessonApiCriteria($filter);

        $qb = $this->createQueryBuilder('t');

        $qb->select(['t', 'u', 'ui']);

        if ($user->hasRoleByName(RoleRepository::NAME_TEACHER)) {
            $qb = $qb
                ->innerJoin('t.user', 'u')
                ->innerJoin('u.userInformation', 'ui')
                ->where('t.teacher = :user');
        } else {
            $qb = $qb
                ->innerJoin('t.teacher', 'u')
                ->innerJoin('u.userInformation', 'ui')
                ->where('t.user = :user');
        }

        $query = $qb->andWhere('t.status in (:statuses)')
            ->orderBy('t.' . $filter->getSort(), 'DESC')
            ->setParameters([
                'user' => $user,
                'statuses' => [LessonRepository::STATUS_NEW, LessonRepository::STATUS_STARTED, LessonRepository::STATUS_COMPLETED, LessonRepository::STATUS_CANCELED]
            ]);

        $query = $query->getQuery();

        return $this->paginate($query, $filter->getLimit(), $filter->getPage(), true);
    }
}
