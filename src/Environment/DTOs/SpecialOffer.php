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

final class SpecialOffer extends AbstractDTO
{
    /** @var Collection<int, int> $item_list */
    public Collection $item_list;

    /**
     * @param  array<int, string>  $item_list
     */
    public function __construct(
        public int $id,
        array $item_list,
        public int $unlock_item,
        public int $reward_item,
        public bool $auto_use_item,
        public DateTimeImmutable $timeout,
    ) {
        $this->item_list = Collection::make($item_list)->map(intval(...));
    }
}
