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

final class Inhabitant extends AbstractDTO
{
    public ?ItemSpecifics $item_specifics;
    public ?GameSpecifics $game_specifics;

    /**
     * @param  array<string, mixed>|null  $item_specifics
     * @param  array<string, mixed>|null  $game_specifics
     */
    public function __construct(
        public ?string $name,
        public int $serial,
        public ?int $inhab_health,
        public ?DateTimeImmutable $inhab_incept,
        public ?DateTimeImmutable $inhab_expires,
        public ?DateTimeImmutable $inhab_cryo,
        public ?bool $in_env,
        public int $item_id,
        public int $lifespan,
        ?array $item_specifics = null,
        ?array $game_specifics = null,
    ) {
        $this->item_specifics = isset($item_specifics)
            ? static::serializer()->denormalize(
                $item_specifics,
                ItemSpecifics::class,
            )
            : null;
        $this->game_specifics = isset($game_specifics)
            ? static::serializer()->denormalize(
                $game_specifics,
                GameSpecifics::class,
            )
            : null;
    }
}
