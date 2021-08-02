<?php

namespace App\Repositories\Common\Passport;

use App\Repositories\DoctrineRepository;

class DoctrineOauthClientsRepository extends DoctrineRepository implements OauthClientsRepository
{
    /**
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findPasswordClient()
    {
        return $this->findOneBy(['passwordClient' => 1]);
    }
}