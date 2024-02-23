<?php

namespace App\Action;

use App\Action\Request\OrderRequest;
use App\Domain\Repository\OrderRepositoryInterface;
use App\Domain\Repository\OrderStatusRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

final class ListOrders
{
    private $orderRepository;

    private $orderStatusRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderStatusRepositoryInterface $orderStatusRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderStatusRepository = $orderStatusRepository;
    }

    /**
     * @ParamConverter(converter="converter.request", name="orderRequest")
     */
    public function __invoke(OrderRequest $orderRequest): array
    {
        $orderStatus = $orderRequest->getOrderStatus()
            ? $this->orderStatusRepository->findOrderStatusByCode($orderRequest->getOrderStatus())
            : null;

        $orderRepository = $this->orderRepository
            ->queryByCustomerName($orderRequest->getCustomerName())
            ->queryOrderByStatus($orderStatus);

        $totalOrders = $orderRepository->getTotalOrders();

        $orders = $orderRepository
            ->queryPaginated(
                $orderRequest->getCurrentPage(),
                $orderRequest->getPageSize()
            )
            ->querySortBy($orderRequest->getOrderByColumn(), $orderRequest->getSortBy())
            ->findOrders();

        return [
            'totalOrders' => $totalOrders,
            'orders' => $orders
        ];
    }
}
