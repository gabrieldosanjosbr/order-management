<?php

namespace App\Action\Request;

class OrderRequest
{
    private $orderId;
    private $orderStatus;
    private $customerName;
    private $orderByColumn;
    private $sortBy;
    private $currentPage;
    private $pageSize;
    public function __construct(
        $orderStatus,
        $customerName,
        $orderByColumn,
        $sortBy,
        $currentPage,
        $pageSize
    ) {
        $this->orderStatus = $orderStatus;
        $this->customerName = $customerName;
        $this->orderByColumn = $orderByColumn;
        $this->sortBy = $sortBy;
        $this->currentPage = $currentPage;
        $this->pageSize = $pageSize;
    }

    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function getOrderByColumn()
    {
        return $this->orderByColumn;
    }

    public function getSortBy()
    {
        return $this->sortBy;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

}
