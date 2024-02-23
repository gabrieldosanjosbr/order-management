<?php

namespace App\Infrastructure\Request;

use Symfony\Component\DependencyInjection\ServiceLocator;

final class RequestFactoryProvider
{
    private $serviceLocator;

    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getFactory(string $className): RequestFactory
    {
        return $this->serviceLocator->get($className);
    }
}
