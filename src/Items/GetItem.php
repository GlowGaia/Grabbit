<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use GlowGaia\Grabbit\Shared\Contracts\GSIRequest;
use GlowGaia\Grabbit\Shared\Helpers\RecursiveCollection;
use Saloon\Http\Response;

class GetItem extends GSIRequest
{
    public function __construct(public int $id) {}

    public static function byId(int $id): self
    {
        return new self($id);
    }

    public function createDtoFromResponse(Response $response): Item
    {
        return Item::fromCollection($this->recursive($response));
    }

    public function hasRequestSucceeded(Response $response): bool
    {
        return $response->json()[0][1] && count($response->json()[0][2]);
    }

    protected function defaultQuery(): array
    {
        return [
            'm' => [
                712,
                [
                    $this->id,
                ],
            ],
            'X' => time(),
        ];
    }

    protected function recursive(Response $response): RecursiveCollection
    {
        return RecursiveCollection::recursive($response->collect()[0][2][0]);
    }
}
