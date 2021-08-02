<?php

namespace App\Repositories\Common\User;

use App\Repositories\DoctrineRepository;

class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    /**
     * @param string $email
     * @return object|null
     */
    public function findByEmail(string $email)
    {
        return $this->findOneBy(['email' => $email]);
    }
}
