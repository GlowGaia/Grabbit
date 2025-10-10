<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\UserEnvironment;

use GlowGaia\Grabbit\Shared\Contracts\DTO;

class AttributeSetting extends DTO
{
    public function __construct(
        public ?int $attr_value,
        public int $attr_flavor,
    ) {}

    public static function fromArray($data): static
    {
        return new self(
            attr_value: (int) $data['attr_value'] ?? null,
            attr_flavor: (int) $data['attr_flavor'],
        );
    }
}
