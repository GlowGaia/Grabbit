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
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.10 Safari/605.1.1',
        ];
    }
}
