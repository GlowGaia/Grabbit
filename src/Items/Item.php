<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Contracts\DTO;
use Illuminate\Support\Collection;

class Item extends DTO
{
    public function __construct(
        public Collection $keywords,
        public int $average,
        public Collection $minimum,
        public int $listings,
        public float $deviation,
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
        public Collection $variation_ids,
        public DateTimeImmutable $created,
        public int $item_id,
    ) {}

    public static function fromArray($data): static
    {
        return new self(
            keywords: collect(explode(' ', $data['keywords'] ?? '')),
            average: (int) $data['average'],
            minimum: Collection::wrap($data['minimum'])->transform(function ($value) {
                return (int) $value;
            }),
            listings: (int) $data['listings'],
            deviation: (float) $data['deviation'],
            name: $data['name'],
            description: $data['description'],
            thumbnail: $data['thumbnail'],
            thumbfile: $data['thumbfile'],
            class: $data['class'],
            type: $data['type'],
            sub_type: $data['sub_type'],
            price: (int) $data['price'],
            gpass: (int) $data['gpass'],
            store_id: (int) $data['store_id'],
            trade_ignore: (bool) $data['trade_ignore'],
            is_released: (bool) $data['is_released'],
            sellback_ignore: (bool) $data['sellback_ignore'],
            variation_ids: Collection::wrap($data['variation_ids'])->transform(function ($value) {
                return (int) $value;
            }),
            created: DateTimeImmutable::createFromFormat('Y-m-d', $data['created']),
            item_id: (int) $data['item_id'],
        );
    }
}
