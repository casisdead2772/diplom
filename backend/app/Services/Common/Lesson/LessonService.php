<?php

namespace App\Services\Common\Lesson;

use App\Entities\Lesson;
use App\Repositories\Common\Lesson\LessonRepository;
use App\Services\AbstractService;
use Doctrine\ORM\EntityManager;

class LessonService extends AbstractService
{
    public function __construct(EntityManager $em, Lesson $entity, LessonRepository $repository)
    {
        parent::__construct($em);
        $this->entity = $entity;
        $this->repository = $repository;
    }
}