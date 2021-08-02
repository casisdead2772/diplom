<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;

abstract class AbstractService
{
    protected EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
