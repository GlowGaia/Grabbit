<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;
use Illuminate\Support\Collection;

class GameSpecifics implements DTOInterface
{
    public function __construct(
        public int $drop_type,
        public Collection $rewards,
    ) {}

    public static function fromArray($data): self
    {
        return new self(
            drop_type: (int) $data['drop_type'],
            rewards: collect($data['rewards'])->transform(function ($reward) {
                return Reward::fromArray($reward);
            }),
        );
    }
}
