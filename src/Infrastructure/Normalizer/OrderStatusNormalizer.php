<?php

namespace App\Infrastructure\Normalizer;

use App\Domain\Model\OrderStatus;
use App\Infrastructure\Service\Locale;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderStatusNormalizer extends ObjectNormalizer implements ContextAwareNormalizerInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var Locale
     */
    private $locale;

    public function __construct(
        TranslatorInterface $translator,
        Locale $locale
    ) {
        $this->translator = $translator;
        $this->locale = $locale;

        parent::__construct();
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof OrderStatus;
    }

    /**
     * @param OrderStatus $object
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $name = $this->translator->trans(
            $object->getName(),
            [],
            null,
            $this->locale->getLocale()
        );

        $object->setName($name);

        $context[AbstractNormalizer::IGNORED_ATTRIBUTES] = [
            '__cloner__',
            '__isInitialized__',
            '__initializer__'
        ];

        return parent::normalize($object, $format, $context);
    }
}
