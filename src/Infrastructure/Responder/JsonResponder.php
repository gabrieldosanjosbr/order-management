<?php

namespace App\Infrastructure\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\SerializerInterface;

final class JsonResponder
{
    private const SUPPORTED_CONTENT_TYPE = 'json';
    private $serializer;
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(SerializerInterface $serializer, RequestStack $requestStack)
    {
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
    }

    public function __invoke(ViewEvent $viewEvent): void
    {
        if (self::SUPPORTED_CONTENT_TYPE !== $viewEvent->getRequest()->getContentType()) {
            return;
        }

        $viewEvent->setResponse(
            new JsonResponse(
                $this->serializer->serialize($viewEvent->getControllerResult(), 'json'),
                Response::HTTP_OK,
                [],
                true
            )
        );
    }
}
