<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Shared\Contracts\GSIRequest;
use Saloon\Http\Response;

class GetEnvironment extends GSIRequest
{
    public function createDtoFromResponse(Response $response): Environment
    {
        return Environment::fromCollection($this->recursive($response));
    }

    protected function defaultQuery(): array
    {
        return [
            'm' => [
                6500,
                [
                    1,
                ],
            ],
            'X' => time(),
        ];
    }
}
