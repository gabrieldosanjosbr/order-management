<?php

namespace App\Infrastructure\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;

final class RequestConverter implements ParamConverterInterface
{
    private $requestFactory;

    private $requestFactoryProvider;

    public function __construct(RequestFactoryProvider $requestFactoryProvider)
    {
        $this->requestFactoryProvider = $requestFactoryProvider;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $requestObject = $this->requestFactory->createFromRequest($request);

        $request->attributes->set($configuration->getName(), $requestObject);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        try {
            $this->requestFactory = $this->requestFactoryProvider->getFactory($configuration->getClass());
        } catch (ServiceNotFoundException $e) {
            return false;
        }

        return true;
    }
}
