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

final class GameSpecifics extends AbstractDTO
{
    /** @var Collection<int, Reward> $rewards */
    public Collection $rewards;

    /**
     * @param  array<int, array<string, mixed>>  $rewards
     */
    public function __construct(
        public int $drop_type,
        array $rewards,
    ) {
        $this->rewards = Collection::make($rewards)->map(
            fn(array $reward)
                => static::serializer()->denormalize(
                $reward,
                Reward::class,
            ),
        );
    }
}
