<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Inventory\DTOs;

use GlowGaia\Grabbit\Common\DTOs\AbstractDTO;

final class Minimum extends AbstractDTO
{
    public function __construct(
        public int $id,
        public int $minimum,
    ) {}

}
