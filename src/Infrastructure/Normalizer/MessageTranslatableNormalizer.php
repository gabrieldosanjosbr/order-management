<?php

namespace App\Infrastructure\Normalizer;

use App\Action\Response\MessageTranslatable;
use App\Infrastructure\Service\Locale;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\AdvancedNameConverterInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\Translation\TranslatorInterface;

class MessageTranslatableNormalizer extends ObjectNormalizer implements ContextAwareNormalizerInterface
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
        AdvancedNameConverterInterface $modelNameConverter,
        Locale $locale
    ) {
        $this->translator = $translator;
        $this->locale = $locale;

        parent::__construct(null, $modelNameConverter);
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof MessageTranslatable;
    }

    /**
     * @param MessageTranslatable $object
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $ignoredAttributes = ['messagePlaceholders', 'model'];
        $message = $this->translator->trans(
            $object,
            $object->getMessagePlaceholders(),
            null,
            $this->locale->getLocale()
        );

        $object->setMessage($message);

        if ($object->getModel()) {
            $context['model'] = $object->getModel();
            $ignoredAttributes = $this->removeIgnoredModelKey($ignoredAttributes);
        }

        $context[AbstractNormalizer::IGNORED_ATTRIBUTES] = $ignoredAttributes;

        return parent::normalize($object, $format, $context);
    }

    private function removeIgnoredModelKey($ignoredAttributes): array
    {
        return array_filter($ignoredAttributes, function($element) {
            return $element !== 'model';
        });
    }
}
