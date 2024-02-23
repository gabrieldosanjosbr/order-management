<?php

namespace App\Infrastructure\Doctrine\EventSubscriber;

use App\Domain\Model\Order;
use App\Infrastructure\Doctrine\Repository\OrderRepository;
use App\Infrastructure\Doctrine\Repository\OrderStatusRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class OrderPrePersistSubscriber implements EventSubscriber
{
    private $orderRepository;

    private $orderStatusRepository;

    public function __construct(
        OrderRepository $orderRepository,
        OrderStatusRepository $orderStatusRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderStatusRepository = $orderStatusRepository;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Order) {
            return;
        }

        if (!$entity->getId()) {
            $entity->setId($this->orderRepository->getLastOrderId()+1);
        }

        $orderStatus = $this->orderStatusRepository->findOrderStatusByCode($entity->getOrderStatus()->getCode());

        if (!$orderStatus) {
            $this->orderStatusRepository->add($entity->getOrderStatus());
            $this->orderStatusRepository->flush();

            return;
        }

        $entity->setOrderStatus($orderStatus);
    }
}
