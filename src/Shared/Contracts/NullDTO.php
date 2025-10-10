<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Contracts;

abstract class NullDTO implements DTOInterface
{
    public static function fromArray($data): static
    {
        return new static;
    }

    public function isNull(): bool
    {
        return true;
    }
}
