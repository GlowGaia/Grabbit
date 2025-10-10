<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\Contracts\DTO;
use Illuminate\Support\Collection;

class ItemSpecifics extends DTO
{
    public function __construct(
        public int $item_id,
        public string $name,
        public string $thumbnail,
        public string $thumbfile,
        public string $description,
        public bool $is_released,
        public Collection $variation_ids,
        public Collection $keywords,
        public string $premium_img,
    ) {}

    public static function fromArray($data): static
    {
        return new self(
            item_id: (int) $data['item_id'],
            name: $data['name'],
            thumbnail: $data['thumbnail'],
            thumbfile: $data['thumbfile'],
            description: $data['description'],
            is_released: (bool) $data['is_released'],
            variation_ids: collect($data['variation_ids'])->transform(function ($value) {
                return (int) $value;
            }),
            keywords: collect(explode(' ', ($data['keywords'] ?? ''))),
            premium_img: $data['premium_img'] ?? '',
        );
    }
}
