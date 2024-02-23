<?php

namespace App\Domain\Service\Order;

use App\Action\Response\MessageTranslatable;
use App\Domain\Exception\DomainException;
use App\Domain\Model\OrderInterface;
use App\Domain\Repository\OrderRepositoryInterface;
use App\Domain\Repository\OrderStatusRepositoryInterface;

class Cancel
{
    /**
     * @var OrderStatusRepositoryInterface
     */
    private $orderStatusRepository;
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderStatusRepositoryInterface $orderStatusRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderStatusRepository = $orderStatusRepository;
    }

    public function execute($id): OrderInterface
    {
        $order = $this->orderRepository->findOrderById($id);

        if (!$order) {
            throw new DomainException(new MessageTranslatable(
                'Order {{id}} not found',
                false,
                ['id' => $id]
            ));
        }

        if (!$order->isCancellable()) {
            throw new DomainException(new MessageTranslatable(
                "Order {{id}} can't be cancelled",
                false,
                ['id' => $id]
            ));
        }

        $orderStatus = $this->orderStatusRepository->findOrderStatusByCode('cancelled');

        if (!$orderStatus) {
            throw new DomainException(new MessageTranslatable(
                'Cancelled status not found',
                false
            ));
        }

        $order->setOrderStatus($orderStatus);
        $order->setLastModified(new \DateTime());

        $this->orderRepository->flush();

        return $order;
    }
}
