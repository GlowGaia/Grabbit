<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\Contracts\DTO;

class Reward extends DTO
{
    public function __construct(
        public int $type,
        public ?int $item_id,
        public int $amount,
        public int $chance,
        public int $frequency,
        public int $cap,
    ) {}

    public static function fromArray($data): static
    {
        return new self(
            type: (int) $data['type'],
            item_id: (int) $data['item_id'] ?? null,
            amount: (int) $data['amount'],
            chance: (int) $data['chance'],
            frequency: (int) $data['frequency'],
            cap: (int) $data['cap'],
        );
    }
}
