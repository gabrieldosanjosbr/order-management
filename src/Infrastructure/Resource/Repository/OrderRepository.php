<?php

namespace App\Infrastructure\Resource\Repository;

use App\Domain\Model\OrderFactory;
use App\Domain\Repository\OrderResourceRepositoryInterface;

class OrderRepository implements OrderResourceRepositoryInterface
{
    private $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @throws \Exception
     */
    public function findOrders(): array
    {
        $json = file_get_contents($this->resource);
        $data = json_decode($json, true);

        return OrderFactory::createManyFromArray($data);
    }
}
