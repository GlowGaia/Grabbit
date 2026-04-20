<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\DTOs;

use GlowGaia\Grabbit\Common\DTOs\AbstractDTO;
use Illuminate\Support\Collection;

final class Attribute extends AbstractDTO
{
    /** @var Collection<int, Flavor> $flavors */
    public Collection $flavors;

    /**
     * @param  array<int|string, mixed>  $flavors
     */
    public function __construct(
        public int $id,
        public string $name,
        public int $min_value,
        public int $max_value,
        array $flavors,
    ) {
        /** @var Collection<int, Flavor> $mapped */
        $mapped
            = Collection::make($flavors)->map(fn(mixed $flavor, int|string $id)
            => static::serializer()
            ->denormalize(['id' => $id, 'name' => $flavor], Flavor::class));

        $this->flavors = $mapped;
    }
}
