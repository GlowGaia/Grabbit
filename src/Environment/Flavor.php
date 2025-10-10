<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Shared\Contracts\DTO;

class Flavor extends DTO
{
    public function __construct(
        public string $flavor,
    ) {}

    public static function fromArray($data): static
    {
        return new self(
            flavor: $data,
        );
    }
}
