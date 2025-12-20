<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class Reward implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    public function __construct(
        public int $type,
        public ?int $item_id,
        public int $amount,
        public int $chance,
        public int $frequency,
        public int $cap,
    ) {}

    public static function make(
        int $type,
        ?int $item_id,
        int $amount,
        int $chance,
        int $frequency,
        int $cap,
    ): static {
        return new self(
            type: $type,
            item_id: $item_id,
            amount: $amount,
            chance: $chance,
            frequency: $frequency,
            cap: $cap,
        );
    }

    public static function fromArray(array $data): static
    {
        return static::make(
            type: (int) ($data['type'] ?? 0),
            item_id: isset($data['item_id']) ? (int) $data['item_id'] : null,
            amount: (int) ($data['amount'] ?? 0),
            chance: (int) ($data['chance'] ?? 0),
            frequency: (int) ($data['frequency'] ?? 0),
            cap: (int) ($data['cap'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'item_id' => $this->item_id,
            'amount' => $this->amount,
            'chance' => $this->chance,
            'frequency' => $this->frequency,
            'cap' => $this->cap,
        ];
    }
}
