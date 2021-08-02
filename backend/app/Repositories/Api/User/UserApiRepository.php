<?php

namespace App\Repositories\Api\User;

use App\Entities\User;
use App\Repositories\Common\User\UserRepository;

interface UserApiRepository extends UserRepository
{
    public function markEmailAsVerified(User $user);
}
