<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment\DTOs;

use GlowGaia\Grabbit\Common\DTOs\AbstractDTO;

final class Reward extends AbstractDTO
{
    public function __construct(
        public int $type,
        public ?int $item_id,
        public int $amount,
        public int $chance,
        public int $frequency,
        public int $cap,
    ) {}

}
