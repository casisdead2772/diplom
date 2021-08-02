<?php

namespace App\Traits;

use App\Entities\User;
use LaravelDoctrine\ORM\Facades\EntityManager;

trait UsesPasswordGrant
{
    /**
     * @param string $userIdentifier
     * @return User
     */
    public function findForPassport(string $userIdentifier): User
    {
        $userRepository = EntityManager::getRepository(get_class($this));
        return $userRepository->findOneByEmail($userIdentifier);
    }
}