<?php

namespace App\Action;

use App\Action\Response\MessageTranslatable;
use App\Domain\Exception\DomainException;
use App\Domain\Service\Order\Cancel as OrderCancelService;

final class CancelOrder
{
    private $orderCancelService;

    public function __construct(OrderCancelService $orderCancelService)
    {
        $this->orderCancelService = $orderCancelService;
    }

    public function __invoke($id): MessageTranslatable
    {
         try {
            if (empty($id)) {
                throw new DomainException(
                    new MessageTranslatable("Missing order id", false)
                );
            }

            $order = $this->orderCancelService->execute($id);
        } catch (DomainException $e) {
             return $e->getMessageTranslatable();
        } catch (\Exception $e) {
             return new MessageTranslatable(
                 "Sorry order couldn't be cancelled due a generic error",
                 false
             );
        }

        return new MessageTranslatable(
            "Order {{id}} successfully cancelled",
            true,
            ['id' => $id],
            $order
        );
    }
}
