<?php

namespace App\Domain\Model;

class OrderFactory
{
    /**
     * @throws \Exception
     */
    public static function createFromData(array $orderData): Order
    {
        $order = new Order();
        $order->setId($orderData['id']);
        $order->setAddress1($orderData['address1']);
        $order->setAmount($orderData['amount']);
        $order->setCity($orderData['city']);
        $order->setCountry($orderData['country']);
        $order->setCustomer($orderData['customer']);
        $order->setDate(\DateTimeImmutable::createFromFormat('U', strtotime($orderData['date'])));
        $order->setDeleted($orderData['deleted']);
        $order->setLastModified(\DateTime::createFromFormat('U', strtotime($orderData['last_modified'])));
        $order->setPostcode($orderData['postcode']);

        $orderStatus = self::createOrderStatus($orderData['status']);

        $order->setOrderStatus($orderStatus);

        return $order;
    }

    public static function createOrderStatus($status): OrderStatus
    {
        $name = implode(' ', array_map(
            'ucfirst',
            explode('_', $status)
        ));

        $orderStatus = new OrderStatus();
        $orderStatus->setCode($status);
        $orderStatus->setName($name);

        return $orderStatus;
    }

    /**
     * @throws \Exception
     */
    public static function createManyFromArray($data): array
    {
        $data = is_array($data) ? $data : [$data];
        $orders = [];

        foreach ($data as $order) {
            $orders[] = self::createFromData($order);
        }

        return $orders;
    }

}
