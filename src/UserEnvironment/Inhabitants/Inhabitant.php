<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class Inhabitant implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    public function __construct(
        public ?string $name,
        public int $serial,
        public ?int $inhab_health,
        public ?DateTimeImmutable $inhab_incept,
        public ?DateTimeImmutable $inhab_expires,
        public ?DateTimeImmutable $inhab_cryo,
        public bool $in_env,
        public int $item_id,
        public int $lifespan,
        public ?ItemSpecifics $item_specifics,
        public ?GameSpecifics $game_specifics,
    ) {}

    public static function make(
        ?string $name,
        int $serial,
        ?int $inhab_health,
        ?DateTimeImmutable $inhab_incept,
        ?DateTimeImmutable $inhab_expires,
        ?DateTimeImmutable $inhab_cryo,
        bool $in_env,
        int $item_id,
        int $lifespan,
        ?ItemSpecifics $item_specifics,
        ?GameSpecifics $game_specifics,
    ): static {
        return new self(
            name: $name,
            serial: $serial,
            inhab_health: $inhab_health,
            inhab_incept: $inhab_incept,
            inhab_expires: $inhab_expires,
            inhab_cryo: $inhab_cryo,
            in_env: $in_env,
            item_id: $item_id,
            lifespan: $lifespan,
            item_specifics: $item_specifics,
            game_specifics: $game_specifics,
        );
    }

    public static function fromArray(array $data): static
    {
        return static::make(
            name: isset($data['name']) ? (string) $data['name'] : null,
            serial: (int) ($data['serial'] ?? 0),
            inhab_health: isset($data['inhab_health']) ? (int) $data['inhab_health'] : null,
            inhab_incept: ! empty($data['inhab_incept']) ? DateTimeImmutable::createFromFormat('U', (string) $data['inhab_incept']) ?: null : null,
            inhab_expires: ! empty($data['inhab_expires']) ? DateTimeImmutable::createFromFormat('U', (string) $data['inhab_expires']) ?: null : null,
            inhab_cryo: ! empty($data['inhab_cryo']) ? DateTimeImmutable::createFromFormat('U', (string) $data['inhab_cryo']) ?: null : null,
            in_env: (bool) (int) ($data['in_env'] ?? 0),
            item_id: (int) ($data['item_id'] ?? 0),
            lifespan: (int) ($data['lifespan'] ?? 0),
            item_specifics: isset($data['item_specifics']) ? ItemSpecifics::fromArray($data['item_specifics']) : null,
            game_specifics: isset($data['game_specifics']) ? GameSpecifics::fromArray($data['game_specifics']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'serial' => $this->serial,
            'inhab_health' => $this->inhab_health,
            'inhab_incept' => $this->inhab_incept?->format('U'),
            'inhab_expires' => $this->inhab_expires?->format('U'),
            'inhab_cryo' => $this->inhab_cryo?->format('U'),
            'in_env' => $this->in_env,
            'item_id' => $this->item_id,
            'lifespan' => $this->lifespan,
            'item_specifics' => $this->item_specifics?->toArray(),
            'game_specifics' => $this->game_specifics?->toArray(),
        ];
    }
}
