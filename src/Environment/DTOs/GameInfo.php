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
use GlowGaia\Grabbit\Environment\Enums\State;

final class GameInfo extends AbstractDTO
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
        public int $player_count,
    ) {}

}
