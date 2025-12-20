<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class GameSpecifics implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    /**
     * @param  Reward[]  $rewards
     */
    public function __construct(
        public int $drop_type,
        public array $rewards,
    ) {}

    /**
     * @param  Reward[]  $rewards
     */
    public static function make(
        int $drop_type,
        array $rewards,
    ): static {
        return new self(
            drop_type: $drop_type,
            rewards: $rewards,
        );
    }

    public static function fromArray(array $data): static
    {
        $rewards = [];

        if (isset($data['rewards']) && is_array($data['rewards'])) {
            foreach ($data['rewards'] as $reward) {
                $rewards[] = Reward::fromArray($reward);
            }
        }

        return static::make(
            drop_type: (int) ($data['drop_type'] ?? 0),
            rewards: $rewards,
        );
    }

    public function toArray(): array
    {
        return [
            'drop_type' => $this->drop_type,
            'rewards' => array_map(fn (Reward $reward) => $reward->toArray(), $this->rewards),
        ];
    }
}
