<?php

namespace App\Repositories\Common\Order;

use App\Repositories\InterfaceRepository;

interface OrderRepository extends InterfaceRepository
{
    const STATUS_NEW = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELED = 3;

    const TYPE_FREE = 1;
    const TYPE_PAID = 2;
}