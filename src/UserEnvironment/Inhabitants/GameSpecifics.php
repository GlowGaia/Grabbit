<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\Contracts\DTO;
use Illuminate\Support\Collection;

class GameSpecifics extends DTO
{
    public function __construct(
        public int $drop_type,
        public Collection $rewards,
    ) {}

    public static function fromArray($data): static
    {
        return new self(
            drop_type: (int) $data['drop_type'],
            rewards: collect($data['rewards'])->transform(function ($reward) {
                return Reward::fromArray($reward);
            }),
        );
    }
}
