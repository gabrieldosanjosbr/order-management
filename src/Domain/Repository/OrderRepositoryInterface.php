<?php

namespace App\Domain\Repository;

use App\Domain\Model\OrderInterface;
use App\Domain\Model\OrderStatus;

interface OrderRepositoryInterface extends OrderResourceRepositoryInterface
{
    public function add(OrderInterface $order);
    public function remove(OrderInterface $order);

    public function flush();

    public function findOrderById($orderId): ?OrderInterface;

    public function queryPaginated(int $page, int $pageSize): OrderRepositoryInterface;

    public function querySortBy($column = 'id', $sort = 'DESC'): OrderRepositoryInterface;

    public function queryByCustomerName($customerName): OrderRepositoryInterface;

    public function queryOrderByStatus(?OrderStatus $orderStatus): OrderRepositoryInterface;

    public function getTotalOrders(): int;
}

