<?php

namespace App\Repositories\Api\Teacher;

use App\Repositories\Api\Teacher\Criteria\TeacherCriteria;
use App\Repositories\Api\Teacher\Filter\TeacherApiFilter;
use App\Repositories\Api\Teacher\Filter\TeacherFilter;
use App\Repositories\Common\Teacher\DoctrineTeacherRepository;
use Illuminate\Http\Request;

class DoctrineTeacherApiRepository extends DoctrineTeacherRepository implements TeacherApiRepository
{
    /**
     * @param TeacherFilter $teacherFilter
     */
    public function findTeachersWithPaginate(TeacherFilter $teacherFilter)
    {
        $criteria = new TeacherCriteria($teacherFilter);

        $qb = $this->createQueryBuilder('t');

        $result = $qb->select(['t'])
            ->innerJoin('t.teacherInformation', 'ti')
            ->innerJoin('t.userInformation', 'ui')
            ->innerJoin('ti.teacherLanguages', 'tl')
            ->where($qb->expr()->isNotNull('t.emailVerifiedAt'))
            ->addCriteria($criteria->forSubjectId())
            ->addCriteria($criteria->forPricePerHour())
            ->addCriteria($criteria->forCountryIds())
            ->orderBy('t.' . $teacherFilter->getSort(), 'DESC');

        $query = $result->getQuery();

        return $this->paginate($query, $teacherFilter->getLimit(), $teacherFilter->getPage(), true);
    }


    public function findAllTeachers()
    {
        $qb = $this->createQueryBuilder('t');
            $result = $qb->select(['t', 'ti', 'ui'])
            ->innerJoin('t.teacherInformation', 'ti')
            ->innerJoin('t.userInformation', 'ui')
            ->innerJoin('ti.teacherLanguages', 'tl')
            ->where($qb->expr()->isNull('t.emailVerifiedAt'));

        return $result->getQuery()->getArrayResult();
    }
}
