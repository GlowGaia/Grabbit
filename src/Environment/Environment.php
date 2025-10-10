<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Contracts\DTO;
use Illuminate\Support\Collection;

class Environment extends DTO
{
    public function __construct(
        public Collection $attributes,
        public int $engine_delay_time,
        public int $max_health,
        public int $max_inhabitant_count,
        public int $max_decoration_count,
        public DateTimeImmutable $gaia_curr_time,
    ) {}

    public static function fromArray($data): static
    {
        return new self(
            attributes: collect($data['attributes'])->transform(function ($attribute) {
                return Attribute::fromArray($attribute);
            }),
            engine_delay_time: (int) $data['engine_delay_time'],
            max_health: (int) $data['max_health'],
            max_inhabitant_count: (int) $data['max_inhabitant_count'],
            max_decoration_count: (int) $data['max_decoration_count'],
            gaia_curr_time: DateTimeImmutable::createFromFormat('U', (string) $data['gaia_curr_time']),
        );
    }
}
