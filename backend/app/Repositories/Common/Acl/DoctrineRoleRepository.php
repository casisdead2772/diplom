<?php

namespace App\Repositories\Common\Acl;

use App\Repositories\DoctrineRepository;

class DoctrineRoleRepository extends DoctrineRepository implements RoleRepository
{
    public function getList()
    {
        return $this->createQueryBuilder('t')
            ->select(['t.id', 't.name'])
            ->getQuery()
            ->getResult();
    }
}
