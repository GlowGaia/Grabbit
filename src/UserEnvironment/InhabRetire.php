<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class InhabRetire implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    public function __construct(
        public int $item_id,
        public int $count,
    ) {}

    public static function make(
        int $item_id,
        int $count,
    ): static {
        return new self(
            item_id: $item_id,
            count: $count,
        );
    }

    public static function fromArray(array $data): static
    {
        return static::make(
            item_id: (int) ($data['item_id'] ?? 0),
            count: (int) ($data['count'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'item_id' => $this->item_id,
            'count' => $this->count,
        ];
    }
}
