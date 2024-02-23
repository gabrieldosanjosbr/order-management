<?php

namespace App\Domain\Exception;

use App\Action\Response\MessageTranslatable;

class DomainException extends \DomainException
{
    private $messageTranslatable;

    public function __construct(MessageTranslatable $messageTranslatable)
    {
        parent::__construct($messageTranslatable);

        $this->messageTranslatable = $messageTranslatable;
    }

    public function getMessageTranslatable(): MessageTranslatable
    {
        return $this->messageTranslatable;
    }
}
