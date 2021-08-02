<?php

namespace App\Services\Api\Order;

use App\Entities\Lesson;
use App\Entities\Order;
use App\Exceptions\BadRequestException;
use App\Repositories\Common\Order\OrderRepository;
use App\Services\Common\Order\OrderService;
use App\Services\Response\Code;
use App\Services\Response\Status;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\Facades\Log;

class OrderApiService extends OrderService
{
    public function __construct(EntityManager $em, Order $entity, OrderRepository $repository)
    {
        parent::__construct($em, $entity, $repository);
    }

    /**
     * @param Lesson $lesson
     * @return mixed
     * @throws BadRequestException
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function createOrder(Lesson $lesson)
    {
        try {
            $this->entity->setUser($lesson->getUser());
            $this->entity->setTeacher($lesson->getTeacher());
            $this->entity->setType(OrderRepository::TYPE_FREE);
            $this->entity->setAmount(0);
            $this->entity->setLockedAmount(0);
            $this->entity->setStatus(OrderRepository::STATUS_NEW);
            $this->entity->setLesson($lesson);

            return $this->repository->create($this->entity);

        } catch (\Throwable $e) {
            Log::critical($e->getMessage());
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }
}