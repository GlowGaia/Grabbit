<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Contracts\DTO;

class GameInfo extends DTO
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

    public static function fromCollection($data): static
    {
        return new self(
            type: $data->get('type'),
            instance_id: $data->get('instance_id'),
            open_time: DateTimeImmutable::createFromFormat('U', (string) $data->get('open_time')),
            close_time: DateTimeImmutable::createFromFormat('U', (string) $data->get('close_time')),
            end_time: DateTimeImmutable::createFromFormat('U', (string) $data->get('end_time')),
            length: $data->get('length'),
            results_time: DateTimeImmutable::createFromFormat('U', (string) $data->get('results_time')),
            state: State::from($data->get('state', '')),
            player_count: $data->get('player_count'),
        );
    }
}
