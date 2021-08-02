<?php

namespace App\Repositories\Common\Passport;

use App\Repositories\InterfaceRepository;

interface OauthClientsRepository extends InterfaceRepository
{
    public function findPasswordClient();
}