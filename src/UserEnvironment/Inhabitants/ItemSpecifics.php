<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment\Inhabitants;

use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class ItemSpecifics implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    /**
     * @param  int[]  $variation_ids
     * @param  string[]  $keywords
     */
    public function __construct(
        public int $item_id,
        public string $name,
        public string $thumbnail,
        public string $thumbfile,
        public string $description,
        public bool $is_released,
        public array $variation_ids,
        public array $keywords,
        public string $premium_img,
    ) {}

    /**
     * @param  int[]  $variation_ids
     * @param  string[]  $keywords
     */
    public static function make(
        int $item_id,
        string $name,
        string $thumbnail,
        string $thumbfile,
        string $description,
        bool $is_released,
        array $variation_ids,
        array $keywords,
        string $premium_img,
    ): static {
        return new self(
            item_id: $item_id,
            name: $name,
            thumbnail: $thumbnail,
            thumbfile: $thumbfile,
            description: $description,
            is_released: $is_released,
            variation_ids: $variation_ids,
            keywords: $keywords,
            premium_img: $premium_img,
        );
    }

    public static function fromArray(array $data): static
    {
        $keywords = isset($data['keywords']) && is_string($data['keywords'])
            ? array_filter(explode(' ', $data['keywords']))
            : [];

        $variation_ids = isset($data['variation_ids']) && is_array($data['variation_ids'])
            ? array_map(fn ($id) => (int) $id, $data['variation_ids'])
            : [];

        return static::make(
            item_id: (int) ($data['item_id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            thumbnail: (string) ($data['thumbnail'] ?? ''),
            thumbfile: (string) ($data['thumbfile'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            is_released: (bool) (int) ($data['is_released'] ?? 0),
            variation_ids: $variation_ids,
            keywords: array_values($keywords),
            premium_img: (string) ($data['premium_img'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'item_id' => $this->item_id,
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'thumbfile' => $this->thumbfile,
            'description' => $this->description,
            'is_released' => $this->is_released,
            'variation_ids' => $this->variation_ids,
            'keywords' => $this->keywords,
            'premium_img' => $this->premium_img,
        ];
    }
}
