<?php

namespace App\Infrastructure\Request;

use App\Action\Request\OrderRequest;
use Symfony\Component\HttpFoundation\Request;

final class OrderRequestFactory implements RequestFactory
{
    private $pageSize;

    private $orderByColumn;

    private $sortBy;

    public function __construct(
        int $pageSize,
        string $orderByColumn,
        string $sortBy
    ) {
        $this->pageSize = $pageSize;
        $this->orderByColumn = $orderByColumn;
        $this->sortBy = $sortBy;
    }

    public function createFromRequest(Request $request): object
    {
        return new OrderRequest(
            $request->query->get('orderStatus', ''),
            $request->query->get('customerName', ''),
            $request->query->get('orderByColumn', $this->orderByColumn),
            $request->query->get('sortBy', $this->sortBy),
            (int) $request->query->get('pageIndex', 0),
            (int) $request->query->get('pageSize', $this->pageSize)
        );
    }

    public static function supportedRequest(): string
    {
        return OrderRequest::class;
    }
}
