<?php

/*
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

declare(strict_types=1);

namespace GlowGaia\Grabbit\Inventory\DTOs;

use DateTimeImmutable;
use GlowGaia\Grabbit\Common\DTOs\AbstractDTO;
use Illuminate\Support\Collection;

final class Item extends AbstractDTO
{
    /** @var Collection<int, int> $variation_ids */
    public Collection $variation_ids;

    /** @var Collection<int, Minimum> $minimum */
    public Collection $minimum;

    /** @var Collection<int, string> $keywords */
    public Collection $keywords;

    /** @var Collection<int, int> $package_item_ids */
    public Collection $package_item_ids;

    /**
     * @param  int                   $item_id
     * @param  string                $name
     * @param  string                $description
     * @param  string                $thumbnail
     * @param  string                $thumbfile
     * @param  string                $class
     * @param  string                $type
     * @param  string                $sub_type
     * @param  int                   $price
     * @param  int                   $gpass
     * @param  int                   $store_id
     * @param  bool                  $trade_ignore
     * @param  bool                  $is_released
     * @param  bool                  $sellback_ignore
     * @param  DateTimeImmutable     $created
     * @param  array<int, int>       $variation_ids
     * @param  mixed                 $minimum
     * @param  string                $keywords
     * @param  int|null              $listings
     * @param  float|null            $deviation
     * @param  int|null              $average
     * @param  array<int, int>|null  $package_item_ids
     */
    public function __construct(
        public int $item_id,
        public string $name,
        public string $description,
        public string $thumbnail,
        public string $thumbfile,
        public string $class,
        public string $type,
        public string $sub_type,
        public int $price,
        public int $gpass,
        public int $store_id,
        public bool $trade_ignore,
        public bool $is_released,
        public bool $sellback_ignore,
        public DateTimeImmutable $created,
        array $variation_ids,
        mixed $minimum,
        string $keywords,
        public ?int $listings = null,
        public ?float $deviation = null,
        public ?int $average = null,
        ?array $package_item_ids = null,
    ) {
        $this->variation_ids = Collection::make($variation_ids);
        $this->package_item_ids = Collection::make($package_item_ids);

        /** @var array<int|string, mixed> $normalized */
        $normalized = self::toMinimumArray($minimum, $this->item_id);

        /** @var Collection<int, Minimum> $mapped */
        $mapped
            =
            Collection::make($normalized)->map(fn(mixed $value, int|string $id)
                => Item::serializer()
                ->denormalize(
                    ['id' => $id, 'minimum' => $value],
                    Minimum::class,
                ));

        $this->minimum = $mapped;
        $this->keywords = Collection::make(explode(' ', $keywords))->filter();
    }

    /**
     * @return array<int|string, mixed>
     */
    public static function toMinimumArray(
        mixed $minimum,
        int|string $item_id,
    ): array {
        if (is_numeric($minimum)) {
            return [$item_id => $minimum];
        }

        /** @var array<int|string, mixed> $minimum_array */
        $minimum_array = $minimum;

        return Collection::make($minimum_array)->all();
    }
}
