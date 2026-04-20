<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\DTOs;

use DateTimeImmutable;
use GlowGaia\Grabbit\Common\DTOs\AbstractDTO;
use Illuminate\Support\Collection;

final class Environment extends AbstractDTO
{
    /** @var Collection<int, Attribute> $attributes */
    public Collection $attributes;

    /**
     * @param  array<int|string, array<string, mixed>>  $attributes
     */
    public function __construct(
        array $attributes,
        public int $engine_delay_time,
        public int $max_health,
        public int $max_inhabitant_count,
        public int $max_decoration_count,
        public DateTimeImmutable $gaia_curr_time,
    ) {
        /** @var Collection<int, Attribute> $mapped */
        $mapped = Collection::make($attributes)->map(
            fn(array $attribute, int|string $id)
                => Environment::serializer()
                ->denormalize(['id' => $id, ...$attribute], Attribute::class),
        );

        $this->attributes = $mapped;
    }
}
