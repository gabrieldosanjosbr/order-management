<?php

namespace App\Domain\Model;

class OrderStatus
{
    private $id;

    private $code;

    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code): OrderStatus
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): OrderStatus
    {
        $this->name = $name;

        return $this;
    }
}
