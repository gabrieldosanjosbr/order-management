<?php

namespace App\Domain\Service\Order;

use App\Domain\Repository\OrderResourceRepositoryInterface;
use App\Domain\Repository\OrderRepositoryInterface;

class Import
{
    private $orderRepository;
    private $orderResourceRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderResourceRepositoryInterface $orderResourceRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderResourceRepository = $orderResourceRepository;
    }

    /**
     * @throws \Exception
     */
    public function execute()
    {
        $orders = $this->orderResourceRepository->findOrders();

        foreach ($orders as $order) {
            $this->orderRepository->add($order);
        }

        $this->orderRepository->flush();
    }
}
