<?php

namespace App\Repositories;

use App\Entities\BaseEntity;
use Carbon\Carbon;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

/**
 * Class DoctrineRepository
 * @package App\Repositories
 */
class DoctrineRepository extends EntityRepository implements InterfaceRepository
{
    use PaginatesFromParams;

    public function create(BaseEntity $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush($entity);

        return $entity;
    }

    public function update(BaseEntity $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush($entity);

        return $entity;
    }

    public function remove(BaseEntity $entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    public function persist(BaseEntity $entity)
    {
        $this->_em->persist($entity);
    }

    public function flush(BaseEntity $entity)
    {
        $this->_em->flush($entity);
    }

    public function findById(int $id): ?BaseEntity
    {
        try {
            $entity = $this->createQueryBuilder('t')
                ->select('t')
                ->where('t.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();

            return $entity;
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }

        return null;
    }

    public function findWithPaginated(Request $request): LengthAwarePaginator
    {
        $limit = $request->get('limit', 15);
        $page = $request->get('page', 1);
        $query = $this->createQueryBuilder('t')
            ->select(['t'])
            ->orderBy('t.id', 'DESC')
            ->getQuery();

        return $this->paginate($query, $limit, $page, false);
    }

    protected function addDateRange(\Doctrine\ORM\QueryBuilder $query, int $from_time = null, int $to_time = null)
    {
        if ($from_time) {
            $from = Carbon::createFromTimestamp($from_time);
            $query->andWhere('t.createdAt >= :from')
                ->setParameter(':from', $from);
        }

        if ($to_time) {
            $to = Carbon::createFromTimestamp($to_time);
            $query->andWhere('t.createdAt <= :to')
                ->setParameter(':to', $to);
        }

        return $query;
    }
}
