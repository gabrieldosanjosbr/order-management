<?php

namespace App\Infrastructure\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestFactory
{
    public function createFromRequest(Request $request): object;

    public static function supportedRequest(): string;
}
