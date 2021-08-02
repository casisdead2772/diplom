<?php

namespace App\Services\Common\Lesson;

use App\Entities\LessonReserve;
use App\Repositories\Common\LessonReserve\LessonReserveRepository;
use App\Services\AbstractService;
use Doctrine\ORM\EntityManager;

class LessonReserveService extends AbstractService
{
    public function __construct(EntityManager $em, LessonReserve $entity, LessonReserveRepository $repository)
    {
        parent::__construct($em);
        $this->entity = $entity;
        $this->repository = $repository;
    }
}