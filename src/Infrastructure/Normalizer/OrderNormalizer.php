<?php

namespace App\Infrastructure\Normalizer;

use App\Domain\Model\Order;
use App\Infrastructure\Service\Locale;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderNormalizer extends ObjectNormalizer implements ContextAwareNormalizerInterface
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
        return $data instanceof Order;
    }

    /**
     * @param Order $object
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $deleted = $this->translator->trans(
            $object->getDeleted(),
            [],
            null,
            $this->locale->getLocale()
        );

        $object->setDeleted($deleted);

        return parent::normalize($object, $format, $context);
    }
}
