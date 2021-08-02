<?php

namespace App\Services\Common\ZoomMeet;

use App\Entities\ZoomMeet;
use App\Repositories\Common\ZoomMeet\ZoomMeetRepository;
use App\Services\AbstractService;
use Doctrine\ORM\EntityManager;

class ZoomMeetService extends AbstractService
{
    public function __construct(EntityManager $em, ZoomMeet $entity, ZoomMeetRepository $repository)
    {
        parent::__construct($em);
        $this->entity = $entity;
        $this->repository = $repository;
    }
}