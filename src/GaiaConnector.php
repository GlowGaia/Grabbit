<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit;

use Saloon\Http\Connector;

class GaiaConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://www.gaiaonline.com/';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
