<?php

namespace App\Services\Common\Order;

use App\Entities\Order;
use App\Repositories\Common\Order\OrderRepository;
use App\Services\AbstractService;
use Doctrine\ORM\EntityManager;

class OrderService extends AbstractService
{
    public function __construct(EntityManager $em, Order $entity, OrderRepository $repository)
    {
        parent::__construct($em);
        $this->entity = $entity;
        $this->repository = $repository;
    }
}