<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use DateTimeImmutable;
use Exception;
use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class GameInfo implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    public function __construct(
        public int $type,
        public string $instance_id,
        public DateTimeImmutable $open_time,
        public DateTimeImmutable $close_time,
        public DateTimeImmutable $end_time,
        public int $length,
        public DateTimeImmutable $results_time,
        public State $state,
        public int $player_count,
    ) {}

    public static function make(
        int $type,
        string $instance_id,
        DateTimeImmutable $open_time,
        DateTimeImmutable $close_time,
        DateTimeImmutable $end_time,
        int $length,
        DateTimeImmutable $results_time,
        State $state,
        int $player_count,
    ): static {
        return new self(
            type: $type,
            instance_id: $instance_id,
            open_time: $open_time,
            close_time: $close_time,
            end_time: $end_time,
            length: $length,
            results_time: $results_time,
            state: $state,
            player_count: $player_count,
        );
    }

    public static function fromArray(array $data): static
    {
        try {
            $open = new DateTimeImmutable('@'.($data['open_time'] ?? 0));
            $close = new DateTimeImmutable('@'.($data['close_time'] ?? 0));
            $end = new DateTimeImmutable('@'.($data['end_time'] ?? 0));
            $results = new DateTimeImmutable('@'.($data['results_time'] ?? 0));
        } catch (Exception) {
            $open = $close = $end = $results = new DateTimeImmutable('@0');
        }

        return static::make(
            type: (int) ($data['type'] ?? 0),
            instance_id: (string) ($data['instance_id'] ?? ''),
            open_time: $open,
            close_time: $close,
            end_time: $end,
            length: (int) ($data['length'] ?? 0),
            results_time: $results,
            state: State::tryFrom((string) ($data['state'] ?? '')) ?? State::Inactive,
            player_count: (int) ($data['player_count'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'instance_id' => $this->instance_id,
            'open_time' => $this->open_time->format('U'),
            'close_time' => $this->close_time->format('U'),
            'end_time' => $this->end_time->format('U'),
            'length' => $this->length,
            'results_time' => $this->results_time->format('U'),
            'state' => $this->state->value,
            'player_count' => $this->player_count,
        ];
    }
}
