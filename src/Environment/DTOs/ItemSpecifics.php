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

final class ItemSpecifics extends AbstractDTO
{
    /** @var Collection<int, int> $variation_ids */
    public Collection $variation_ids;

    /** @var Collection<int, string> $keywords */
    public Collection $keywords;

    /**
     * @param  array<int, int>  $variation_ids
     */
    public function __construct(
        public int $item_id,
        public string $name,
        public string $thumbnail,
        public string $thumbfile,
        public string $description,
        public bool $is_released,
        array $variation_ids,
        string $keywords,
        public ?string $premium_img = null,
    ) {
        $this->variation_ids = Collection::make($variation_ids);
        $this->keywords = Collection::make(explode(' ', $keywords))->filter();
    }
}
