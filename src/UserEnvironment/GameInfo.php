<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;

class GameInfo implements DTOInterface
{
    public function __construct(
        public int $type,
        public string $instance_id,
        public DateTimeImmutable $open_time,
        public DateTimeImmutable $close_time,
        public DateTimeImmutable $end_time,
        public int $length,
        public DateTimeImmutable $results_time,
        public State $state,
        public int $player_count
    ) {}

    public static function fromArray($data): ?self
    {
        if ($data) {
            return new self(
                type: $data['type'],
                instance_id: $data['instance_id'],
                open_time: DateTimeImmutable::createFromFormat('U', (string) $data['open_time']),
                close_time: DateTimeImmutable::createFromFormat('U', (string) $data['close_time']),
                end_time: DateTimeImmutable::createFromFormat('U', (string) $data['end_time']),
                length: $data['length'],
                results_time: DateTimeImmutable::createFromFormat('U', (string) $data['results_time']),
                state: State::from($data['state']),
                player_count: $data['player_count'],
            );
        }

        return null;
    }
}
