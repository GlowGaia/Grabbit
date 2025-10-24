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

    public static function fromCollection($data): Environment
    {
        return new self(
            attributes: $data->get('attributes')->transform(function ($attribute) {
                return Attribute::fromCollection($attribute);
            }),
            engine_delay_time: (int) $data->get('engine_delay_time'),
            max_health: (int) $data->get('max_health'),
            max_inhabitant_count: (int) $data->get('max_inhabitant_count'),
            max_decoration_count: (int) $data->get('max_decoration_count'),
            gaia_curr_time: DateTimeImmutable::createFromFormat('U', (string) $data->get('gaia_curr_time')),
        );
    }
}
