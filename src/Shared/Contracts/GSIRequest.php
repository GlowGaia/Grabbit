<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Contracts;

use GlowGaia\Grabbit\Shared\Helpers\RecursiveCollection;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

abstract class GSIRequest extends Request
{
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/chat/gsi/json.php';
    }

    public function hasRequestFailed(Response $response): bool
    {
        return ! $this->hasRequestSucceeded($response);
    }

    public function hasRequestSucceeded(Response $response): bool
    {
        return $response->json()[0][1];
    }

    protected function recursive(Response $response): RecursiveCollection
    {
        return RecursiveCollection::recursive($response->collect()[0][2]);
    }
}
