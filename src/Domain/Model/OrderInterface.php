<?php

namespace App\Domain\Model;

interface OrderInterface
{
    public function getOrderStatus(): ?OrderStatus;

    public function setOrderStatus(OrderStatus $orderStatus): OrderInterface;

    public function getLastModified(): ?\DateTimeInterface;

    public function setLastModified(\DateTimeInterface $lastModified): OrderInterface;

    public function isCancellable(): bool;
}
