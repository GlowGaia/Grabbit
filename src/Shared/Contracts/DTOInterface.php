<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Contracts;

interface DTOInterface
{
    public static function fromArray($data): self;
}
