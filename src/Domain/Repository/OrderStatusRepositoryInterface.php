<?php

namespace App\Domain\Repository;

interface OrderStatusRepositoryInterface
{
    public function findAllOrderStatus(): array;
    public function findOrderStatusByCode($code);

    public function flush();
}
