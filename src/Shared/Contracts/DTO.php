<?php

declare(strict_types=1);

namespace GlowGaia\Grabbit\Shared\Contracts;

use GlowGaia\Grabbit\Shared\Helpers\RecursiveCollection;

abstract class DTO
{
    public static function fromCollection(RecursiveCollection $data): self
    {
        return new static;
    }
}
