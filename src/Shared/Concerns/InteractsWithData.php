<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Concerns;

use Illuminate\Support\Collection;

trait InteractsWithData
{
    /**
     * Static helper to turn an array of DTOs into a Collection.
     *
     * @param  array<int, mixed>  $items
     * @return Collection<int, static>
     */
    public static function collect(array $items): Collection
    {
        return collect($items);
    }

    /**
     * Wrap the DTO data in a Laravel Collection.
     *
     * @return Collection<string, mixed>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
