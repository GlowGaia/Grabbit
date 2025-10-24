<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Contracts\DTO;
use Illuminate\Support\Collection;

class Item extends DTO
{
    public function __construct(
        public ?Collection $keywords,
        public ?int $average,
        public ?Collection $minimum,
        public ?int $listings,
        public ?float $deviation,
        public ?string $name,
        public ?string $description,
        public ?string $thumbnail,
        public ?string $thumbfile,
        public ?string $class,
        public ?string $type,
        public ?string $sub_type,
        public ?int $price,
        public ?int $gpass,
        public ?int $store_id,
        public ?bool $trade_ignore,
        public ?bool $is_released,
        public ?bool $sellback_ignore,
        public ?Collection $variation_ids,
        public ?DateTimeImmutable $created,
        public ?int $item_id,
    ) {}

    public static function fromCollection($data): Item
    {
        return new self(
            keywords: collect(explode(' ', $data->get('keywords', ''))),
            average: (int) $data->get('average'),
            minimum: Collection::wrap($data['minimum'])->transform(function ($value) {
                return (int) $value;
            }),
            listings: (int) $data->get('listings'),
            deviation: (float) $data->get('deviation'),
            name: $data->get('name'),
            description: $data->get('description'),
            thumbnail: $data->get('thumbnail'),
            thumbfile: $data->get('thumbfile'),
            class: $data->get('class'),
            type: $data->get('type'),
            sub_type: $data->get('sub_type'),
            price: (int) $data->get('price'),
            gpass: (int) $data->get('gpass'),
            store_id: (int) $data->get('store_id'),
            trade_ignore: (bool) $data->get('trade_ignore'),
            is_released: (bool) $data->get('is_released'),
            sellback_ignore: (bool) $data->get('sellback_ignore'),
            variation_ids: Collection::wrap($data->get('variation_ids'))->transform(function ($value) {
                return (int) $value;
            }),
            created: $data->get('created') ? DateTimeImmutable::createFromFormat('Y-m-d', $data->get('created')) : null,
            item_id: (int) $data->get('item_id'),
        );
    }
}
