<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Items;

use DateTimeImmutable;
use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class Item implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    /**
     * @param  string[]|null  $keywords
     * @param  int[]|null  $minimum
     * @param  int[]|null  $variation_ids
     */
    public function __construct(
        public ?array $keywords,
        public ?int $average,
        public ?array $minimum,
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
        public ?array $variation_ids,
        public ?DateTimeImmutable $created,
        public ?int $item_id,
    ) {}

    /**
     * @param  string[]|null  $keywords
     * @param  int[]|null  $minimum
     * @param  int[]|null  $variation_ids
     */
    public static function make(
        ?array $keywords,
        ?int $average,
        ?array $minimum,
        ?int $listings,
        ?float $deviation,
        ?string $name,
        ?string $description,
        ?string $thumbnail,
        ?string $thumbfile,
        ?string $class,
        ?string $type,
        ?string $sub_type,
        ?int $price,
        ?int $gpass,
        ?int $store_id,
        ?bool $trade_ignore,
        ?bool $is_released,
        ?bool $sellback_ignore,
        ?array $variation_ids,
        ?DateTimeImmutable $created,
        ?int $item_id,
    ): static {
        return new self(
            keywords: $keywords,
            average: $average,
            minimum: $minimum,
            listings: $listings,
            deviation: $deviation,
            name: $name ? html_entity_decode($name, ENT_QUOTES | ENT_HTML5, 'UTF-8') : null,
            description: $description ? html_entity_decode($description, ENT_QUOTES | ENT_HTML5, 'UTF-8') : null,
            thumbnail: $thumbnail,
            thumbfile: $thumbfile,
            class: $class,
            type: $type,
            sub_type: $sub_type,
            price: $price,
            gpass: $gpass,
            store_id: $store_id,
            trade_ignore: $trade_ignore,
            is_released: $is_released,
            sellback_ignore: $sellback_ignore,
            variation_ids: $variation_ids,
            created: $created,
            item_id: $item_id,
        );
    }

    public static function fromArray(array $data): static
    {
        $payload = $data[0][2][0] ?? [];

        $keywords = null;
        if (isset($payload['keywords']) && is_string($payload['keywords'])) {
            $keywords = array_filter(explode(' ', $payload['keywords']));
        }

        $created = null;
        if (isset($payload['created']) && is_string($payload['created'])) {
            $created = DateTimeImmutable::createFromFormat('Y-m-d', $payload['created']) ?: null;
        }

        $minimum = null;
        if (isset($payload['minimum']) && is_array($payload['minimum'])) {
            $minimum = array_map(fn ($v) => (int) $v, $payload['minimum']);
        }

        $variation_ids = null;
        if (isset($payload['variation_ids']) && is_array($payload['variation_ids'])) {
            $variation_ids = array_map(fn ($v) => (int) $v, $payload['variation_ids']);
        }

        return static::make(
            keywords: $keywords,
            average: isset($payload['average']) ? (int) $payload['average'] : null,
            minimum: $minimum,
            listings: isset($payload['listings']) ? (int) $payload['listings'] : null,
            deviation: isset($payload['deviation']) ? (float) $payload['deviation'] : null,
            name: isset($payload['name']) ? (string) $payload['name'] : null,
            description: isset($payload['description']) ? (string) $payload['description'] : null,
            thumbnail: isset($payload['thumbnail']) ? (string) $payload['thumbnail'] : null,
            thumbfile: isset($payload['thumbfile']) ? (string) $payload['thumbfile'] : null,
            class: isset($payload['class']) ? (string) $payload['class'] : null,
            type: isset($payload['type']) ? (string) $payload['type'] : null,
            sub_type: isset($payload['sub_type']) ? (string) $payload['sub_type'] : null,
            price: isset($payload['price']) ? (int) $payload['price'] : null,
            gpass: isset($payload['gpass']) ? (int) $payload['gpass'] : null,
            store_id: isset($payload['store_id']) ? (int) $payload['store_id'] : null,
            trade_ignore: isset($payload['trade_ignore']) ? (bool) (int) $payload['trade_ignore'] : null,
            is_released: isset($payload['is_released']) ? (bool) (int) $payload['is_released'] : null,
            sellback_ignore: isset($payload['sellback_ignore']) ? (bool) (int) $payload['sellback_ignore'] : null,
            variation_ids: $variation_ids,
            created: $created,
            item_id: isset($payload['item_id']) ? (int) $payload['item_id'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'keywords' => $this->keywords,
            'average' => $this->average,
            'minimum' => $this->minimum,
            'listings' => $this->listings,
            'deviation' => $this->deviation,
            'name' => $this->name,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'thumbfile' => $this->thumbfile,
            'class' => $this->class,
            'type' => $this->type,
            'sub_type' => $this->sub_type,
            'price' => $this->price,
            'gpass' => $this->gpass,
            'store_id' => $this->store_id,
            'trade_ignore' => $this->trade_ignore,
            'is_released' => $this->is_released,
            'sellback_ignore' => $this->sellback_ignore,
            'variation_ids' => $this->variation_ids,
            'created' => $this->created?->format('Y-m-d'),
            'item_id' => $this->item_id,
        ];
    }
}
