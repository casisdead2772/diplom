<?php

namespace App\Repositories\Common\UserGroup;

use App\Repositories\InterfaceRepository;

interface UserGroupRepository extends InterfaceRepository
{
    const BASIC_GROUP_NAME = 'basic';
    const BASIC_GROUP = 1;
}