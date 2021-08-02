<?php

namespace App\Repositories\Common\Acl;

use App\Repositories\InterfaceRepository;

interface RoleRepository extends InterfaceRepository
{
    const NAME_ADMIN = 'admin';
    const NAME_MANAGER = 'manager';
    const NAME_USER = 'user';
    const NAME_TEACHER = 'teacher';

    const ROLE_ADMIN = 1;
    const ROLE_MANAGER = 2;
    const ROLE_USER = 3;
    const ROLE_TEACHER = 4;

    public function getList();
}
