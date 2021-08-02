<?php


namespace App\Repositories\Api\MeetUrl;

use App\Repositories\Common\MeetUrl\DoctrineMeetUrlRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctrineMeetUrlApiRepository extends DoctrineMeetUrlRepository implements MeetUrlApiRepository
{
    /**
     * @param int $id
     * @return array|LengthAwarePaginator|int|string
     */
    public function findMeetUrlByLessonId(int $id)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m', 'l')
            ->innerJoin('m.lesson', 'l')
            ->where('l.id = :id')
            ->setParameters([
                'id' => $id
            ]);
        return $qb->getQuery()->getArrayResult();
    }


}
