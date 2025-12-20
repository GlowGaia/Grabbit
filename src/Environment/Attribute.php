<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Shared\Concerns\InteractsWithData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class Attribute implements Arrayable, Jsonable, JsonSerializable
{
    use InteractsWithData;

    /**
     * @param  Flavor[]  $flavors
     */
    public function __construct(
        public int $id,
        public string $name,
        public int $min_value,
        public int $max_value,
        public array $flavors,
    ) {}

    /**
     * @param  Flavor[]  $flavors
     */
    public static function make(int $id, string $name, int $min_value, int $max_value, array $flavors): static
    {
        return new self(
            id: $id,
            name: html_entity_decode($name, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            min_value: $min_value,
            max_value: $max_value,
            flavors: $flavors,
        );
    }

    public static function fromArray(int $id, array $data): static
    {
        $rawFlavors = isset($data['flavors']) && is_array($data['flavors']) ? $data['flavors'] : [];

        $flavors = [];
        foreach ($rawFlavors as $fId => $fName) {
            $flavors[] = Flavor::fromArray((int) $fId, (string) $fName);
        }

        return static::make(
            id: $id,
            name: isset($data['name']) ? (string) $data['name'] : 'Unknown',
            min_value: isset($data['min_value']) ? (int) $data['min_value'] : 0,
            max_value: isset($data['max_value']) ? (int) $data['max_value'] : 0,
            flavors: $flavors,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'min_value' => $this->min_value,
            'max_value' => $this->max_value,
            'flavors' => array_map(fn (Flavor $flavor) => $flavor->toArray(), $this->flavors),
        ];
    }
}
