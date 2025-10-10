<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use GlowGaia\Grabbit\Shared\GSIOperation;

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

    public function setResponse(): void
    {
        $this->response = $this->response[2][0];
    }
}
