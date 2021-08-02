<?php

namespace App\Repositories;

use App\Entities\BaseEntity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * Interface BaseInterfaceRepository
 * @package App\Repositories
 *
 * @method find($id, $lockMode = null, $lockVersion = null)
 * @method findOneBy(array $criteria, array $orderBy = null)
 * @method findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method findAll()
 */
interface InterfaceRepository
{
    public function create(BaseEntity $entity);

    public function update(BaseEntity $entity);

    public function remove(BaseEntity $entity): void;

    public function persist(BaseEntity $entity);

    public function flush(BaseEntity $entity);

    public function findById(int $id): ?BaseEntity;

    public function findWithPaginated(Request $request): LengthAwarePaginator;
}
