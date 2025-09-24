<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Environment;

use GlowGaia\Grabbit\Shared\Contracts\DTOInterface;

class Flavor implements DTOInterface
{
    public function __construct(
        public string $flavor,
    ) {}

    public static function fromArray($data): self
    {
        return new self(
            flavor: $data,
        );
    }
}
