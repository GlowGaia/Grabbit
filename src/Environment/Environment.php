<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class Environment implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    /**
     * @param  Attribute[]  $attributes
     */
    public function __construct(
        public array $attributes,
        public int $engine_delay_time,
        public int $max_health,
        public int $max_inhabitant_count,
        public ?int $max_decoration_count,
        public DateTimeImmutable $gaia_curr_time,
    ) {}

    /**
     * @param  Attribute[]  $attributes
     */
    public static function make(
        array $attributes,
        int $engine_delay_time,
        int $max_health,
        int $max_inhabitant_count,
        ?int $max_decoration_count,
        DateTimeImmutable $gaia_curr_time
    ): static {
        return new self(
            attributes: $attributes,
            engine_delay_time: $engine_delay_time,
            max_health: $max_health,
            max_inhabitant_count: $max_inhabitant_count,
            max_decoration_count: $max_decoration_count,
            gaia_curr_time: $gaia_curr_time
        );
    }

    public static function fromArray(array $data): static
    {
        $payload = $data[0][2] ?? [];

        $attributes = [];
        $rawAttributes = isset($payload['attributes']) && is_array($payload['attributes'])
            ? $payload['attributes']
            : [];

        foreach ($rawAttributes as $id => $attrData) {
            if (is_array($attrData)) {
                $attributes[] = Attribute::fromArray((int) $id, $attrData);
            }
        }

        $timeRaw = $payload['gaia_curr_time'] ?? time();
        $time = DateTimeImmutable::createFromFormat('U', (string) $timeRaw) ?: new DateTimeImmutable;

        return static::make(
            attributes: $attributes,
            engine_delay_time: isset($payload['engine_delay_time']) ? (int) $payload['engine_delay_time'] : 0,
            max_health: isset($payload['max_health']) ? (int) $payload['max_health'] : 0,
            max_inhabitant_count: isset($payload['max_inhabitant_count']) ? (int) $payload['max_inhabitant_count'] : 0,
            max_decoration_count: isset($payload['max_decoration_count']) ? (int) $payload['max_decoration_count'] : null,
            gaia_curr_time: $time,
        );
    }

    public function toArray(): array
    {
        return [
            'attributes' => array_map(fn (Attribute $attr) => $attr->toArray(), $this->attributes),
            'engine_delay_time' => $this->engine_delay_time,
            'max_health' => $this->max_health,
            'max_inhabitant_count' => $this->max_inhabitant_count,
            'max_decoration_count' => $this->max_decoration_count,
            'gaia_curr_time' => (int) $this->gaia_curr_time->format('U'),
        ];
    }
}
