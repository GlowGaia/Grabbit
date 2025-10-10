<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use GlowGaia\Grabbit\Shared\GSIOperation;
use Saloon\Http\Response;

class GetItem extends GSIOperation
{
    public function __construct(int $method, ?array $parameters)
    {
        parent::__construct($method, $parameters);

        $this->dto = Item::class;
        $this->null_dto = NullItem::class;
    }

    public static function byId(int $id): GetItem
    {
        return new self(712, [$id]);
    }

    public function setResponse(Response $response, int $index): void
    {
        $this->response = $response->json()[$index][2][0];
    }
}
