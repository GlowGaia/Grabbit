<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class Flavor implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    public function __construct(
        public int $id,
        public string $name,
    ) {}

    public static function make(int $id, string $name): static
    {
        return new self(
            id: $id,
            name: html_entity_decode($name, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        );
    }

    public static function fromArray(int $id, string $name): static
    {
        return static::make($id, $name);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
