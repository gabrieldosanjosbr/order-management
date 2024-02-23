<?php

namespace App\Infrastructure\Serializer;

use Symfony\Component\Serializer\NameConverter\AdvancedNameConverterInterface;

class ModelNameConverter implements AdvancedNameConverterInterface
{
    public function normalize(string $propertyName, ?string $class = null, ?string $format = null, array $context = []): string
    {
        if ($propertyName !== 'model'
            || !array_key_exists('model', $context)
            || !is_object($context['model'])
        ) {
            return $propertyName;
        }


        $class = explode('\\', get_class($context['model']));

        return lcfirst(end($class));
    }

    public function denormalize(string $propertyName, ?string $class = null, ?string $format = null, array $context = [])
    {
        // TODO: Implement denormalize() method.
    }
}
