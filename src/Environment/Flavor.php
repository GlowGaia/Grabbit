<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Shared\Contracts\DTO;

class Flavor extends DTO
{
    public function __construct(
        public string $flavor,
    ) {}

    public static function fromString(string $flavor): static
    {
        return new self(
            flavor: $flavor
        );
    }
}
