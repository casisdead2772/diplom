<?php

namespace App\Repositories\Api\User;

use App\Entities\User;
use Illuminate\Support\Facades\Date;
use App\Repositories\Common\User\DoctrineUserRepository;

class DoctrineUserApiRepository extends DoctrineUserRepository implements UserApiRepository
{
    /**
     * @param User $user
     * @return User
     */
    public function markEmailAsVerified(User $user)
    {
        $user->setEmailVerifiedAt(Date::now());
        $this->update($user);
        return $user;
    }
}
