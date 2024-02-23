<?php

namespace App\Infrastructure\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class Locale
{
    private $defaultLocale;

    /** @var Request|null */
    private $request;


    public function __construct($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function getLocale():string
    {
        if ($this->request) {
            return $this->request
                ->query
                ->get('locale', $this->defaultLocale);
        }

        return $this->defaultLocale;
    }

    public function withRequest(RequestStack $request): Locale
    {
        $this->request = $request->getCurrentRequest();
        return $this;
    }
}
