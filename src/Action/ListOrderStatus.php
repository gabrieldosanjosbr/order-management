<?php

namespace App\Action;

use App\Infrastructure\Doctrine\Repository\OrderStatusRepository;

final class ListOrderStatus
{
    private $orderStatusRepository;

    public function __construct(OrderStatusRepository $orderStatusRepository)
    {
        $this->orderStatusRepository = $orderStatusRepository;
    }

    public function __invoke(): array
    {
        return $this->orderStatusRepository->findAllOrderStatus();
    }
}
