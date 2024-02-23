<?php

namespace App\Domain\Repository;

use App\Domain\Model\OrderInterface;

interface OrderResourceRepositoryInterface
{
    /**
     * @return OrderInterface[]
     */
    public function findOrders(): array;
}
