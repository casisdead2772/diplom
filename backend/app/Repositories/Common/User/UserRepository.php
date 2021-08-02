<?php

namespace App\Repositories\Common\User;

use App\Repositories\InterfaceRepository;

interface UserRepository extends InterfaceRepository
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const AGREEMENT = 1;

    public function findByEmail(string $email);
}
