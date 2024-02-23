<?php

namespace App\Action\Response;

class MessageTranslatable
{
    private $messagePlaceholders;
    private $message;

    private $model;

    private $success;

    public function __construct(
        string $message,
        bool $success,
        $messagePlaceholders = [],
        $model = null
    ) {
        $this->success = $success;
        $this->message = $message;
        $this->messagePlaceholders = $messagePlaceholders;
        $this->model = $model;
    }
    public function getMessagePlaceholders(): array
    {
        $params = [];
        foreach ($this->messagePlaceholders as $key => $item) {
            $params['{{'.$key.'}}'] = $item;
        }
        return $params;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    public function __toString()
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }
}
