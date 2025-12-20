<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class AttributeSetting implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    public function __construct(
        public ?int $attr_value,
        public int $attr_flavor,
    ) {}

    public static function make(
        ?int $attr_value,
        int $attr_flavor,
    ): static {
        return new self(
            attr_value: $attr_value,
            attr_flavor: $attr_flavor,
        );
    }

    public static function fromArray(array $data): static
    {
        return static::make(
            attr_value: isset($data['attr_value']) ? (int) $data['attr_value'] : null,
            attr_flavor: (int) ($data['attr_flavor'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'attr_value' => $this->attr_value,
            'attr_flavor' => $this->attr_flavor,
        ];
    }
}
