<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Shared\Contracts\DTO;
use Illuminate\Support\Collection;

class Attribute extends DTO
{
    public function __construct(
        public string $name,
        public string $min_value,
        public string $max_value,
        public Collection $flavors,
    ) {}

    public static function fromArray($data): static
    {
        return new self(
            name: $data['name'],
            min_value: $data['min_value'],
            max_value: $data['max_value'],
            flavors: collect($data['flavors'])->transform(function ($flavor) {
                return Flavor::fromArray($flavor);
            }),
        );
    }
}
